<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Profile.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $profile = new Profile($db);

  // Get ID
  $profile->profile_id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $profile->read_single();

  // Create array
  $profile_arr = array(
    'id' => $profile->profile_id,
    'name' => $profile->name,
    'gender'=>$profile->gender,
    'email'=>$profile->email,
    'intro'=>$profile->intro
  );

  // Make JSON
  print_r(json_encode($profile_arr));
