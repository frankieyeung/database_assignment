<?php require_once ("session.php"); ?>

                        <?php
                        if (logged_on())
                        {
                            
                            
                            if (is_admin())
                            {
                                echo '<a href="upload.php">Upload project</a>' . "<br />";
                                echo '<a href="selectprojecttoedit.php">Edit project</a>' . "<br />";
                                echo '<a href="delete.php">Delete project</a>' . "<br />";
                                echo '<a href="logout.php">Log out</a>' . "<br />";
                            } else {
                                echo '<a href="upload.php">Upload project</a>' . "<br />";
                                echo '<a href="logout.php">Log out</a>' . "<br />";
                            }
                        }
                        else
                        {
                            echo '<a href="login.php">Log In</a>' . "<br />";
                        }
                        ?>
