<?php

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	
	}
else {
    $argument1 = $_GET['argument1'];
	
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
		//$schem = "\"dbtest\"";
		//$tab = "\"ActionItems\"";



	
	$tab1 = "\"OGOS_Cells\"";
	$tab2 = "\"OGOS_Cell_2_Plant\"";
	$tab3 = "\"OGOS_Plants\"";
	
	$field1 = "\"NCR\"";
	$field2 = "\"ID\"";
	$field3 = "\"Plant_ID\"";
	$field4 =  "\"WC\"";
	$field5 = "\"Topic\""; 
	$field6 = "\"Cell_ID\"";
	$field7 = "\"Cell_Shorthand\"";
	$field8 = "\"Plant_Number\"";
	$field9 = "\"Comment\"";
	$field10 = "\"Owner\"";
	$field11 = "\"Date\"";
	$field12 = "\"Deadline\"";

$sql = "SELECT {$field7} FROM {$schem}.{$tab1}
WHERE {$field2} IN (SELECT k.{$field6}
FROM {$schem}.{$tab2} k
INNER JOIN
	(SELECT {$field2} FROM {$schem}.{$tab3}
WHERE {$field8} = '". $argument1 . "' ) h 
	ON h.{$field2} = k.{$field3});";
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
	
foreach ($result as $row)
	{
	 $jsonData[] = array('Cell'=>$row['Cell_Shorthand']);	
	}

$stringData= json_encode($jsonData);
echo $stringData;

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
						}


?>

