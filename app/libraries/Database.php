<?php
  /**
   * PDO DATABASE CLASS
   * CONNECT TO DATABASE
   * CREAT PREPARED STATEMENTS
   * BIND VLAUES
   * RETURN ROWS AND RESULTS
   */

   class Database {
     private $host = DB_HOST;
     private $user = DB_USER;
     private $pass = DB_PASS;
     private $dbname = DB_NAME;
     
     private $dbh;
     private $stmt;
     private $erorr;

     public function __construct() {
       // set DSN
       $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
       $options = array(
         PDO::ATTR_PERSISTENT => TRUE,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
       );

       // CREATE NEW PDO INSTANCE
       try {
         $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);

       } catch (PDOException $e) {
          $this->error = $e->getMessage();
          echo $this->error;
       }

    }
    
    // PREPARE STATEMENTS WITH QUERY
    public function query($sql) {
      $this->stmt = $this->dbh->prepare($sql);
    }

    // BIND THE VALUES
    public function bind($param, $value, $type = null)
    {
      if (is_null($type)) {
          switch(true) {
            case is_int($value):
              $type = PDO::PARAM_INT;
              break;
            case is_bool($value):
              $type = PDO::PARAM_BOOL;
              break;
            case is_null($value):
              $type = PDO::PARAM_NULL;
              break;
            default:
              $type = PDO::PARAM_STR;
          }
      }

      $this->stmt->bindValue($param, $value, $type);
    }

    // EXCUTE THE PREPARED STATEMENT
    public function excute(){
      return $this->stmt->execute();
    }

    // GET RESULT SET AS ARRAY OF OBJECT
    public function resultSet() {
      $this->excute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // GET SINGLE RECORD AS OBJ
    public function single(){
      $this->excute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // GET ROW COUNT
    public function rowCount() {
      return $this->stmt->rowCount(); 
    }

   }