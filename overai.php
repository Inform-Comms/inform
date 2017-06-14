<?php

error_reporting(0);
//header('Content-Type: application/json');

$servername = "us-cdbr-iron-east-03.cleardb.net";
$username = "bc8adfd337a147";
$password = "8636ab6c";
$dbname = "heroku_6b42f3a320e7b6f";



//If we have JSON load by POST - echo something. Otherwise -just quit

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
        $json_data = file_get_contents("php://input");
        $response=json_decode($json_data);
        //print_r($response);    
        $reference_number ='123';
       // $reference_number = $response->result->parameters->input;

 echo  
     '{
  "result": {
  "introSpeakOut": "18:12 The status for reference '.$reference_number.' whatever"
  }
}';
exit(0);

}
else
exit(0);





















// get the reference number status from the database
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
  
$read_sql = "select status from records where id=".$_GET['reference']." limit 0,1";
$result = $conn->query($read_sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
     echo  
     '{
  "result": {
  "introSpeakOut": "The status for reference '.$_GET['reference'].' is `'.$row["status"].'` You can come back here later to lookup the status of your issue using this number."
  }
}';
}

} 
else 
{
     echo 

'
{
  "result": {
  "introSpeakOut": "Unable to retrieve the reference number at this point"
  }
}';


;
}
$conn->close();



?>