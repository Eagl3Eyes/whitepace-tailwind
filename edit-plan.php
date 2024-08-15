<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "whitespace";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing plan details
    $sql = "SELECT * FROM plans WHERE id=$id";
    $result = $conn->query($sql);
    $plan = $result->fetch_assoc();

    // Split features into an array
    $features = explode(',', $plan['features']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $features = implode(',', $_POST['features']);
    $button_text = $_POST['button_text'];

    $sql = "UPDATE plans SET name='$name', price='$price', description='$description', features='$features', button_text='$button_text' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Plan updated successfully";
        header("Location: admin-dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function addFeatureInput() {
            const container = document.getElementById('features-container');
            const inputGroup = document.createElement('div');
            inputGroup.className = 'mb-4 flex space-x-2';
            inputGroup.innerHTML = `
                <input type="text" name="features[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="removeFeatureInput(this)">Remove</button>
            `;
            container.appendChild(inputGroup);
        }

        function removeFeatureInput(button) {
            button.parentElement.remove();
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold text-center mb-8">Edit Plan</h1>
        <form method="post" action="" class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
            <input type="hidden" name="id" value="<?php echo $plan['id']; ?>">

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                <input type="text" name="name" id="name" value="<?php echo $plan['name']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="<?php echo $plan['price']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" name="description" id="description" value="<?php echo $plan['description']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="features" class="block text-sm font-medium text-gray-700">Features</label>
                <div id="features-container">
                    <?php foreach ($features as $feature): ?>
                        <div class="mb-4 flex space-x-2">
                            <input type="text" name="features[]" value="<?php echo trim($feature); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="removeFeatureInput(this)">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-2" onclick="addFeatureInput()">Add Feature</button>
            </div>

            <div class="mb-4">
                <label for="button_text" class="block text-sm font-medium text-gray-700">Button Text</label>
                <input type="text" name="button_text" id="button_text" value="<?php echo $plan['button_text']; ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="flex justify-end">
                <input type="submit" value="Update Plan" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            </div>
        </form>
        <div class="flex justify-center mt-4">
            <a href="manage-plans.php" class="text-blue-500 hover:underline">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
