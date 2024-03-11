<?php
class User implements UserInterface{
    public $name;
    private $email;

    public function __construct($name, $email){// initializes the properties
        $this -> name =  $name;
        $this -> email = $email;
    }

// Public methods to access and modify encapsulated properties (getters and setters)
    public function get_email(){// access the priate email
        return $this-> email;
    }
    public function set_email($new_email) {
        $this->email = $new_email;
    }


    public function greet(){
        echo 'Hello, my name is ' . $this -> name;
    }
    
    
    
}
    

class Admin extends User {
  public $permissions; // New property specific to admins

  public function __construct($name, $email, $permissions) {
    parent::__construct($name, $email); // Call the parent constructor
    $this->permissions = $permissions;
  }

  public function grant_access($resource) {
    // Method specific to admins, utilizing their permissions
    echo "Admin " . $this->name . " granted access to " . $resource . "!";
  }
}


interface UserInterface {
  public function greet(); // Define a common method in the interface
}



class Admin extends User implements UserInterface {
  public function greet() {
    echo "Greetings, I'm the administrator, " . $this->name . "!";
  }
}

function say_hello(UserInterface $user) {
  // Polymorphic behavior - calls the object's specific greet method
  $user->greet();
}

$user1 = new User("John Doe", "johndoe@example.com");
$admin1 = new Admin("Jane Smith", "admin@example.com");

say_hello($user1); // Calls User::greet
echo "<br>";
say_hello($admin1); // Calls Admin::greet (due to polymorphism)
























$admin1 = new Admin("Jane Doe", "admin@example.com", ["manage_users", "edit_content"]);

$admin1->greet(); // Inherited from User
echo "<br>";

$admin1->grant_access("manage users"); // Specific to Admins







$user1 = new User("Mike", 'mike@gmail.com');
// $user1->greet();