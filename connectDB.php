<?php  
    require_once ("project_showcase_config.php");
    require_once ("database.php");
    
    $databaseConnection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($databaseConnection->connect_error)
    {
        die("Database selection failed: " . $databaseConnection->connect_error);
    }

    prep_DB_content();
?>