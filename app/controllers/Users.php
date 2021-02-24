<?php
  class Users extends Controller{
    public function __construct() {
      $this->userModel = $this->model('User');
    }

    public function register() {
      // Check for post  
      if($_SERVER['REQUEST_METHOD'] == "POST") {
          // Process the form


          // sanatize post data
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          // init data
          $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
          ];

          // Validate Email
          if(empty($data['email'])) {
            $data['email_err'] = 'Please enter a email';
          } else {
            // Check email
            if($this->userModel->findUserByEmail($data['email'])) {
              $data['email_err'] = 'Email is already taken';
            }
          }

          // Validate Name
          if(empty($data['name'])) {
            $data['name_err'] = 'Please enter a name';
          }

          // Validate Password
          if(empty($data['password'])) {
            $data['password_err'] = 'Please enter a password';
          } elseif(strlen($data['password']) < 6) {
            $data['password_err'] = 'Password must be at least 6 characters';
          }

          // Validate Confirm Password
          if(empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Please confirm the password';
          } else {
            if($data['password'] != $data['confirm_password']) {
              $data['confirm_password_err'] = 'Passwords do not match';
            }
          }
          
          // make sure errors are empty
          if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            // validated

            // Hash Password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Register User
            if($this->userModel->register($data)) {
              flash('register_success', 'Registerd, please Login');
              redirect("users/login");
            } else {
              die("SOMETHING WENT WRONG");
            }

          } else {
            // Load view
            $this->view('users/register', $data);
          }
          
      } else {
        // init data
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',
        ];

        // laod view
        $this->view('users/register', $data);
      }
    }

    public function login() {
      if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Process the form

        // sanatize post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // init data
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
        ];

        // Validate Email
        if(empty($data['email'])) {
          $data['email_err'] = 'Please enter a email';
        }

        // Validate Password
        if(empty($data['password'])) {
          $data['password_err'] = 'Please enter a password';
        }

        // check for user/email
        if($this->userModel->findUserByEmail($data['email'])) {
          // user found

        } else {
          $data['email_err'] = "No user found";
        }

        // make sure errors are empty
        if(empty($data['email_err'])  && empty($data['password_err'])) {
          // validated
          // check and set logged in user
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser) {
            // creat session variables
            $this->createUserSession($loggedInUser);
          } else {
            $data['password_err'] = 'Password incorrect';

            $this->view('users/login', $data);
          }
        } else {
          // Load view
          $this->view('users/login', $data);
        }

      }
      else {
        // init data
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // laod view
        $this->view('users/login', $data);
      }
    }

    public function createUserSession($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;

      redirect('posts');
    }

    public function logout() {
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }

    
  }