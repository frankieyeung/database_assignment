<?php    
    session_start();
    require_once  ("connectDB.php");

    function logged_on()
    {
        return isset($_SESSION['userid']);
    }

    function confirm_is_admin() {
        if (!logged_on())
        {
            header ("Location: login.php");
        }

        if (!is_admin())
        {
            header ("Location: index.php");
        }
    }

    function confirm_is_user() {
        if (!logged_on())
        {
            header ("Location: login.php");
        }

    }


    function is_admin()
    {
        global $databaseConnection;
        $query = "SELECT user_id FROM users_in_roles UIR INNER JOIN roles R on UIR.role_id = R.id WHERE R.name = 'admin' AND UIR.user_id = ? LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $_SESSION['userid']);
        $statement->execute();
        $statement->store_result();
        return $statement->num_rows == 1;
    }

    function is_user()
    {
        global $databaseConnection;
        $query = "SELECT user_id FROM users_in_roles UIR INNER JOIN roles R on UIR.role_id = R.id WHERE R.name = 'user' AND UIR.user_id = ? LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $_SESSION['userid']);
        $statement->execute();
        $statement->store_result();
        return $statement->num_rows == 1;
    }

