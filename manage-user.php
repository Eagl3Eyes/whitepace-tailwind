<?php
session_start();

// Redirect to login if not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "whitespace";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$message = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = '';
    $user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : null;

    if (isset($_POST['add_user'])) {
        $username = $_POST['new_username'];
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $role = $_POST['new_role'];

        // Check for available deleted IDs
        $id = null;
        $check_deleted_sql = "SELECT id FROM deleted_users LIMIT 1";
        if ($result = $conn->query($check_deleted_sql)) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row['id'];

                // Remove from deleted_users table
                $delete_id_sql = "DELETE FROM deleted_users WHERE id = ?";
                if ($stmt = $conn->prepare($delete_id_sql)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                // Get the next available ID
                $id_sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'users'";
                if ($stmt = $conn->prepare($id_sql)) {
                    $stmt->bind_param("s", $dbname);
                    $stmt->execute();
                    $stmt->bind_result($next_id);
                    $stmt->fetch();
                    $stmt->close();
                    $id = $next_id;
                }
            }
        }

        if ($id !== null) {
            $insert_sql = "INSERT INTO users (id, username, password, role) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($insert_sql)) {
                $stmt->bind_param("isss", $id, $username, $password, $role);
                if ($stmt->execute()) {
                    $message = "New user added successfully.";
                } else {
                    $message = "Failed to add new user.";
                }
                $stmt->close();
            }
        }
        $_SESSION['message'] = $message; // Store message in session
        header('Location: manage-user.php'); // Redirect to avoid form resubmission
        exit();
    } elseif (isset($_POST['promote']) || isset($_POST['demote']) || isset($_POST['delete'])) {
        if (isset($_POST['promote'])) {
            $update_sql = "UPDATE users SET role = 'admin' WHERE id = ?";
            $action = 'promote';
        } elseif (isset($_POST['demote'])) {
            $update_sql = "UPDATE users SET role = 'user' WHERE id = ?";
            $action = 'demote';
        } elseif (isset($_POST['delete'])) {
            $update_sql = "DELETE FROM users WHERE id = ?";
            $action = 'delete';
        }

        if ($action === 'delete') {
            if ($stmt = $conn->prepare($update_sql)) {
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    // Insert deleted ID into deleted_users table
                    $insert_deleted_sql = "INSERT INTO deleted_users (id) VALUES (?)";
                    if ($stmt_deleted = $conn->prepare($insert_deleted_sql)) {
                        $stmt_deleted->bind_param("i", $user_id);
                        $stmt_deleted->execute();
                        $stmt_deleted->close();
                    }

                    $message = "User deleted successfully.";
                } else {
                    $message = "Failed to delete user.";
                }
                $stmt->close();
            }
        } else {
            if ($stmt = $conn->prepare($update_sql)) {
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    $message = $action === 'promote' ? "User promoted to admin successfully." : "User demoted to user successfully.";
                } else {
                    $message = "Failed to perform the action.";
                }
                $stmt->close();
            }
        }
        $_SESSION['message'] = $message; // Store message in session
        header('Location: manage-user.php'); // Redirect to avoid form resubmission
        exit();
    }
}

// Fetch all users
$sql = "SELECT id, username, role FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function confirmAction(action) {
            if (action === 'delete') {
                return confirm("Are you sure you want to delete this user? This action cannot be undone.");
            } else if (action === 'add') {
                return confirm("Are you sure you want to add this new user?");
            }
            return true; // Default behavior for other actions
        }
    </script>
</head>

<body class="flex bg-gray-100 text-gray-800">

    <div>
        <!-- Sidebar -->
        <?php include 'admin-sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="flex-grow p-6">
        <h1 class="text-4xl font-bold mb-6">User Management</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); // Clear the message after displaying ?>
            </div>
        <?php endif; ?>

        <!-- Add User Form -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Add New User</h2>
            <form method="post" action="" onsubmit="return confirmAction('add')">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="mb-4">
                        <label for="new_username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="new_username" id="new_username"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="new_password" id="new_password"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="new_role" id="new_role"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" name="add_user"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add User</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- User Table -->
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="w-full bg-gray-200 text-left text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">ID</th>
                    <th class="py-3 px-6">Username</th>
                    <th class="py-3 px-6">Role</th>
                    <th class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $is_admin = $row['role'] === 'admin';
                        echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                        echo "<td class='py-3 px-6'>" . $row['id'] . "</td>";
                        echo "<td class='py-3 px-6'>" . $row['username'] . "</td>";
                        echo "<td class='py-3 px-6'>" . $row['role'] . "</td>";
                        echo "<td class='py-3 px-6'>
                                <form method='post' action='' class='inline' onsubmit=\"return confirmAction('update')\">
                                    <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                    " . ($is_admin ? "<button type='submit' name='promote' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600' disabled>Promote to Admin</button>" : "<button type='submit' name='promote' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600' >Promote to Admin</button>") . "
                                    " . (!$is_admin ? "<button type='submit' name='demote' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2' >Demote to User</button>" : "<button type='submit' name='demote' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2' disabled>Demote to User</button>") . "
                                    <button type='submit' name='delete' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2' onClick=\"return confirmAction('delete')\">Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>