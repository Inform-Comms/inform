<?php

$speech= "Not sure what to say next";
$text= "Not sure what to say next";

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

//outputting back to api.ai - works fine as well
header('Content-Type: application/json');

$context ="report-issue";
$source= "Inform";




{
      "source": "Inform",
      "messages": [
        {
          "type": 0,
          "speech": "Great. You have registered flytipping and we have passed it to the relevant department to deal with this issue."
        }
      ]
    }


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