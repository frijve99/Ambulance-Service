<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Driver</title>
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

        .driver-form {
            max-width: 600px;
            margin: auto;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
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
    <h1>Become a Driver</h1>
</header>

<!-- Main content section -->
<main class="container">

    <!-- Driver Registration Form section -->
    <section class="driver-form">
        <div class="card">
            <div class="card-body">
                <!-- Driver Registration Form -->
                <form action="register_driver.php" method="post" enctype="multipart/form-data">
                    <!-- Hidden field to store the user ID -->
                    <input type="hidden" name="user_id" value="1"> <!-- Replace with the actual user ID -->

                    <!-- License Number Input -->
                    <div class="form-group">
                        <label for="licenseNumber">License Number</label>
                        <input type="text" class="form-control" id="licenseNumber" name="licenseNumber" placeholder="Enter your license number" required>
                    </div>

                    <!-- Vehicle Information Inputs -->
                    <div class="form-group">
                        <label for="vehicleNumber">Vehicle Number</label>
                        <input type="text" class="form-control" id="vehicleNumber" name="vehicleNumber" placeholder="Enter your vehicle number" required>
                    </div>

                    <div class="form-group">
                        <label for="vehicleType">Vehicle Type</label>
                        <input type="text" class="form-control" id="vehicleType" name="vehicleType" placeholder="Enter your vehicle type" required>
                    </div>

                    <div class="form-group">
                        <label for="currentLocation">Current Location</label>
                        <input type="text" class="form-control" id="currentLocation" name="currentLocation" placeholder="Enter your current location" required>
                    </div>

                    <div class="form-group">
                        <label for="availability">Availability</label>
                        <select class="form-control" id="availability" name="availability" required>
                            <option value="1">Available</option>
                            <option value="0">Not Available</option>
                        </select>
                    </div>

                    <!-- Car Image Input -->
                    <div class="form-group">
                        <label for="carImage">Car Image</label>
                        <input type="file" class="form-control-file" id="carImage" name="carImage" accept="image/*" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                </form>
            </div>
        </div>
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
