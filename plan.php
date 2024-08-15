<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "whitespace";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM plans";
$result = $conn->query($sql);
?>




<!-- Choose Your Plan -->

<section class="mt-48">
    <h2 class="text-center text-6xl font-bold">Choose <span
            class="bg-[url('images/strock_your_plan.png')] bg-no-repeat bg-bottom">Your Plan</span></h2>
    <p class="text-center mt-4 ml-4 mr-4 lg:ml-0 lg:mr-0">Whether you want to get organized, keep your personal life on
        track, or boost workplace productivity, Evernote has the <br> right plan for you.</p>

    <div class="mt-8 flex flex-col flex-wrap lg:flex-row justify-center items-center gap-10">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $features = explode(',', $row['features']); // Split features into an array
                echo '<div class="p-8 ml-4 mr-4 lg:ml-0 lg:mr-0 w-[350px] h-[570px] lg:w-[472px] lg:h-[550px] border rounded-md border-amber-200">';
                echo '<div class="m-4">';
                echo '<h3 class="text-3xl font-bold">' . $row['name'] . '</h3>';
                echo '<h2 class="font-bold text-3xl mt-4"><i class="fa-solid fa-dollar-sign"></i>' . $row['price'] . '</h2>';
                echo '<p class="mt-4 font-bold">' . $row['description'] . '</p>';
                foreach ($features as $feature) {
                    echo '<p class="mt-2"><i class="fa-regular fa-circle-check"></i> ' . trim($feature) . '</p>';
                }
                echo '<button class="mt-4 px-2 py-1 border rounded-md border-amber-200 hover:bg-[#ffe492]">' . $row['button_text'] . '</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No plans found.";
        }
        $conn->close();
        ?>
    </div>
</section>