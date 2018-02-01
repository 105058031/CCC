<?php
if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	$argument2 = $argv[2];
	$argument3 = $argv[3];
	$argument3 = $argv[4];
	}
else {
    $argument1 = $_GET['argument1'];
	$argument2 = $_GET['argument2'];
	$argument3 = $_GET['argument3'];
	$argument4 = $_GET['argument4'];
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

$dow = date("w");	


if (($dow < 2) OR ($dow > 5)) {
  $sql ="INSERT INTO {$schem}.{$tab} ({$field1}, {$field4}, {$field5}, {$field2}, {$field3}) VALUES (CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-1+(localtime/3) as TIMESTAMP),'".$argument1."','".$argument2."','".$argument3."', '".$argument4."');";
}else
{
$sql ="INSERT INTO {$schem}.{$tab} ({$field1}, {$field4}, {$field5}, {$field2}, {$field3}) VALUES (CAST((current_date-1) as TIMESTAMP)+localtime,'".$argument1."','".$argument2."','".$argument3."', '".$argument4."');";
}

/*$sql = "IF date_part('dow',current_date-1) IN (1,7) THEN
INSERT INTO {$schem}.{$tab} ({$field1}, {$field4}, {$field5}, {$field2}, {$field3}) VALUES (current_date -date_part('dow',current_date+1),'".$argument1."','".$argument2."','".$argument3."', '".$argument4."')
 ELSEIF date_part('dow',current_date-1) NOT IN (1,7) THEN
INSERT INTO {$schem}.{$tab} ({$field1}, {$field4}, {$field5}, {$field2}, {$field3}) VALUES (current_date-1 ,'".$argument1."','".$argument2."','".$argument3."', '".$argument4."')
END IF ;";*/
	
//echo $sql;

 $result = $db->query($sql);
	if (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print_r($db->errorInfo()));
		} 
	else 
	{
		//echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
	}
	

	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>