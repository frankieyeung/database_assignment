<?php     
require_once ("session.php");
require_once ("project_showcase_config.php");
require_once ("connectDB.php");
include("header.php");
confirm_is_admin();

$pageId = null;
$menulabel = null;
$content = null;
if(isset($_GET['id']))
{
    $pageId = $_GET['id'];
    $query = "SELECT project_title, project_category, project_description, project_file_name FROM projects WHERE id = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $pageId);
    $statement->execute();
    $statement->store_result();

    if ($statement->error)
    {
        die('Error: ' . $statement->error);
    }

    $pageExists = $statement->num_rows == 1;
    if ($pageExists)
    {
        $statement->bind_result($menulabel, $content);
        $statement->fetch();
    }
    else
    {
        header("Location: index.php");
    }
}
else if (isset($_POST['submit']))
{
    $pageId = $_POST['pageId'];
    $menulabel = $_POST['menulabel'];
    $content = $_POST['content'];
    $query = "UPDATE projects SET project_title = ?, project_category = ?, project_description = ?, project_file_name =? WHERE Id = ?";

    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('ssd', $menulabel, $content, $pageId);
    $statement->execute();
    $statement->store_result();

    if ($statement->error)
    {
        die('Error: ' . $statement->error);
    }

    $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
    if ($creationWasSuccessful)
    {
        header ("Location: index.php");
    }
    else
    {
        echo 'Error';
    }
}
else
{
    header ("Location: index.php");
}
?>
    <form name="edit_project" method="post" action="editproject.php" enctype="multipart/form-data">
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
        <input type="submit" name="submit" value="Update">

    </form><!-- End of outer-wrapper which opens in header.php -->


