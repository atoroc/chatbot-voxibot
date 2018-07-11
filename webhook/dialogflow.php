<?php

$GLOBALS['sessionId'] = md5(uniqid(rand(), true));

function dialogflow($query)
{
  $postData = array('query' => $query, 'lang' => 'fr', 'sessionId' => $GLOBALS['sessionId']);
  $jsonData = json_encode($postData);

  $v = date('Ymd');
  $ch = curl_init('https://api.dialogflow.com/v1/query?v='.$v);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer b091f8442ab64407ad6a9bd6c4d45c2c'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);

  $answerData = json_decode($result);

  return $answerData->result->fulfillment->speech;
}

dialogflow("MINITEL");

$query = "hello";

while (true)
{
  $answer = dialogflow($query);

  echo "VOXIBOT > ".$answer."\n\r\n\r";

  $query = readline("    YOU > ");
  if ($query == "")
  $query = "?";
}

?>