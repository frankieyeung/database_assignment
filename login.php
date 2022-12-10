<?php   
    require_once ("session.php");
    require_once ("project_showcase_config.php"); 
    require_once ("connectDB.php");


    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT id, username FROM users WHERE username = ? AND password = SHA(?) LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows == 1)
        {
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);
            $statement->fetch();
            header ("Location: index.php");
        }
        else
        {
            echo "Username/password incorrect";
        }
    }
?>

        <form action="login.php" method="post">
                    Username: <input type="text" name="username"/> <br/>
                    Password: <input type="password" name="password"/> <br/>
            <input type="submit" name="submit" value="Log In" /> <br/>
                <a href="index.php">Back to Index</a>
    </form>

