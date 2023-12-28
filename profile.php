<?php
session_start();

// Assuming you have a database connection established
$mysqli = new mysqli("localhost", "root", "", "Ambulance_Service");

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.html");
    exit();
}

// Assuming you have stored the user ID in the session variable 'user_id'
$userID = $_SESSION['user_id'];

// Fetch user information from the database
$sql = "SELECT * FROM Users WHERE UserID = $userID";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // User found, retrieve information
    $row = $result->fetch_assoc();
    $userName = $row['FirstName'] . ' ' . $row['LastName'];
    $userEmail = $row['Email'];
    $userPhoneNumber = $row['PhoneNumber'];
    $userAddress = $row['Address'];
    $isDriver = $row['IsDriver'];
    if($isDriver==1){
        $driversql = "SELECT * FROM drivers WHERE UserID = $userID";
        $driverResult = $mysqli->query($driversql);
        if ($driverResult->num_rows > 0) {
            $driverInfo = $driverResult->fetch_assoc();
            $driverID = $driverInfo["DriverID"];
        }
        $vehiclesql = "SELECT * FROM vehicles WHERE driverID = $driverID";
        $vehicleResult = $mysqli->query($vehiclesql);
        if ($vehicleResult->num_rows > 0) {
            $vehicleInfo = $vehicleResult->fetch_assoc();
        }
    }
} else {
    // User not found, handle accordingly
    echo "User not found.";
    exit();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 20px 0;
        }

        main {
            padding: 30px 0;
        }

        .user-info {
            margin-bottom: 30px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        h2, p {
            color: #333;
        }

        .card {
            border-radius: 10px;
        }

        footer {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Header section -->
<header class="text-center">
    <h1>User Profile</h1>
</header>

<!-- Main content section -->
<main class="container">

    <!-- User Information section -->
    <section class="user-info">
        <h2 class="text-center mb-4">User Information</h2>
        <!-- Display user information using Bootstrap card -->
        <div class="card">
            <div class="card-body">
                <!-- Display user information retrieved from the database -->
                <img src="./images/about.jpg" alt="User Profile" class="profile-image mx-auto d-block mb-3">
                <p class="card-text"><strong>Name:</strong> <?php echo $userName; ?></p>
                <p class="card-text"><strong>Email:</strong> <?php echo $userEmail; ?></p>
                <p class="card-text"><strong>Phone Number:</strong> <?php echo $userPhoneNumber; ?></p>
                <p class="card-text"><strong>Address:</strong> <?php echo $userAddress; ?></p>
                <!-- Button to edit user details -->
                <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#editUserModal">Edit User Details</button>
            </div>
        </div>
    </section>

</main>

<!-- Footer section -->
<!-- Become a Driver section -->
<?php if ($isDriver == 1): ?>
    <!-- Driver Information section -->
    <section class="driver-info">
        <h2 class="text-center mb-4">Driver Information</h2>
        <!-- Display driver information using Bootstrap card -->
        <div class="card">
            <div class="card-body">
                <!-- Display driver information retrieved from the database -->
                <p class="card-text"><strong>Car Type:</strong> <?php echo $vehicleInfo['Type']; ?></p>
                <p class="card-text"><strong>Location:</strong> <?php echo $vehicleInfo['CurrentLocation']; ?></p>
                <p class="card-text"><strong>License Plate:</strong> <?php echo $driverInfo['LicenseNumber']; ?></p>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Become a Driver section ... -->
    <section class="driver-option">
        <h2 class="text-center mb-4">Become a Driver</h2>
        <!-- Display the option to become a driver using Bootstrap card -->
        <div class="card">
            <div class="card-body">
                <p class="card-text">If you want to become a driver and provide ambulance services, click the button below:</p>
                <form action="update_driver_status.php" method="post">
                    <input type="hidden" name="user_id" value="1"> <!-- Replace with the actual user ID -->
                    <button type="submit" class="btn btn-success btn-block"><a href="./driver_form.php">Become a Driver</a></button>
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Footer section -->
<footer class="text-center">
    <p>&copy; 2023 Your Ambulance Service. All rights reserved.</p>
</footer>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form elements for editing user details here -->
                <form action="update_user_details.php" method="post">
                    <!-- Replace with input fields for editing user details -->
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="editName" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone Number</label>
                        <input type="tel" class="form-control" id="editPhone" name="editPhone" placeholder="Enter your phone number">
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="editAddress" placeholder="Enter your address">
                    </div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js links (required for Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
