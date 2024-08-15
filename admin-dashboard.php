<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 text-gray-800">


    <div class="flex">

        <?php
        include 'admin-sidebar.php';
        ?>


        <div class="flex-grow p-6">
            <h3 class="text-center font-bold text-3xl">Welcome to Admin Dashboard</h3>
        </div>

    </div>

</body>

</html>