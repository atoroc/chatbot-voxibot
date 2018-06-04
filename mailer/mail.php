<?php

require("../config.php");
require("include/class.phpmailer.php");

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
$address = "borja.sixto@ulex.fr";

if (isset($_REQUEST['subject']))
$subject = $_REQUEST['subject'];
else
$subject = "No subject";

if (isset($_REQUEST['body']))
$body = $_REQUEST['body'];
else
$body = "";

if (isset($_REQUEST['logs']))
{
  $logs = $_REQUEST['logs'];
  echo $logs;
  $body .= "\n\nLogs:\n";
}

if (isset($_FILES['attachment']))
{
  $message = $_FILES['attachment']['tmp_name'];
}
else
$message = false;

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

$mail->FromName = "Brigitte IVR";

$mail->AddAddress($address);
$mail->AddAddress('florian.fernandes@davi.ai');
$mail->AddAddress('delphine.potdevin@davi.ai');
$mail->AddAddress('yannick.gerard@davi.ai');
$mail->AddAddress('alya.yacoubi@davi.ai');
$mail->AddAddress('borja.sixto@ulex.fr');
//$mail->AddAddress('javier.sixto@ulex.fr');
$mail->Subject = $subject;

if ($message)
{
  $mail->AddAttachment($message, "record.wav");
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

$data = $result;

//header('Content-Type: application/json');
//echo json_encode($data);
header('Content-Type: text/plain');
echo $result;

?>
