<?php     
require_once ("session.php");
require_once ("project_showcase_config.php");
require_once ("connectDB.php");
include("header.php");
confirm_is_admin();

$pageId = null;
$project_title = null;
$project_category = null;
$project_description = null;

if(isset($_GET['id']))
{
    $pageId = $_GET['id'];
    $query = "SELECT project_title, project_category, project_description FROM projects WHERE id = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $pageId);
    $statement->execute();
    $statement->store_result();

    if ($statement->error)
    {
        die('資料庫查詢錯誤: ' . $statement->error);
    }

    $pageExists = $statement->num_rows == 1;
    if ($pageExists)
    {
        $statement->bind_result($project_title, $project_category, $project_description);
        $statement->fetch();
    }
    else
    {
        header("Location: index.php");
    }
}
else if (isset($_POST["submit"])) {

    $pageId = $_POST['pageId'];
    $title = $_POST["title"];
    $category = $_POST["category"];
    $description = $_POST["description"];

    $target_dir = "uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file_path = $target_dir . $file_name;
    //prepare query string

    if (copy($_FILES["file"]["tmp_name"], $_FILES["file"]["name"])) {
        echo "Project file update successful.<br />";
    } else {
        echo "Project file update failed.<br />";
    }

    $query = "UPDATE projects SET project_title = ?, project_category = ?, project_description = ?, project_file_name = ? WHERE Id = ?";

    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('ssssd', $title, $category, $description, $file_name, $pageId);
    $statement->execute();
    $statement->store_result();
   

    //perform query
    if ($statement->error)
    {
        die('資料庫查詢錯誤: ' . $statement->error);
    }

    $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
    if ($creationWasSuccessful)
    {
        header ("Location: index.php");
    }
    else
    {
        echo '錯誤: 編輯頁面錯誤...';
    }
}
else
{
    header ("Location: index.php");
}
?>
 <form name="update_project" method="post" action="editproject.php" enctype="multipart/form-data">
        Project Title:<input type="text" name="title" value="<?php echo $project_title; ?>" /><br>
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
        Project Description: <br /><textarea name="description" rows="10" cols="50"><?php echo $project_description; ?></textarea><br />
        Upload File:<input type="file" name="file" /><br />
        <input type="hidden" id="pageId" name="pageId" value="<?php echo $pageId; ?>" />
        <input type="submit" name="submit" value="Update">

    </form> <!-- End of outer-wrapper which opens in header.php -->


