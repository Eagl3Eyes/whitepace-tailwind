<?php
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

// Fetch all plans
$sql = "SELECT * FROM plans";
$result = $conn->query($sql);
?>



<?php
include 'admin-sidebar.php';
?>

<!-- Main Content -->
<div class="flex-grow p-6">
    <h1 class="text-4xl font-bold mb-8">Manage Plans</h1>
    <div class="flex justify-end mb-4">
        <a href="add-plan.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New Plan</a>
    </div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
        <thead>
            <tr class="w-full bg-gray-200 text-left text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6">ID</th>
                <th class="py-3 px-6">Name</th>
                <th class="py-3 px-6">Price</th>
                <th class="py-3 px-6">Description</th>
                <th class="py-3 px-6">Features</th>
                <th class="py-3 px-6">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                    echo "<td class='py-3 px-6'>" . $row['id'] . "</td>";
                    echo "<td class='py-3 px-6'>" . $row['name'] . "</td>";
                    echo "<td class='py-3 px-6'>" . $row['price'] . "</td>";
                    echo "<td class='py-3 px-6'>" . $row['description'] . "</td>";
                    echo "<td class='py-3 px-6'>" . $row['features'] . "</td>";
                    echo "<td class='py-3 px-6 flex space-x-4'>
                                    <a href='edit-plan.php?id=" . $row['id'] . "' class='text-blue-500 hover:underline'>Edit</a> 
                                    <a href='delete-plan.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");' class='text-red-500 hover:underline'>Delete</a>
                                  </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4'>No plans found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>


<?php
$conn->close();
?>