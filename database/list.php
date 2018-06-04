<?php

require("../config.php");

// Connexion et sélection de la base
$link = mysql_connect($config['db']['hostname'], $config['db']['user'], $config['db']['password'])
    or die('Impossible de se connecter : ' . mysql_error());
mysql_select_db($config['db']['name']) or die('Impossible de sélectionner la base de données');

// Exécution des requêtes SQL
$query = 'SELECT * FROM users';
$result = mysql_query($query) or die('Échec de la requête : ' . mysql_error());

// Affichage des résultats en HTML
echo "<table>\n";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Libération des résultats
mysql_free_result($result);

// Fermeture de la connexion
mysql_close($link);
?>