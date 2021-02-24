<?php
  class Comments extends Controller {
    public function __construct() {
      if(!isLoggedIn()) {
        redirect('users/login');
      }

      $this->commentModel = $this->model('Comment');
      $this->userModel = $this->model('User');
      $this->postModel = $this->model('Post');

    }

    public function edit($p, $id) {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // SANETIZE POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'p' => $p,
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'title_err' => '',
          'body_err' => ''
        ];

        // Validation title
        if(empty($data['title'])) {
          $data['title_err'] = 'Please enter a title';
        }

        // Validation body
        if(empty($data['body'])) {
          $data['body_err'] = 'Please enter a body text';
        }

        // no errors
        if(empty($data['body_err']) && empty($data['title_err'])) {
          // validated
          if($this->commentModel->updatePost($data)) {
            flash('post_message', 'Comment Updated');
            redirect('posts/show/' . $p);
          } else {
            die("Something Went Wrong");
          }
        } else {
          $this->view('comments/edit', $data);
        }


      } else {
        // GET existing post model
        $post = $this->commentModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id'] && $_SESSION['user_id'] != 1) {
          redirect('post');
        }
        $data = [
          'p' => $p,
          'id' => $id,
          'title' => $post->title,
          'body' => $post->comment,
          'title_err' => '',
          'body_err' => ''
        ];
        $this->view('comments/edit', $data);
      }
      
    }

    public function delete($p, $id) {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // GET existing post model
        $post = $this->commentModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id']) {
          redirect('post');
        }
        if($this->commentModel->deletePost($id)) {
          flash('delete_message', 'Comment Deleted');
          redirect('posts/show/' . $p);
        } else {
          die("ERROR");
        }
      } else {
        redirect("posts");
      }
    } 
  }