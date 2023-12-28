<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "ambulance_service";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to delete user or driver
// Function to delete driver and related vehicle
function deleteDriverAndUser($conn, $userIdToDelete)
{
    // Get the driver's associated vehicle ID and user ID
    $getDriverInfoQuery = "SELECT * FROM drivers WHERE UserID = $userIdToDelete";
    $getDriverresult = mysqli_query($conn, $getDriverInfoQuery);
    if ($getDriverresult->num_rows > 0) {
    $getDriverRow = mysqli_fetch_assoc($getDriverresult);
    $driverId = $getDriverRow['DriverID'];

    // Delete from the vehicles table first
    // if ($driverId) {
    //     $deleteVehicleQuery = "DELETE FROM vehicles WHERE VehicleID = $vehicleId";
    //     mysqli_query($conn, $deleteVehicleQuery);
    // }
    $deleteVehicleQuery = "DELETE FROM vehicles WHERE DriverID = $driverId";
    mysqli_query($conn, $deleteVehicleQuery);
    // Then delete from the drivers table
    $deleteDriverQuery = "DELETE FROM drivers WHERE DriverID = $driverId";
    mysqli_query($conn, $deleteDriverQuery);

    // Finally, delete from the users table
    }
    
}

// Check if the delete button is clicked
if (isset($_GET['delete'])) {
    $userIdToDelete = $_GET['delete'];
    deleteDriverAndUser($conn, $userIdToDelete);
    $deleteUserQuery = "DELETE FROM users WHERE UserID = $userIdToDelete";
    mysqli_query($conn, $deleteUserQuery);
    // Optionally, you can perform additional actions, if needed
    // ...

    header("Location: admin.php");
    exit();
}

// Fetch user information
$userQuery = "SELECT * FROM users";
$userResult = mysqli_query($conn, $userQuery);

// Fetch driver information with related user details
$driverQuery = "SELECT drivers.DriverID, drivers.LicenseNumber, users.* FROM drivers JOIN users ON drivers.UserID = users.UserID";
$driverResult = mysqli_query($conn, $driverQuery);

// Check if the delete button is clicked
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
        }

        main {
            padding: 30px 0;
        }

        .admin-table {
            max-width: 1000px;
            margin: auto;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<!-- Header section -->
<header class="text-center">
    <h1>Admin Dashboard</h1>
</header>

<!-- Main content section -->
<main class="container">

    <!-- Users and Drivers Table section -->
    <section class="admin-table">
        <h2>Users Information</h2>
        <!-- Users Table -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>Is Driver</th>
                <th>NID Number</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($user = mysqli_fetch_assoc($userResult)) : ?>
                <tr>
                    <td><?= $user['UserID'] ?></td>
                    <td><?= $user['FirstName'] ?></td>
                    <td><?= $user['LastName'] ?></td>
                    <td><?= $user['PhoneNumber'] ?></td>
                    <td><?= $user['Email'] ?></td>
                    <td><?= $user['Address'] ?></td>
                    <td><?= $user['IsDriver'] ? 'Yes' : 'No' ?></td>
                    <td><?= $user['NIDNumber'] ?></td>
                    <td>
                        <a href="?delete=<?= $user['UserID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Drivers Information</h2>
        <!-- Drivers Table -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Driver ID</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Address</th>
                <th>License Number</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($driver = mysqli_fetch_assoc($driverResult)) : ?>
                <tr>
                    <td><?= $driver['DriverID'] ?></td>
                    <td><?= $driver['UserID'] ?></td>
                    <td><?= $driver['FirstName'] ?></td>
                    <td><?= $driver['LastName'] ?></td>
                    <td><?= $driver['PhoneNumber'] ?></td>
                    <td><?= $driver['Email'] ?></td>
                    <td><?= $driver['Address'] ?></td>
                    <td><?= $driver['LicenseNumber'] ?></td>
                    <td>
                        <a href="?delete=<?= $driver['UserID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this driver?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Footer section -->
<footer class="text-center">
    <p>&copy; 2023 Your Ambulance Service. All rights reserved.</p>
</footer>

<!-- Bootstrap JS and Popper.js links (required for Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
