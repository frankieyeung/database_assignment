<?php          
    require_once ("project_showcase_config.php"); 
    require_once  ("connectDB.php");
    include("header.php"); 
    confirm_is_admin();

    if (isset($_POST['submit']))
    {
        $project_id = $_POST['project_title'];
        $query = "DELETE FROM projects WHERE id = ?";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $project_id);
        $statement->execute();
        $statement->store_result();

        if ($statement->error)
        {
            die('Database query failed: ' . $statement->error);
        }

        // TODO: Check for == 1 instead of > 0 when page names become unique.
        $deletionWasSuccessful = $statement->affected_rows > 0 ? true : false;
        if ($deletionWasSuccessful)
        {
            echo "Project deleted.";
        }
        else
        {
            echo "Error";
        }
    }
?>

    <form action="delete.php" method="post">
                    <label for="Project Title">Project Title:</label>
                    <select id="project_title" name="project_title">
                        <option value="0">--Choose project to delete--</option>
                            <?php
                                $statement = $databaseConnection->prepare("SELECT id, project_title FROM projects");
                                $statement->execute();

                                if($statement->error)
                                {
                                    die("Database query failed: " . $statement->error);
                                }

                                $statement->bind_result($id, $project_title);
                                while($statement->fetch())
                                {
                                    echo "<option value=\"$id\">$project_title</option>\n";
                                }
                            ?>
                    </select>
                </li>
            </ol>
            <input type="submit" name="submit" value="Delete" />
            <p>
                <a href="index.php">Return to index</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
