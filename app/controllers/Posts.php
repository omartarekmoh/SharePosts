<?php
  class Posts extends Controller {
    public function __construct() {
      if(!isLoggedIn()) {
        redirect('users/login');
      }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');
    }

    public function index() {
      // Get Posts
      $posts = $this->postModel->getPosts();

      $data = [
        'posts' => $posts
      ];

      $this->view('posts/index', $data);
    }

    public function add() {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // SANETIZE POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
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
          if($this->postModel->addPost($data)) {
            flash('post_message', 'Post added');
            redirect('posts');
          } else {
            die("Something Went Wrong");
          }
        } else {
          $this->view('posts/add', $data);
        }


      } else {
        $data = [
          'title' => '',
          'body' => '',
          'title_err' => '',
          'body_err' => ''
        ];
        $this->view('posts/add', $data);
      }
      
    }

    public function edit($id) {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // SANETIZE POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
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
          if($this->postModel->updatePost($data)) {
            flash('post_message', 'Post Updated');
            redirect('posts');
          } else {
            die("Something Went Wrong");
          }
        } else {
          $this->view('posts/edit', $data);
        }


      } else {
        // GET existing post model
        $post = $this->postModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id'] && $_SESSION['user_id'] != 1) {
          redirect('post');
        }
        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body,
          'title_err' => '',
          'body_err' => ''
        ];
        $this->view('posts/edit', $data);
      }
      
    }

    public function show($id) {
      
      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);
      $comments = $this->postModel->getComments($id);
      
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // SANETIZE POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'post' => $post,
          'user' => $user,
          'comments' => $comments,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'post_id' => $id,
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
          if($this->postModel->addComment($id, $_SESSION['user_id'], $data['body'], $data['title'])) {
            flash('comment_message', 'Comment added');
            $comments = $this->postModel->getComments($id);

            $data = [
              'post' => $post,
              'post_id' => $id,
              'comments' => $comments,
              'user' => $user,
              'title' => '',
              'body' => '',
              'title_err' => '',
              'body_err' => ''
            ];
            $this->view('posts/show', $data);
            
          } else {
            die("Something Went Wrong");
          }

        } else {
          $this->view('posts/show', $data);
        }


      } else {
        $data = [
          'post' => $post,
          'post_id' => $id,
          'comments' => $comments,
          'user' => $user,
          'title' => '',
          'body' => '',
          'title_err' => '',
          'body_err' => ''
        ];
        
        $this->view('posts/show', $data);
      }

    }

    public function delete($id) {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // GET existing post model
        $post = $this->postModel->getPostById($id);
        // check for owner
        if($post->user_id != $_SESSION['user_id']) {
          redirect('post');
        }
        if($this->postModel->deletePost($id)) {
          flash('post_message', 'Post Deleted');
          redirect('posts');
        } else {
          die("ERROR");
        }
      } else {
        redirect("posts");
      }
    }

  }