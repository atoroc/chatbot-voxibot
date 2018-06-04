<?php

if (isset($_REQUEST['key']))
{
  $key = $_REQUEST['key'];
  if ($key != "moreno")
  {
    echo "BAD KEY";
    exit();
  }
}
else
{
  echo "ACCESS DENIED";
  exit();
}

if (isset($_REQUEST['address']))
$address = $_REQUEST['address'];
else
if (isset($_REQUEST['to']))
$address = $_REQUEST['to'];
else
$address = "borja.sixto@ulex.fr";

if (isset($_REQUEST['from']))
$from = $_REQUEST['from'];
else
$from = "Voximal";

if (isset($_REQUEST['subject']))
$subject = $_REQUEST['subject'];
else
$subject = "No subject";

if (isset($_REQUEST['body']))
$body = $_REQUEST['body'];
else
$body = "";

//$filename = "/tmp/".uniqid();
$filename = "files/".date("Ymd_His").'_'.$subject;
$filename = str_replace(" ", "_", $filename);
$filename = str_replace("(", "[", $filename);
$filename = str_replace(")", "]", $filename);

if (isset($_REQUEST['logs']))
{
  $logs = $_REQUEST['logs'];
  echo $logs;
  $body .= "\n\nLogs:\n";
}

if (isset($_REQUEST['format']))
{
  $format = $_REQUEST['format'];
}

if (isset($_FILES['attachment']))
{
  $message = $_FILES['attachment']['tmp_name'];
  $message_type = $_FILES['attachment']['type'];
}
else
$message = false;

if ($message)
{
  if ($format=="mp3")
  {
   $outfile=$filename.".mp3";
   @unlink($outfile);
   system("ffmpeg -i $message -ab 16k $outfile");
   @unlink($message);
   $message = $outfile;
   $message_type = "audio/mpeg";
  }
  else
  if ($format=="ogg")
  {
   $outfile=$filename.".ogg";
   @unlink($outfile);
   system("ffmpeg -i $message $outfile");
   @unlink($message);
   $message = $outfile;
   $message_type = "audio/ogg";
  }
}


if($handle=fopen($filename.'.txt', 'w'))
{
 fwrite($handle, $body);
 fclose($handle);
 $result="OK";
}
else
{
 $result="ERROR";
}

//if ($message)
//@unlink($message);

$data = $result;

//header('Content-Type: application/json');
//echo json_encode($data);
header('Content-Type: text/plain');
echo $result;

?>
