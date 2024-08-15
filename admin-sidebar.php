<?php

// Assuming you have a session variable for user role
if (!isset($_SESSION['role'])) {
    // Redirect to login if no session or role is set
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['role']; // This should be set during login
?>

<!-- Sidebar -->
<div class="w-64 h-screen bg-blue-900 text-white flex flex-col">
    <div class="p-6 text-center font-bold text-xl border-b border-gray-700">
        Admin Dashboard
    </div>
    <div class="flex-grow">
        <ul class="mt-4 space-y-2">
            <li class="px-6 py-2 hover:bg-blue-700">
                <a href="admin-dashboard.php" class="block">Dashboard</a>
            </li>

            <?php if ($user_role === 'admin'): ?>
                <li class="px-6 py-2 hover:bg-blue-700">
                    <a href="manage-plans.php" class="block">Manage Plans</a>
                </li>
                <li class="px-6 py-2 hover:bg-blue-700">
                    <a href="manage-user.php" class="block">Manage User</a>
                </li>
            <?php else: ?>
                <li class="px-6 py-2 hover:bg-blue-700">
                    <a href="view-cart.php" class="block">Cart</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="p-6 border-t border-gray-700">
        <a href="logout.php" class="block text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded">Logout</a>
    </div>
</div>