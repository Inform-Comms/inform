<?php

$servername = "us-cdbr-iron-east-03.cleardb.net";
$username = "bc8adfd337a147";
$password = "8636ab6c";
$dbname = "heroku_6b42f3a320e7b6f";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
$json_data = file_get_contents("php://input");
//$json_data = file_get_contents("data.txt");

  
$response=json_decode($json_data);
$result =$response->result;  //result is an array
$parameters = $result->parameters;  // parameters is also an array
$address = $parameters->address; // address is the variable with value
//echo $address;
//echo $response->result->parameters->address; //this works the same way

$speech=  $response->result->parameters->address;
$text=$speech;
}






// Create connection. Writing into DB at this block
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO records (id, result) VALUES (NULL, '$json_data')";

$conn->query($sql);










// select the reference number and display to the user
  
$read_sql = "select max(id) as reference from records limit 0,1";
$result = $conn->query($read_sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // echo 'Your reference number is '.$row["reference"].'!"}';
     $speech= 'Thank you for submitting this information. Your reference number is '.$row["reference"].'. You can come back here and lookup the status of your issue using this number.';
}

} 
else 
{
          $speech= 'Unable to retrieve the reference number at this point';
}
$conn->close();


$text = $speech;


//$speech= "Not sure what to say next";
//$text= "Not sure what to say next";



//outputting back to api.ai - works fine as well
header('Content-Type: application/json');

$context ="report-issue";
$source= "Inform123";


$json = array(
                    'speech'   => $speech,
                    'displayText' => $text,
                    'source' => $source
            );

// $json = array(
//                    'speech'   => $speech,
//                    'displayText' => $text,
//                    'data' => [],
//                    'contextOut' => [$context],
//                    'source' => $source
//            );
	echo json_encode($json, JSON_PRETTY_PRINT);
?>