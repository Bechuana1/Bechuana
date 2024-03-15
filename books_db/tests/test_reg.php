<?php

require_once 'reg_user.php'; // Assuming register.php is in the same directory

// Function to simulate a POST request
function simulatePost($username, $password) {
  $_SERVER['REQUEST_METHOD'] = 'POST';
  $_POST['username'] = $username;
  $_POST['password'] = $password;
}

// Test cases
$tests = [
  // Test 1: Empty username and password
  [
    'username' => '',
    'password' => '', 
    'expected_errors' => ['Username is required.', 'Password is required.'],
  ],
  // Test 2: Valid username and password (replace with actual values)
  [
    'username' => 'valid_username',
    'password' => 'strong_password',
    'expected_errors' => [], // No errors expected
  ],
];

foreach ($tests as $test) {
  global $errors, $responce; // Access global variables from register.php

  // Simulate POST request
  simulatePost($test['username'], $test['password']);

  // Run the registration logic
  require_once 'reg_user.php'; // Include register.php again to reset state

  // Check for errors
  $passed = true;
  if (!empty($test['expected_errors'])) {
    // Test expects errors
    if (!isset($responce['errors']) || $responce['errors'] !== $test['expected_errors']) {
      $passed = false;
      echo "Test failed: Unexpected error state.\n";
      echo "Actual errors: " . (isset($responce['errors']) ? json_encode($responce['errors']) : 'No errors') . "\n";
      echo "Expected errors: " . json_encode($test['expected_errors']) . "\n";
    }
  } else {
    // Test expects no errors
    if (isset($responce['errors'])) {
      $passed = false;
      echo "Test failed: Unexpected errors found.\n";
      echo "Actual errors: " . json_encode($responce['errors']) . "\n";
    }
  }

  // Check for success message (if applicable)
  if ($passed && isset($responce['success']) && $responce['success'] !== true) {
    $passed = false;
    echo "Test failed: Expected success message not found.\n";
  }

  if ($passed) {
    echo "Test passed!\n";
  }

  // Clear global variables for next test
  unset($errors, $responce);
}



