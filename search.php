<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Ambulance_Service";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the AJAX request
if (isset($_POST["query"])) {
    $searchQuery = $_POST["query"];

    // Perform a search query that joins Ambulances and Users tables
    $sql = "SELECT vehicles.DriverID, vehicles.VehicleNumber, vehicles.Type as carType, vehicles.CurrentLocation
            FROM vehicles
            INNER JOIN drivers ON vehicles.DriverID = drivers.DriverID
            WHERE vehicles.CurrentLocation LIKE '%$searchQuery%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $userSql = $conn->prepare("SELECT users.FirstName, users.LastName, users.PhoneNumber
                        FROM drivers
                        INNER JOIN users ON users.UserID = drivers.UserID
                        WHERE drivers.DriverID = ?");
            $userSql->bind_param("i", $row['DriverID']);
            $userSql->execute();
            $userSql->bind_result($driverFName, $driverLName, $driverPhoneNumber);
            $userSql->fetch();

            echo "<tr>";
            echo "<td>" . $driverFName . " ".$driverLName.  "</td>";
            echo "<td>" . $row["CurrentLocation"] . "</td>";
            echo "<td>" . $driverPhoneNumber . "</td>";            
        //    echo "<td>" . ($row["IsAvailable"] ? 'Available' : 'Not Available') . "</td>";
            // Add more columns as needed
            echo "<td>";
            echo "<i class='fas fa-phone-alt call-icon CALL' onclick='makeCall(\"" . $driverPhoneNumber . "\")' title='Call'></i>";
            echo "<i class='fa-solid fa-plus PLUS' onclick='bookAmbulance(\"" . $driverPhoneNumber . "\")' title='Book'></i>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No results found</td></tr>";
    }
}

$conn->close();
?>
