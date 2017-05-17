<?php

error_reporting(0);

//file_put_contents('test.txt', json_encode($_GET)); // save the JSON data passed on to URL
$json_result = json_encode($_GET);


$servername = "us-cdbr-iron-east-03.cleardb.net";
$username = "bc8adfd337a147";
$password = "8636ab6c";
$dbname = "heroku_6b42f3a320e7b6f";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO records (id, result) VALUES (NULL, '$json_result')";

$conn->query($sql);
//$conn->close();

// select the reference number and display to the user
	
$read_sql = "select max(id) as reference from records limit 0,1";
$result = $conn->query($read_sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // echo 'Your reference number is '.$row["reference"].'!"}';
		 echo '
{
 "messages": [
   {"text": "Thank you for submitting this information. Your reference number is '.$row["reference"].'. You can come back here and lookup the status of your issue using this number."}
 ]
}
';
}

} 
else 
{
		 echo '
{
 "messages": [
   {"text": "Unable to retrieve the reference number at this point"}
 ]
}
';
}
$conn->close();

?>
