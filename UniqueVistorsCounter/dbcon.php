<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class DatabaseHelper{

  protected $servername;
  protected $username;
  protected $password;
  protected $database;
  protected $con;

  function __construct(){
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "root";
    $this->database = "iti_UniqueVisitorCounter";
    $this->getConnection();
  }

  function getConnection(){
      // Create connection
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

      // Check connection
      if ($this->conn->connect_error) {
          die("Connection failed: " . $this->conn->connect_error);
      }
      else{
        //echo "Connected Successfully";
      }
  }

  function __destruct(){
    $this->closeConnection();
  }

  function closeConnection(){
    $this->conn->close();
  }

  function checkExist($userIP){
    //echo $email, $pass;
    $sql = "SELECT * FROM `visitors` WHERE userIP = '$userIP'";
    $result = $this->conn->query($sql);
    //var_dump($result);
    if ($result->num_rows > 0) {
        return true;
    } else {
        $this->addUserIP($userIP);
        return false;
    }
  }

  function addUserIP($userIP){
    $sql = "INSERT INTO `visitors` (`userIP`) VALUES ('$userIP');";
    if ($this->conn->query($sql) === TRUE) {
        //echo "Record Added successfully";
        return true;
    } else {
        //echo "Error Adding record: " . $this->conn->error;
        echo $this->conn->error;
    }
  }

  function getTotalCounter(){
    $sql = "SELECT COUNT(*) FROM `visitors`";
    $result = $this->conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->num_rows;
    }
  }

}
?>
