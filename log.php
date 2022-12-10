<?php
require_once("project_showcase_config.php");
require_once("connectDB.php");

class log
{  

    private $id;
    protected $log_action;
    protected $username;
    protected $page;
    protected $ip;
    protected $log_name;
    private $user_id;

    public function __construct(string $log_action, string $username, string $log_name)
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        if(!empty($_SESSION['id'])){
            $id = $_SESSION['id'];
        } else {
            $id = 0;
        }
        $this->log_action = $log_action;
        $this->username = $username;
        $this->log_name = $log_name;
        $this->user_id = $id;
        $this->page =  basename($_SERVER['PHP_SELF']);
        $this->ip = $ip;
    }

    public function createAction()
    {
        global $databaseConnection;

        if(!    $databaseConnection) {
           echo mysqli_error($databaseConnection); die;
        }
        $sql = "INSERT INTO test_log (`log_action`,`username`,`log_name`,`page`,`user_id`,`ip`) values ('".$this->log_action."','".$this->username."','".$this->log_name."','".$this->page."','".$this->user_id."','".$this->ip."')" ;
        $sql_query = mysqli_query($databaseConnection,$sql);
        if(!$sql_query){
            echo mysqli_error($databaseConnection); die;
        }
        
    } }
    ?>