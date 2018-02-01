<?php

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	$argument2 = $argv[2];
	}
else {
    $argument1 = $_GET['argument1'];
	$argument2 = $_GET['argument2'];
    }
require_once __DIR__ .'/../vendor/autoload.php';
use CfCommunity\CfHelper\CfHelper;
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

include "PGSQL_connection.php";
try {
    //if we are in cloud foundry we use the connection given by cf-helper-php otherwise we use our database in local
    if ((getenv('HOSTNAME')===$hostname) or ($_SERVER['SERVER_NAME'] === $servername))
	{
			//echo "trying PDO connection";
			$db = new PDO($pdo);
			$schem = "\"public\"";
	
	}else{

		$cfHelper = CfHelper::getInstance();		
        $logger = CfHelper::getInstance()->getLogger();
        $logger->info("Trying to query data");
        $db = $cfHelper->getDatabaseConnector()->getConnection();
		$schem = "\"dbtest\"";
		} 

	$tab = "\"DateColours\"";
	
	$field1 = "\"Date\"";
	$field2 = "\"Topic\"";
	$field3 = "\"Plant\"";
	$field4 =  "\"WC\"";
	$field5 = "\"Colour\""; 
	
	$field8 = "\"Dais\"";
	$field9 = "\"Daie\"";
	$field10 = "\"Owner\"";
	$field11 = "\"Date\"";
	$field12 = "\"Deadline\"";

$sql = "SELECT date_part('day', hak.{$field8}) as {$field8}, hak.{$field2}, hak.{$field4}, j.{$field5}
FROM
(SELECT f.{$field9}, Max(h.{$field1}) as {$field8}, h.{$field4}, h.{$field2} 
FROM {$schem}.{$tab} h
RIGHT JOIN (SELECT DISTINCT date_part('day', {$field1}) as {$field9}
FROM {$schem}.{$tab}
WHERE {$field4} = '". $argument1 . "'
AND {$field3} = '". $argument2 . "'
AND date_part('month', {$field1}) = date_part('month',current_date-1)) f
ON date_part('day',h.{$field1}) = f.{$field9}
WHERE date_part('month',h.{$field1}) = date_part('month',current_date-1)
AND date_part('year',h.{$field1}) = date_part('year',current_date-1)
AND h.{$field4} = '". $argument1 . "'
AND h.{$field3} = '". $argument2 . "'
GROUP BY f.{$field9}, h.{$field4}, h.{$field2}) hak
JOIN {$schem}.{$tab} j
ON j.{$field1} = hak.{$field8} AND j.{$field2}= hak.{$field2} AND j.{$field4} = hak.{$field4};";
   
 $result = $db->query($sql);
	if (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print_r($db->errorInfo()));
	
	} 
	else 
	{
		foreach ($result as $row)
	{
		$top = str_replace(" ","",$row['Topic']);
		
	  $jsonData[] = array('C'=>substr($row['Colour'],0,1),'D'=>$row['Dais'], 'T'=>$top);	
	}

$stringData= json_encode($jsonData);
echo $stringData;
		//echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
	}
	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
						}
	
// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";


?>

