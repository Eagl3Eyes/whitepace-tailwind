<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div class="flex">
        <div class="w-64 h-screen bg-blue-900 text-white flex flex-col">
            <div class="p-6 text-center font-bold text-xl border-b border-gray-700">
                Admin Dashboard
            </div>
            <div class="flex-grow">
                <ul class="mt-4 space-y-2">
                    <li class="px-6 py-2 hover:bg-blue-700">
                        <a href="admin-dashboard.php" class="block">Dashboard</a>
                    </li>
                    <li class="px-6 py-2 hover:bg-blue-700">
                        <a href="manage-plans.php" class="block">Manage Plans</a>
                    </li>
                    <!-- Add more links here -->
                </ul>
            </div>
            <div class="p-6 border-t border-gray-700">
                <a href="logout.php" class="block text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded">Logout</a>
            </div>
        </div>

        

</body>
</html>


