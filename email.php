<?php

 // Retrieve form data
$name = $_POST['FNAME'];
$surname = $_POST['LNAME'];
$email = $_POST['Email'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];


$access_token;
// API endpoint URL
$apiUrl = 'Add_YOUR_URL';

// Data to send in the POST request
$data = array(
    'grant_type' => 'client_credentials',
    'client_id' => 'ADD_YOUR_CLIENT_ID',
    'client_secret' => 'ADD_YOUR_CLIENT_SECRET'
);

// Create a new cURL resource
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Execute the request and fetch the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    $error = curl_error($ch);
    // Handle the error as needed
    echo 'cURL Error: ' . $error;
}

// Close cURL resource
curl_close($ch);

// Process the response
if ($response) {
    // The response is in JSON format, you can decode it into an associative array
    $data = json_decode($response, true);
    var_dump($data);
    
    // Use the data as needed
    $access_token = $data['access_token'];
} else {
    // Handle the case when no response is received
    echo 'No response from the API';
}


//POST TO SALESFORCE 

// API endpoint URL
$apiUrl = 'Add_YOUR_URL:'.$email;

// Data to send in the POST request
$data = array(
    'values' => array (
        'FirstName' => $name,
        'LastName' => $surname,
        'VenueName' => 'The Breakwater',
        'Birth Date' => $dob,
        'Mobile Phone' => $phone
    )
);

// Convert the data to JSON format
$jsonData = json_encode($data);

print_r($jsonData);


// Authorization header value
$token = $access_token;

// Create a new cURL resource
$ch = curl_init($apiUrl);

// Set the cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
));
// Execute the request and fetch the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    $error = curl_error($ch);
    // Handle the error as needed
    echo 'cURL Error: ' . $error;
}

// Close cURL resource
curl_close($ch);

// Process the response
if ($response) {
    // The response is in JSON format, you can decode it into an associative array
    $data = json_decode($response, true);
    
    // Use the data as needed
  var_dump($data);
} else {
    // Handle the case when no response is received
    echo 'No response from the API';
}

// Redirect to a different page
header("Location: Add_YOUR_URL");
exit(); // Ensure that the script stops execution after the redirect
?>
