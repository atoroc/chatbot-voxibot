<?php

require("../config.php");

// Connexion et sélection de la base
$link = mysql_connect($config['db']['hostname'], $config['db']['user'], $config['db']['password'])
    or die('Impossible de se connecter : ' . mysql_error());
mysql_select_db($config['db']['name']) or die('Impossible de sélectionner la base de données');


function debug($Message) {
        $stderr = fopen('php://stderr', 'w');
        fwrite($stderr,$Message."\n");
        fclose($stderr);
}

mysql_set_charset('utf8');

if (isset($_REQUEST['phone']))
$phone = $_REQUEST['phone'];

if (isset($_REQUEST['datas']))
$datas = $_REQUEST['datas'];

$table_name = "users";

$sql = "UPDATE `".$table_name."` SET ";
$i = 0;

foreach($datas as $key => $value) {
    $value = str_replace("'"," ",$value);
    $sql.= $key." = '".$value."'";
    if ($i < count($datas) - 1) {
        $sql.= " , ";
    }
    $i++;
}

if (isset($_REQUEST['key']) && isset($_REQUEST['value']))
$sql.= ' WHERE '.$_REQUEST['key'].' = \''.$_REQUEST['value'].'\'';
else
$sql.= " WHERE phone='".$phone."'";

debug($sql);
//debug("DATAS 2 = ".print_r($datas, true));

$result = mysql_query($sql);

// Affichage des résultats en HTML
if (false)
{
  echo "<table>\n";
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      echo "\t<tr>\n";
      foreach ($line as $col_value) {
          echo "\t\t<td>$col_value</td>\n";
      }
      echo "\t</tr>\n";
  }
  echo "</table>\n";
}
else
{
  /*
  $count = mysql_num_fields($result);
  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $parameters[] = $line;
  }
  */

  if (!$result)
  {
    $parameters['result'] = 'KO';
    $parameters['error'] = mysql_error();
  }
  else
  {
    $parameters['result'] = 'OK';
  }

  header('Content-Type: application/json; Charset=UTF-8');
  echo json_encode($parameters);
}


// Fermeture de la connexion
mysql_close($link);
?>