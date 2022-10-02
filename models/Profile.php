<?php 
  class Profile {
    // DB stuff
    private $conn;
    private $table = 'profile';

    // Post Properties
    /*
    profile_id;
    name;
    gender;
    email;
   intro;

    */
    public $profile_id;
    public $name;
    public $gender;
    public $email;
    public $intro;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Profile
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Profile
    public function read_single() {
          // Create query
          $query = 'SELECT *FROM ' . $this->table . '
                                    WHERE profile_id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->profile_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->profile_id = $row['profile_id'];
          $this->name = $row['name'];
          $this->gender = $row['gender'];
          $this->email = $row['email'];
          $this->intro = $row['intro'];
          
    }

    // Create Profile
    public function create() {
          // Create query
          
          $query = 'INSERT INTO ' . $this->table . ' SET  name = :name, gender = :gender, email = :email, intro =:intro ';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->gender = htmlspecialchars(strip_tags($this->gender));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->intro = htmlspecialchars(strip_tags($this->intro));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':gender', $this->gender);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':intro', $this->intro);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Profile
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
          SET  name = :name, gender = :gender, email = :email, intro =:intro
                                WHERE profile_id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->gender = htmlspecialchars(strip_tags($this->gender));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->intro = htmlspecialchars(strip_tags($this->intro));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':gender', $this->gender);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':intro', $this->intro);
          $stmt->bindParam(':id', $this->profile_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Profile
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE profile_id = :profile_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->profile_id = htmlspecialchars(strip_tags($this->profile_id));

          // Bind data
          $stmt->bindParam(':profile_id', $this->profile_id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }