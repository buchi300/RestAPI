<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../config/Database.php';
  include_once '../models/Profile.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $profile = new Profile($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  
  $profile->name = $data->name;
  $profile->gender =$data->gender;
  $profile->email= $data->email;
  $profile->intro=$data->intro;

  // Create Category
  if($profile->create()) {
    echo json_encode(
      array('message' => 'New Profile Created')
    );
  } else {
    echo json_encode(
      array('message' => 'No Profile Created')
    );
  }
