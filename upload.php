<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HKIT Project Showcase</title>
</head>

<body>
    <a href="index.php">Back to Index</a><br />
    <?php

    require_once("session.php");
    require_once("project_showcase_config.php");
    require_once("connectDB.php");
    confirm_is_admin();




    if (isset($_POST["submit"])) {

        $title = $_POST["title"];
        $category = $_POST["category"];
        $description = $_POST["description"];

        $target_dir = "uploads/";
        $file_name = basename($_FILES["file"]["name"]);
        $target_file_path = $target_dir . $file_name;
        //prepare query string

        if (copy($_FILES["file"]["tmp_name"], $_FILES["file"]["name"])) {
            echo "Project file upload successful.<br />";
        } else {
            echo "Project file upload failed.<br />";
        }

        $sql = "INSERT INTO projects (project_title, project_category, project_description, project_file_name) VALUES ('" . $title . "', '" . $category . "', '" . $description . "', '" . $file_name . "')";

        //perform query
        if ($databaseConnection->query($sql) === TRUE) {
            echo "Project information upload successful.<br/ >";
        } else {
            echo "Error: " . $sql . "<br/>" . $databaseConnection->error;
        }
    }




    ?>


    <form name="upload_project" method="post" action="upload.php" enctype="multipart/form-data">
        Project Title:<input type="text" name="title"><br />
        Project Category:
        <select name="category">
            <option value="Art and Design">Art and Design</option>
            <option value="Built Environment">Built Environment</option>
            <option value="Computing">Computing</option>
            <option value="Creative Media Technology">Creative Media Technology</option>
            <option value="Engineering">Engineering</option>
            <option value="Humanities">Humanities</option>
            <option value="Performing Arts">Performing Arts</option>
            <option value="Research">Research</option>
            <option value="Science">Science</option>
        </select><br />
        Project Description: <br /><textarea name="description" rows="10" cols="50"></textarea><br />
        Upload File:<input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit">

    </form>


</body>

</html>