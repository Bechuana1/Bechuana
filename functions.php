<?php // this file is all about functions

// $name = 'mike';

// function greet($name){
//     echo 'hello world' . $name;
// }

// //  greet('Mike');

// var_dump($name);

// // print_r($name);

// function loop($i){
//     if ($i <10){
//         echo $i;
//         $i++;
//     }
    
// }

// loop(0);


// function validateUser($username, $email, $password){
//     $errors = [];

//     if(empty($username)){
//         $errors = 'username cannot be empty';
//     }

//     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
//         $errors = 'Invalid email';
//     }

//     if(strlen($password)< 8){
//         $errors = 'Password should be greatter than 8 characters long';
//     }

//     return $errors;
// }

// if (empty($errors)){
//     echo 'validation successful';
// }
// else {
//     echo  json_encode(validateUser('jonhdoe', 'invalidemail@gmail.com', 12845));
// }
function calculate_cart_total($items) {
  $total = 0;
  foreach ($items as $item) {
    // echo $item['price']. '</br>'; 
    $total += $item['price'] * $item['quantity'];
  }
  return $total;
}

$cart_items = [
  ['price' => 10, 'quantity' => 2],
  ['price' => 5, 'quantity' => 1],
];

$cart_total = calculate_cart_total($cart_items);

echo "Your cart total is: $" . $cart_total;
