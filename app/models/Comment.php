<?php
  class Comment {
    private $db;

    public function __construct() {
      $this->db = new Database; 
    
    }

    public function updatePost($data) {
      $this->db->query('UPDATE comments SET title = :title, comment = :body WHERE id = :id');
      // Bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':body', $data['body']);
      
      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }

    public function getPostById($id) {
      $this->db->query('SELECT * FROM comments WHERE id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }

    public function deletePost($id) {
      $this->db->query('DELETE FROM comments WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $id);
      
      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }
  }