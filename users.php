<?php

@include 'config.php';

session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_POST['save'])) {
    $UName      = $_POST['uName'];
    $UPhone     = $_POST['phone'];
    $UGender    = $_POST['gender'];
    $UPassword  = $_POST['password'];

    // // Hash the password
    // $hashedPassword = password_hash($UPassword, PASSWORD_DEFAULT);

    if (!empty($UName) && !empty($UPhone) && !empty($UGender) && !empty($UPassword)) {
        $sqlstat = $pdo->prepare('INSERT INTO users_form VALUES(null,?,?,?,?)');
        $sqlstat->execute([$UName, $UPhone, $UGender, $UPassword]);
        header('Location: users.php');
        exit;
    } else {
        echo '<div class="alert alert-danger m-2" role="alert">Error! Please fill in all fields.</div>';
    }
}

// Requetes
$sqlstate = $pdo->query('SELECT * FROM users_form');
$users = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// Delete dyal data
if (isset($_POST['delete_row'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM users_form WHERE UNum = ?');
    $deleteStmt->execute([$deleteId]);
    header('Location: users.php');
    exit;
}

// updat dyal data-------------------------------------------
if (isset($_POST['update'])) {
    try {
        $updateId = $_POST['edit_id'];
        $typeName = $_POST['uName'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];

        // // Hash password if provided
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $updateStmt = $pdo->prepare('UPDATE users_form SET UName = ?, UPhone = ?, UGender = ?, UPassword = ? WHERE UNum = ?');
        $updateStmt->execute([$typeName, $phone, $gender, $password, $updateId]);
        header('Location: users.php');
        exit;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
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
                        <a href="users.php" class="sidebar-link">
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
                        <h4 class="mb-4">Manage Users</h4>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" name="uName">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" placeholder="Phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="gender">
                                <option hidden>Gender</option>
                                <option value="MALE">MALE</option>
                                <option value="Female">FEMALE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password">
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
                                <th scope="col">UNum</th>
                                <th scope="col">UName</th>
                                <th scope="col">UPhone</th>
                                <th scope="col">UGender</th>
                                <th scope="col">UPassword</th>
                                <th scope="col">Update Data</th>
                                <th scope="col">Delete Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $st) {

                            ?>
                                <tr>
                                    <td><?= $st['UNum'] ?></td>
                                    <td><?= $st['UName'] ?></td>
                                    <td><?= $st['UPhone'] ?></td>
                                    <td><?= $st['UGender'] ?></td>
                                    <td><?= $st['UPassword'] ?></td>
                                    <!-- modal-->
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoomModal<?= $st['UNum'] ?>">
                                            Update
                                        </button>
                                        <div class="modal fade" id="editRoomModal<?= $st['UNum'] ?>" tabindex="-1" aria-labelledby="editRoomModalLabel<?= $st['UNum'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editRoomModalLabel<?= $st['UNum'] ?>">Edit Room</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post">
                                                            <div class="mb-3">
                                                                <input type="text" class="form-control" placeholder="Full Name" name="uName" value="<?= htmlspecialchars($st['UName']) ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="number" class="form-control" placeholder="Phone" name="phone">
                                                            </div>
                                                            <div class="mb-3">
                                                                <select class="form-select" name="gender">
                                                                    <option hidden>Gender</option>
                                                                    <option value="MALE">MALE</option>
                                                                    <option value="Female">FEMALE</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="password" class="form-control" placeholder="Password" name="password">
                                                            </div>
                                                            <input type="hidden" name="edit_id" value="<?= htmlspecialchars($st['UNum']) ?>">
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
                                            <input type="hidden" name="delete_id" value="<?= $st['UNum'] ?>">
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