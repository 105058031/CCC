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

                $tab1 = "\"ActionItems\"";
				$tab2= "\"MB51\"";
				$tab3= "\"COOIS_OPs\"";

 //$schem = "\"dbtest\"";
	$tab1 = "\"ActionItems\"";
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
				
				$plant= "\"Plant\"";
				
				$Order= "\"Order\"";
				$Material= "\"Material\"";
				$wc= "\"\"";
				$MRP= $field21;
				$gap="\"gap\"";
				$Dlvdate=$field12;
				$Fdate=$field26;
				$MvT=$field8;
				$ID = "\"id\"";
				$dow = date("w")+1;
				
//on {$schem}.{$tab1}.{$Order}={$schem}.{$tab2}.{$Order}
//where {$tab1}.{$Op} = (SELECT min({$Op}) from {$schem}.{$tab1} as {$tghost} where {$tghost}.{$Order}={$schem}.{$tab1}.{$Order})
//and Substring({$tab1}.{$wc},1,3)='". $argument1 ."_' and {$tab1}.{$plant}='". $argument2 ."'
//order by {$tab1}.{$wc},{$tab1}.{$latdate},{$tab1}.{$Order},{$tab1}.{$Op};";
$Src = "\"Source\"";
$OT = "\"OT\"";
$LT = "\"LT\"";
$OTD = "\"OTD\"";
$CNT = "\"Cnt\"";

if (($dow > 2) AND ($dow < 5)) {

$sql = "SELECT COUNT({$tab1}.{$field6}) as {$CNT}
FROM {$schem}.{$tab1}
WHERE {$tab1}.{$field11} > (CAST(current_date-{$dow} as date)) 
AND {$tab1}.{$field11} < (CAST((current_date+1) as date))
AND {$tab1}.{$field6} = TRUE
AND {$field5} = 'Improvements'
  AND {$field3} = '". $argument2. "'
  AND {$field4} = '". $argument1. "'";
}else{
$sql = "SELECT COUNT({$tab1}.{$field6}) as {$CNT}
FROM {$schem}.{$tab1}
WHERE {$tab1}.{$Dlvdate} > (CAST((current_date-{$dow}-6) as date))
AND {$tab1}.{$Dlvdate} < (CAST(current_date-{$dow} as date)) 
AND {$tab1}.{$field6} = TRUE
AND {$field5} = 'Improvements'
  AND {$field3} = '". $argument2. "'
  AND {$field4} = '". $argument1. "'";
}



//echo $sql;
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
                                 $jsonData[] = array('OTD'=>$row['Cnt']							 					 
								 );
                                //$sql = $sql."('".$N->NCR."',".$N->ID.",'".substr($N->Plant,0,4)."',
                                //'".$N->WC."','".$N->Topic."',".$bl1.",".$bl2.",
                                //'".$N->Part."','".$N->Comment."','".$N->Owner."',
                                //'".$N->Date->date."',
                                //'".$N->Deadline->date."'),";
                }
                $stringData= json_encode($jsonData );
				echo $stringData;
                                //echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm an die Programmierer";
                }

				} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



?>

