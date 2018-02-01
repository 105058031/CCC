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
	$field10 = "\"owner\"";
	$field11 = "\"date\"";
	$field12 = "\"deadline\"";
	$field13 = "\"shared\"";
	$field14 = "\"sharedtxt\"";
 
$sql = "SELECT	{$field2}
		,{$field1}
		,{$field8}
        ,{$field9}
		,{$field10}  
		,replace((to_char(date_part('year',{$field12}),'9999')||'-'||to_char(date_part('month',{$field12}),'99')||'-'||to_char(date_part('day',{$field12}),'99')),' ','') as {$field11}
		,{$field7}
		,{$field13}
		,{$field14}
		,{$field4}
  FROM {$schem}.{$tab}
  WHERE {$field5} = '".$argument3."'
  AND {$field3} = '". $argument1. "'
  AND {$field4} = '". $argument2. "'
  AND {$field6} = FALSE
  UNION
  SELECT	{$field2}
		,{$field1}
		,{$field8}
        ,{$field9}
		,{$field10}  
		,replace((to_char(date_part('year',{$field12}),'9999')||'-'||to_char(date_part('month',{$field12}),'99')||'-'||to_char(date_part('day',{$field12}),'99')),' ','') as {$field11}
		,{$field7}
		,{$field13}
		,{$field14}
		,{$field4}
  FROM {$schem}.{$tab}
  WHERE {$field5} = '".$argument3."'
  AND {$field3} = '". $argument1. "'
  AND {$field14} LIKE '%-'||'". $argument2. "'||'-%'
  AND {$field6} = FALSE
  ORDER BY {$field7} ASC, {$field13} DESC;";
  

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
	
$jsonData[] = array('ID'=>$row['id'],'NCR'=>$row['qualifier'], 'Part'=>$row['part'], 'Comment'=>$row['comment'], 'Owner'=>$row['owner'], 'Date'=>$row['date'], 'Parked'=>$row['parked'], 'Shared'=>$row['shared'],'ShrdTxt'=>$row['sharedtxt'],'WC'=>$row['wc']);	
	}

$stringData= json_encode($jsonData);
echo $stringData;


} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
						}

	  
?>


