<?php
  class User {
    private $db;
    
    public function __construct() {
      $this->db = new Database;
    }

    // Register
    public function register($data) {
      $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');

      // Bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      
      if($this->db->excute()) {
        return TRUE;
      }

      return FALSE;
    }

    // find user by email
    public function findUserByEmail($email) {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();

      // Check Row
      if($this->db->rowCount() > 0) {
        return True;
      }
      return False;
    }

    // User login
    public function login($email, $password) {
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();

      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)) {
        return $row;
      } else {
        return false;
      }
    }

    // get User by id
    public function getUserById($id) {
      $this->db->query('SELECT * FROM users WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();

      // Check Row
      return $row;
    }

  }