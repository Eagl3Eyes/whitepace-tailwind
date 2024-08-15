<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whitepace</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/41e196d463.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
</head>

<body>
    <!-- navbar -->
    <section class="mt-8    ">
        <nav class="w-full flex flex-col lg:flex-row lg:space-x-32 justify-center items-center">
            <ul>
                <li><a href="#"><img src="images/Logo.png" alt=""></a></li>
            </ul>
            <ul class="flex flex-row mt-4 lg:mt-0 gap-4 lg:gap-10 text-[#4F9CF9]">
                <li><a class="hover:text-blue-700" href="#">Products <i class="fa-solid fa-chevron-down"></i></a></li>
                <li><a class="hover:text-blue-700" href="#">Solutions <i class="fa-solid fa-chevron-down"></i></a></li>
                <li><a class="hover:text-blue-700" href="#">Resources <i class="fa-solid fa-chevron-down"></i></a></li>
                <li><a class="hover:text-blue-700" href="#">Pricing <i class="fa-solid fa-chevron-down"></i></a></li>
            </ul>
            <ul class="flex flex-row mt-4 lg:mt-0 gap-4 lg:gap-10">
                <li><button class="px-6 py-4 rounded-lg bg-[#FFE492] text-[#043873] hover:bg-[#FFE512]">Login</button>
                </li>
                <li><button class="px-6 py-4 rounded-lg bg-[#4F9CF9] text-white hover:bg-blue-600">Try Whitepace free <i
                            class="fa-solid fa-arrow-right"></i></button></li>
            </ul>
        </nav>
    </section>