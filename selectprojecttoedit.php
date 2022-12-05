<?php         
require_once ("project_showcase_config.php");
require_once  ("connectDB.php");
include("header.php");
confirm_is_admin();

if (isset($_POST['submit']))
{
    $pageId = $_POST['pageId'];
    $query = "SELECT id FROM projects WHERE id = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $pageId);
    $statement->execute();
    $statement->store_result();

    if ($statement->error)
    {
        die('Error: ' . $statement->error);
    }

    // TODO: Check for == 1 instead of > 0 when page names become unique.
    $pageExists = $statement->num_rows == 1;
    if ($pageExists)
    {
        header ("Location: editproject.php?id=$pageId");
    }
    else
    {
        echo "Error";
    }
}
?>
<div id="main">
    <h2>編輯頁面</h2>
    <form action="selectprojecttoedit.php" method="post">
        <fieldset>
            <legend>Edit Project</legend>
            <ol>
                <li>
                    <label for="pageId">Project:</label>
                    <select id="pageId" name="pageId">
                        <option value="0">--Choose Project--</option>
                        <?php
                        $statement = $databaseConnection->prepare("SELECT id, project_title FROM projects");
                        $statement->execute();

                        if($statement->error)
                        {
                            die("error: " . $statement->error);
                        }

                        $statement->bind_result($id, $menulabel);
                        while($statement->fetch())
                        {
                            echo "<option value=\"$id\">$menulabel</option>\n";
                        }
                        ?>
                    </select>
                </li>
            </ol>
            <input type="submit" name="submit" value="Edit" />
        </fieldset>
    </form>
    <br/>
    <a href="index.php">Cancel</a>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
