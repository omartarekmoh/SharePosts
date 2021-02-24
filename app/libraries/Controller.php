<?php
  /**
   * Base controller
   * Load models and views
   */

  class Controller {
    // load Model
    public function model($model) {
      // require model file
      require_once "../app/models/" . $model . ".php";

      // instantiate model
      return new $model;
    }

    // load view
    public function view($view, $data = []) {
      // check for the view file 
      if(file_exists("../app/views/". $view. ".php")) {
        require_once "../app/views/". $view. ".php";
      }
      else {
        // view doesn't exist
        die("View doesn't exist");
      }
    }
  }