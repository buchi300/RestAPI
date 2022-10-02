<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../config/Database.php';
  include_once '../models/Profile.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Profile object
  $profile = new Profile($db);

  // Profile read query
  $result = $profile->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if it contains any profile
  if($num > 0) {
        // profile array
        $profile_arr = array();
        $profile_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $profile_item = array(
            'profile_id' => $profile_id,
            'name' => $name
          );

          // Push to "data"
          array_push($profile_arr['data'], $profile_item);
        }

        // Turn to JSON & output
        echo json_encode($profile_arr);

  } else {
        // No Profile
        echo json_encode(
          array('message' => 'No Profile Found')
        );
  }
