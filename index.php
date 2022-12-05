<?php 
        require_once ("project_showcase_config.php"); 
        require_once  ("connectDB.php");
        include("header.php");         
?>

<?php
$severname = "localhost";
$username = "root";
$password = "A12345678";
$database = "project_showcase";

//create connection
$conn = new mysqli($severname, $username, $password, $database);

//check connection
if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error);
}

$sql = "SELECT * FROM projects";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Project Title: " . $row["project_title"] . "<br> " . "Project Category: " . $row["project_category"] . "<br>" . "Project Description: " . $row["project_description"] . "<br>" . "Project File: " . "<a href=" . $row["project_file_name"] . ">" . $row["project_file_name"] . "</a><br><hr/>";
    }
}

?>