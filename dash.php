<?php
@include 'config.php';

// rooms data
$rooms_query = $pdo->query('SELECT * FROM rooms');
$rooms = $rooms_query->fetchAll(PDO::FETCH_ASSOC);

// categories data
$categories_query = $pdo->query('SELECT * FROM categories');
$categories = $categories_query->fetchAll(PDO::FETCH_ASSOC);

// users data
$users_query = $pdo->query('SELECT * FROM users_form');
$users = $users_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Dashboard</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
</head>

<body>

    <div class="container-fluid">
        <div class="wrapper">

            <aside id="sidebar">
                <div class="d-flex">
                    <button class="toggle-btn" type="button">
                        <i class="lni lni-grid-alt"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="admin_page.php">Menu</a>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="admin_page.php" class="sidebar-link">
                            <i class="fa-solid fa-house"></i>
                            <span>Rooms</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="categories.php" class="sidebar-link">
                            <i class="fa-solid fa-table-list"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="Customers.php" class="sidebar-link">
                            <i class="fa-brands fa-intercom"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="booking.php" class="sidebar-link">
                            <i class="fa-regular fa-bookmark"></i>
                            <span>Bookings</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash.php" class="sidebar-link">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="setting.php" class="sidebar-link">
                            <i class="fa-solid fa-gears"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="logout.php" class="sidebar-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>

            <div class="main p-3">
                <div class="text-center">
                    <h1>
                        Hotel Management System - Dashboard
                    </h1>
                </div>


                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Rooms</h5>
                                    <p class="card-text">Total Rooms: <?php echo count($rooms); ?></p>
                                    <a href="admin_page.php" class="btn btn-primary">View Rooms</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Categories</h5>
                                    <p class="card-text">Total Categories: <?php echo count($categories); ?></p>
                                    <a href="categories.php" class="btn btn-primary">View Categories</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Users</h5>
                                    <p class="card-text">Total Users: <?php echo count($users); ?></p>
                                    <a href="users.php" class="btn btn-primary">View Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script/sidebar.js"></script>
    <script src="https://kit.fontawesome.com/384cdfd76e.js" crossorigin="anonymous"></script>
</body>

</html>