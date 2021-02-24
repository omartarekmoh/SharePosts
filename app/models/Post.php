<?php
  class Post {
    private $db;

    public function __construct() {
      $this->db = new Database; 
    
    }

    public function getPosts() {
      $this->db->query('SELECT *,
                        post.id as postId,
                        users.id as userId,
                        post.created_at as postCreated,
                        users.created_at as userCreated
                        FROM post
                        INNER JOIN users
                        on post.user_id = users.id
                        ORDER BY post.id DESC
                      ');

      $results = $this->db->resultSet();

      return $results;
    }

    public function addPost($data) {
      $this->db->query('INSERT INTO post (title, user_id, body) VALUES (:title, :user_id, :body)');
      // Bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':body', $data['body']);
      
      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }

    public function getPostById($id) {
      $this->db->query('SELECT * FROM post WHERE id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }

    public function updatePost($data) {
      $this->db->query('UPDATE post SET title = :title, body = :body WHERE id = :id');
      // Bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':body', $data['body']);
      
      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }
    
    public function deletePost($id) {
      $this->db->query('DELETE FROM post WHERE id = :id');
      // Bind values
      $this->db->bind(':id', $id);
      
      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }

    public function addComment($id, $us, $comment, $title) {
      $this->db->query('INSERT INTO comments (user_id, post_id, comment, title) VALUES (:user, :post, :comment, :title)');

      // Bind values
      $this->db->bind(':user', $us);
      $this->db->bind(':post', $id);
      $this->db->bind(':comment', $comment);
      $this->db->bind(':title', $title);

      if($this->db->excute()) {
        return TRUE;
      }
      return FALSE;
    }

    public function getComments($post) {
      $this->db->query('SELECT users.name AS name, title, comment AS body, date AS postCreated, comments.id AS id, user_id, post_id FROM `comments` JOIN users ON users.id = user_id WHERE post_id = :post');

      // Bind values
      $this->db->bind(':post', $post);

      $results = $this->db->resultSet();

      return $results;
    }

    
  }
