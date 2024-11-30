<?php

session_start();

$userIdd = false;
if (isset($_SESSION['user_id'])) {
    $userIdd = $_SESSION['user_id'];
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watcho - Movies & TV Series</title>
    <?php echo ($page == 'movie') ? '<link rel="stylesheet" href="../library/videojs/video-js.css">' : ''; ?>
    <script src="<?php echo ($page == 'home') ? './frameworks/jquery-3.7.1.min.js' : '../frameworks/jquery-3.7.1.min.js'; ?>"></script>
    <?php if ($page == 'home') {
        echo '<link rel="stylesheet" href="index.css">';
    } else if ($page == 'movies') {
        echo '    <style>
        li {
            list-style-type: none;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.174);
        }


        .active-btn {
            background: white;
            color: black;
        }

        @media only screen and (min-width:1600px) {
            .hero {
                max-width: 1700px;
            }

            .primary-container {
                max-width: 1600px;
            }
        }
    </style>';
    } else if ($page == 'favorites') {
        echo '    <style>
        li {
            list-style-type: none;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.174);
        }


        .active-btn {
            background: white;
            color: black;
        }

        @media only screen and (min-width:1600px) {
            .hero {
                max-width: 1700px;
            }

            .primary-container {
                max-width: 1600px;
            }
        }
    </style>';
    } else if ($page == 'bookings') {
        echo '    <style>
        li {
            list-style-type: none;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.174);
        }


        .active-btn {
            background: white;
            color: black;
        }

        @media only screen and (min-width:1600px) {
            .hero {
                max-width: 1700px;
            }

            .primary-container {
                max-width: 1600px;
            }
        }
    </style>';
    } else if ($page == "seat_book") {
        echo '
    <style>
    .seat {
        width: 40px;
        height: 40px;
        border: 1px solid #ffff;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .seat.reserved {
        background-color: #4A4947;
        color: white;
        cursor: not-allowed;
    }

    .seat.selected {
        background-color: #008170;
        color: white;
    }


    .seat-label {
        font-weight: bold;
        text-align: center;
        background: transparent;
        color: white;
        border: none;
        cursor: text;
    }

    .screen {
        background: #4b5563;
        color: white;
        padding: 6px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
        border-radius: 4px;
    }

    .seat-space {
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    #theatre {
        justify-content: center;
        width: 100%;
    }
                @media only screen and (min-width:1600px) {
            .primary-container {
                max-width: 1600px;
            }
        }
    </style>
            ';
    } else {
        echo '
    <style>
                @media only screen and (min-width:1600px) {
            .primary-container {
                max-width: 1600px;
            }
        }
    </style>
            ';
    }
    ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <?php
    if (isset($_SESSION['user_id'])) {
        echo `
    <script>
        function sendHeartbeat() {
            $.ajax({
                url: '<?php echo ($page == 'home') ? './controllers/updateActiveTime.php' : '../controllers/updateActiveTime.php'; ?>',
                type: 'POST',
                data: {
                    user_id: <?= $userIdd ?>
                },
                success: function(response) {
                    console.log('Heartbeat sent successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('Error sending heartbeat:', error);
                }
            });
        }

        setInterval(sendHeartbeat, 20000);
        sendHeartbeat();
    </script>

`;
    }

    ?>

</head>

<body class="bg-gray-800">
    <header>
        <nav class="navbar w-full mt-2 px-4 z-50">
            <div class="container mx-auto flex justify-between items-center py-4">
                <div class="logo flex items-center gap-2">
                    <img src="<?php echo ($page == 'home') ? './assets/images/logo.png' : '../assets/images/logo.png'; ?>" alt="WATCHO Logo" class="h-8 w-8">
                    <span class="font-bold text-xl text-white">WATCHO</span>
                </div>

                <div class="lg:hidden flex items-center">
                    <button id="menu-btn" class="text-white focus:outline-none p-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path>
                        </svg>
                    </button>
                </div>
                <ul class="hidden lg:flex items-center gap-2 mx-auto text-white font-medium">
                    <li class="rounded-full <?php echo $page == 'home' ? 'bg-white' : 'bg-transparent'; ?> cursor-pointer hover:bg-white hover:text-gray-600 transition duration-300">
                        <a href="<?php echo ($page == 'home') ? './index.php' : '../index.php'; ?>" class="py-2 px-6 <?php echo $page == 'home' ? 'text-gray-900' : ''; ?> w-full h-full flex items-center justify-center">Home</a>
                    </li>
                    <li class="rounded-full <?php echo $page == 'movies' ? 'bg-white' : 'bg-transparent'; ?> cursor-pointer hover:bg-white hover:text-gray-600 transition duration-300">
                        <a href="<?php echo ($page == 'home') ? './views/movies.php' : './movies.php'; ?>" class="py-2 px-6 <?php echo $page == 'movies' ? 'text-gray-900' : ''; ?> w-full h-full flex items-center justify-center">Movies</a>
                    </li>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                    ?>
                        <li class="rounded-full <?php echo $page == 'favorites' ? 'bg-white' : 'bg-transparent'; ?> cursor-pointer hover:bg-white hover:text-gray-600 transition duration-300">
                            <a href="<?php echo ($page == 'home') ? './views/favorites.php' : './favorites.php'; ?>" class="py-2 px-6 <?php echo $page == 'favorites' ? 'text-gray-900' : ''; ?> w-full h-full flex items-center justify-center">Favorite</a>
                        </li>
                        <li class="rounded-full <?php echo $page == 'bookings' ? 'bg-white' : 'bg-transparent'; ?> cursor-pointer hover:bg-white hover:text-gray-600 transition duration-300">
                            <a href="<?php echo ($page == 'home') ? './views/bookings.php' : './bookings.php'; ?>" class="py-2 px-6 <?php echo $page == 'bookings' ? 'text-gray-900' : ''; ?> w-full h-full flex items-center justify-center">My Bookings</a>
                        </li>
                    <?php
                    }

                    ?>
                </ul>
                <div class="hidden lg:flex gap-2">
                    <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['email'])) {
                        if (isset($_SESSION['is_admin']) && (bool)$_SESSION['is_admin'] === 1 || isset($_SESSION['is_admin']) && (bool)$_SESSION['is_admin'] === true) {
                    ?>

                            <button onclick="window.location.href=(window.location.protocol+'<?php echo ($page == 'home') ? './admin/' : '../admin/'; ?>')"
                                class="py-2 px-5 bg-red-500 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                    <path d="M17.0001 12C17.5524 12 18.0001 12.4477 18.0001 13V22H16.0001V14H8.00015V22H6.00015V13C6.00015 12.4477 6.44786 12 7.00015 12H17.0001ZM12.0001 16V18H10.0001V16H12.0001ZM12.0001 6C14.3491 6 16.3827 7.34978 17.3678 9.31602L15.5787 10.2108C14.922 8.89991 13.5662 8 12.0001 8C10.4341 8 9.07833 8.89991 8.42163 10.2108L6.63247 9.31602C7.61755 7.34978 9.65122 6 12.0001 6ZM12.0001 2C15.9153 2 19.3049 4.24991 20.9466 7.5273L19.1576 8.42242C17.8443 5.80019 15.1325 4 12.0001 4C8.86783 4 6.15596 5.80019 4.84271 8.42242L3.05371 7.5273C4.69541 4.24991 8.08503 2 12.0001 2Z"></path>
                                </svg>
                                Admin Panel
                            </button>
                        <?php } ?>
                        <button onclick="window.location.href=(window.location.protocol+'<?php echo ($page == 'home') ? './controllers/logout.php' : '../controllers/logout.php'; ?>')"
                            class="py-2 px-5 bg-red-500 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                <path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path>
                            </svg>
                            Logout
                        </button>
                    <?php
                    } else {
                    ?>
                        <?php if ($page == 'login') {  ?>
                            <button onclick="window.location.href=(window.location.protocol+'./login.php')"
                                class="py-2 px-5 bg-blue-500 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                    <path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path>
                                </svg>
                                Login
                            </button>
                        <?php } else { ?>
                            <button onclick="window.location.href=(window.location.protocol+'<?php echo ($page == 'home') ? './views/login.php' : './login.php'; ?>')"
                                class="py-2 px-5 bg-blue-600 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                    <path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path>
                                </svg>
                                Login
                            </button>
                        <?php } ?>

                        <?php if ($page == 'register') {  ?>
                            <button onclick="window.location.href=(window.location.protocol+'./register.php')"
                                class="py-2 px-5 bg-purple-500 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-purple-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                    <path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path>
                                </svg>
                                Register
                            </button>
                        <?php } else { ?>
                            <button onclick="window.location.href=(window.location.protocol+'<?php echo ($page == 'home') ? './views/register.php' : './register.php'; ?>')"
                                class="py-2 px-5 bg-purple-600 rounded-full text-white text-sm flex items-center gap-2 font-semibold transition transform hover:scale-105 hover:bg-purple-700">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                    <path d="M19 10H20C20.5523 10 21 10.4477 21 11V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11C3 10.4477 3.44772 10 4 10H5V9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9V10ZM17 10V9C17 6.23858 14.7614 4 12 4C9.23858 4 7 6.23858 7 9V10H17ZM11 14V18H13V14H11Z"></path>
                                </svg>
                                Register
                            </button>
                    <?php }
                    } ?>
                </div>
                <div id="mobile-menu" class="mobile-menu bg-black/90 fixed z-[400] top-0 left-0 w-screen h-screen hidden">
                    <div class="px-4">
                        <div class="py-6 flex flex-col h-screen w-full justify-between">
                            <button id="menu-btn-close" class="text-white focus:outline-none p-2 hover:text-red-500 self-end rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path>
                                </svg>
                            </button>

                            <ul class="flex flex-col gap-2 text-gray-200 font-medium">
                                <li class="rounded <?php echo $page == 'home' ? 'bg-gray-700 text-white' : 'bg-transparent'; ?> cursor-pointer w-full hover:bg-gray-700 hover:text-white transition duration-300">
                                    <a href="<?php echo ($page == 'home') ? './index.php' : '../index.php'; ?>" class="block w-full px-4 py-4 text-left">
                                        Home
                                    </a>
                                </li>
                                <li class="rounded <?php echo $page == 'movies' ? 'bg-gray-700 text-white' : 'bg-transparent'; ?> cursor-pointer w-full hover:bg-gray-700 hover:text-white transition duration-300">
                                    <a href="<?php echo ($page == 'home') ? './views/movies.php' : './movies.php'; ?>" class="block w-full px-4 py-4 text-left">
                                        Movies
                                    </a>
                                </li>
                                <?php if (isset($_SESSION['user_id'])) { ?>
                                    <li class="rounded <?php echo $page == 'favorites' ? 'bg-gray-700 text-white' : 'bg-transparent'; ?> cursor-pointer w-full hover:bg-gray-700 hover:text-white transition duration-300">
                                        <a href="<?php echo ($page == 'home') ? './views/favorites.php' : './favorites.php'; ?>" class="block w-full px-4 py-4 text-left">
                                            Favorite
                                        </a>
                                    </li>
                                    <li class="rounded <?php echo $page == 'bookings' ? 'bg-gray-700 text-white' : 'bg-transparent'; ?> cursor-pointer w-full hover:bg-gray-700 hover:text-white transition duration-300">
                                        <a href="<?php echo ($page == 'home') ? './views/bookings.php' : './bookings.php'; ?>" class="block w-full px-4 py-4 text-left">
                                            My Bookings
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>

                            <div class="flex flex-col gap-2">
                                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['email'])) {
                                    if (isset($_SESSION['is_admin']) && (bool)$_SESSION['is_admin'] === true) { ?>
                                        <button onclick="window.location.href='<?php echo ($page == 'home') ? './admin/' : '../admin/'; ?>'" class="block w-full px-4 py-2 bg-red-500 rounded text-white font-semibold hover:bg-red-600">
                                            Admin Panel
                                        </button>
                                    <?php } ?>
                                    <button onclick="window.location.href='<?php echo ($page == 'home') ? './controllers/logout.php' : '../controllers/logout.php'; ?>'" class="block w-full px-4 py-2 bg-red-500 rounded text-white font-semibold hover:bg-red-600">
                                        Logout
                                    </button>
                                <?php } else { ?>
                                    <button onclick="window.location.href='<?php echo ($page == 'login') ? './login.php' : '../views/login.php'; ?>'" class="block w-full px-4 py-2 bg-blue-500 rounded text-white font-semibold hover:bg-blue-600">
                                        Login
                                    </button>
                                    <button onclick="window.location.href='<?php echo ($page == 'register') ? './register.php' : '../views/register.php'; ?>'" class="block w-full px-4 py-2 bg-purple-500 rounded text-white font-semibold hover:bg-purple-600">
                                        Register
                                    </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>



                <script>
                    $(document).ready(function() {
                        const menu = $(".mobile-menu");

                        $("#menu-btn").on("click", function() {
                            menu.fadeIn(300);
                        });

                        $("#menu-btn-close").on("click", function() {
                            menu.fadeOut(300);
                        });

                        $(window).on("resize", function() {
                            if ($(window).width() >= 1024) {
                                menu.hide();
                            }
                        });
                    });
                </script>

            </div>
        </nav>
    </header>