<?php

require("../config.php");

// Connexion et sélection de la base
$link = mysql_connect($config['db']['hostname'], $config['db']['user'], $config['db']['password'])
    or die('Impossible de se connecter : ' . mysql_error());
mysql_select_db($config['db']['name']) or die('Impossible de sélectionner la base de données');

mysql_set_charset('utf8');

if (isset($_REQUEST['key']) && isset($_REQUEST['value']))
$query = 'SELECT * FROM users WHERE '.$_REQUEST['key'].' = \''.$_REQUEST['value'].'\'';
else
if (isset($_REQUEST['phone']))
$query = 'SELECT * FROM users WHERE phone = '.$_REQUEST['phone'];
else
if (isset($_REQUEST['id']))
$query = 'SELECT * FROM users WHERE id = \''.$_REQUEST['id'].'\'';
else
$query = 'SELECT * FROM users';

$result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

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

  $parameters = mysql_fetch_array($result, MYSQL_ASSOC);

  header('Content-Type: application/json; Charset=UTF-8');
  echo json_encode($parameters);
}

// Libération des résultats
mysql_free_result($result);

// Fermeture de la connexion
mysql_close($link);
?>