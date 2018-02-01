<?php

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	$argument2 = $argv[2];
	$argument3 = $argv[3];
    }
else {
    $argument1 = $_GET['argument1'];
	$argument2 = $_GET['argument2'];
	$argument3 = $_GET['argument3'];
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

	$tab = "\"ActionItems\"";
	$field1 = "\"qualifier\"";
	$field2 = "\"id\"";
	$field3 = "\"plant\"";
	$field4 =  "\"wc\"";
	$field5 = "\"topic\""; 
	$field6 = "\"archived\"";
	$field7 = "\"parked\"";
	$field8 = "\"part\"";
	$field9 = "\"comment\"";
	$field12 = "\"deadline\"";
	$field10 = "\"owner\"";
	$field11 = "\"date\"";
$sql = "INSERT INTO {$schem}.{$tab} 
	(		{$field2}
	  ,{$field11}
	  ,{$field1}
      ,{$field12}
      ,{$field9}
	  ,{$field10}    
      ,{$field8}
      ,{$field5}
	  ,{$field3}
      ,{$field4}
      ,{$field6}
	  ,{$field7})
SELECT 
(SELECT Max({$field2}) FROM {$schem}.{$tab}) + 1 as ID
		,current_date as {$field11}
		,'-' as {$field1}
		,Null as {$field12}
        ,'-' as {$field9}
		,'-' as {$field10}
		,'-' as {$field8}
		,'". $argument3 . "' as {$field5}
		,'". $argument1 . "' as {$field3}
		,'". $argument2 . "' as {$field4}
		,FALSE as {$field6}
		,FALSE as {$field7};";
   

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

