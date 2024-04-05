<?php

@include 'config.php';

session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
// save l data f database huh
if (isset($_POST['save'])) {
    $RName   = $_POST['fname'];
    $RType   = $_POST['type'];
    $RStatus = $_POST['status'];

    if (!empty($RName) && !empty($RType) && !empty($RStatus)) {
        $sqlstat = $pdo->prepare('INSERT INTO rooms VALUES(null,?,?,?)');
        $sqlstat->execute([$RName, $RType, $RStatus]);
        header('Location: admin_page.php');
        exit;
    } else {
        echo '<div class="alert alert-danger m-2" role="alert">Error! Please fill in all fields.</div>';
    }
}

// Requetes
$sqlstate = $pdo->query('SELECT * FROM rooms');
$rooms = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// Delete dyal data
if (isset($_POST['delete_row'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM rooms WHERE RNum = ?');
    $deleteStmt->execute([$deleteId]);
    header('Location: admin_page.php');
    exit;
}

// updat dyal data-------------------------------------------
if (isset($_POST['update'])) {
    try {
        $updateId = $_POST['edit_id'];
        $RName = $_POST['fname'];
        $RType = $_POST['type'];
        $RStatus = $_POST['status'];
        $updateStmt = $pdo->prepare('UPDATE rooms SET RName = ?, RType = ?, RStatus = ? WHERE RNum = ?');
        $updateStmt->execute([$RName, $RType, $RStatus, $updateId]);
        header('Location: admin_page.php');
        exit;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit;
    }
}

// Initializon dyal $room m3a l array
$room = [];

if (isset($_GET['edit_id'])) {
    $editId = $_GET['edit_id'];

    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE RNum = ?');
    $stmt->execute([$editId]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        header('Location: admin_page.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Hotel Management System</title>
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
                        Hotel Management System
                    </h1>
                </div>
                <form action="" method="post">
                    <div class="sidebar-inputs text-center">
                        <h4 class="mb-4">Manage Rooms</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="fname">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="type">
                                <option hidden>Type</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="status">
                                <option hidden>Status</option>
                                <option value="Booked">Booked</option>
                                <option value="Available">Available</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-primary" type="submit" name="filter">Filter</button>
                            <button class="btn btn-success" type="submit" name="save">Save</button>
                            <button class="btn btn-danger" type="submit" name="delete all">Delete All</button>
                        </div>
                    </div>
                </form>

                <div style="margin-top: 20px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">RNum</th>
                                <th scope="col">RName</th>
                                <th scope="col">RType</th>
                                <th scope="col">RStatus</th>
                                <th scope="col">Update Data</th>
                                <th scope="col">Delete Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rooms as $st) {

                            ?>
                                <tr>
                                    <td><?= $st['RNum'] ?></td>
                                    <td><?= $st['RName'] ?></td>
                                    <td><?= $st['RType'] ?></td>
                                    <td><?= $st['RStatus'] ?></td>
                                    <!-- modal-->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoomModal<?= $st['RNum'] ?>">
                                            Update
                                        </button>
                                        <div class="modal fade" id="editRoomModal<?= $st['RNum'] ?>" tabindex="-1" aria-labelledby="editRoomModalLabel<?= $st['RNum'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editRoomModalLabel<?= $st['RNum'] ?>">Edit Room</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="mb-3">
                                                                <input type="text" class="form-control" placeholder="Full Name" name="fname" value="<?= htmlspecialchars($st['RName']) ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <select class="form-select" name="type">
                                                                    <option hidden>Type</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <select class="form-select" name="status">
                                                                    <option hidden>Status</option>
                                                                    <option value="Booked">Booked</option>
                                                                    <option value="Available">Available</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="edit_id" value="<?= htmlspecialchars($st['RNum']) ?>">
                                                            <div class="text-center">
                                                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="delete_id" value="<?= $st['RNum'] ?>">
                                            <button class="btn btn-danger btn-sm" type="submit" name="delete_row">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                            </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script/sidebar.js"></script>
    <script src="https://kit.fontawesome.com/384cdfd76e.js" crossorigin="anonymous"></script>
</body>

</html>