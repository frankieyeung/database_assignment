<?php          
    require_once ("project_showcase_config.php"); 
    require_once  ("connectDB.php");
    include("header.php"); 
    confirm_is_admin();

    if (isset($_POST['submit']))
    {
        $username = $_POST['user'];
    $query = "DELETE FROM users_in_roles where user_id = (SELECT id FROM users WHERE username = ?);";
    $query2 = "DELETE FROM users WHERE username = ?"; 

        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('s',$username);
        $statement->execute();
        $statement->store_result();

        $statement2 = $databaseConnection->prepare($query2);
        $statement2->bind_param('s',$username);
        $statement2->execute();
        $statement2->store_result();



        if ($statement->error)
        {
            die('Database query failed: ' . $statement->error);
        }


        $deletionWasSuccessful = $statement->affected_rows > 0 ? true : false;
        if ($deletionWasSuccessful)
        {
            echo "User deleted.";
        }
        else
        {
            echo "Error";
        }
    }
?>

    <form action="deleteuser.php" method="post">
                    <select id="User" name="user">
                        <option value="0">--Choose a user to delete--</option>
                            <?php
                                $statement = $databaseConnection->prepare("SELECT username FROM users");
                                $statement->execute();

                                if($statement->error)
                                {
                                    die("Database query failed: " . $statement->error);
                                }

                                $statement->bind_result($username);
                                while($statement->fetch())
                                {
                                    echo "<option value=\"$username\">$username</option>\n";
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
</div> 
