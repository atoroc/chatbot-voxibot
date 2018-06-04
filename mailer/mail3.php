<?php

require("../config.php");
require("include/class.phpmailer.php");

$json_response = file_get_contents("php://input");

if ($json_response)
{
  $json = json_decode($json_response, true);

  if (isset($json['key']))
  {
    $key = $json['key'];
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

  if (isset($json['address']))
  $address = $json['address'];
  else
  if (isset($json['to']))
  $address = $json['to'];
  else
  $address = "borja.sixto@ulex.fr";

  if (isset($json['from']))
  $from = $json['from'];
  else
  $from = "Voximal";

  if (isset($json['subject']))
  $subject = $json['subject'];
  else
  $subject = "No subject";

  if (isset($json['body']))
  {
    $body = $json['body'];
  }
  else
  $body = "";
}
else
{

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
  {
    $body = $_REQUEST['body'];
    //$body2 = mb_convert_encoding($body, "UTF-8", "UTF-8");
    //$body = $body2;
  }
  else
  $body = "";

  if (isset($_REQUEST['logs']))
  {
    $logs = $_REQUEST['logs'];
    //$logs2 = mb_convert_encoding($logs, "iso-8859-1", "UTF-8");
    //echo $logs;
    //echo "DEBUG :".$logs2;
    $body .= "\n\nLogs2:\n";
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
     $outfile="/tmp/".$caller.".mp3";
     @unlink($outfile);
     system("ffmpeg -i $message -ab 16k $outfile");
     @unlink($message);
     $message = $outfile;
     $message_type = "audio/mpeg";
    }
    else
    if ($format=="ogg")
    {
     $outfile="/tmp/".$caller.".ogg";
     @unlink($outfile);
     system("ffmpeg -i $message $outfile");
     @unlink($message);
     $message = $outfile;
     $message_type = "audio/ogg";
    }
  }
}


// Instantiate your new class
$mail = new PHPMailer();

// Now you only need to add the necessary stuff
//$mail->Host     = "";
//$mail->Port     = "22";
$mail->Mailer   = "mail";

// Now you only need to add the necessary stuff
$mail->IsSMTP();

$mail->SMTPAuth   = $config['mail']['smtpauth'];   // enable SMTP authentication
$mail->SMTPSecure = $config['mail']['smtpauth'];   // sets the prefix to the servier
$mail->Host       = $config['mail']['host'];      // sets GMAIL as the SMTP server
$mail->Port       = $config['mail']['port'];      // set the SMTP port for the GMAIL server
$mail->Username   = $config['mail']['user'];      // GMAIL username
$mail->Password   = $config['mail']['password'];  // GMAIL password

//$mail->AddReplyTo("bsixto@gmail.com", "First Last");

$mail->FromName = $from;

$arr = explode(';', $address);
foreach ($arr as &$value) {
  $mail->AddAddress($value);
}
//$mail->AddAddress($address);

$mail->Subject = $subject;
$mail->CharSet = "UTF-8";

if ($message)
{
  $extension = pathinfo($message, PATHINFO_EXTENSION);

  if ($message_type == "audio/mpeg")
  $mail->AddAttachment($message, "file.mp3");
  else
  if ($message_type == "audio/x-wav")
  $mail->AddAttachment($message, "file.wav");
  else
  $mail->AddAttachment($message, "file.".$extension);


  $mail->Body = $body."\n\nA file is attached ($message_type)";
}
else
{
  $mail->Body = $body;
}

if(!$mail->Send())
{
 $result="ERROR";
}  
else
{
 $result="OK";
}

if ($message)
@unlink($message);

$data = $result;

//header('Content-Type: application/json');
//echo json_encode($data);
header('Content-Type: text/plain');
echo $result;

?>
