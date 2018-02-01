<?php

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
	
 #$db = new PDO('pgsql:dbname=postgres;host=127.0.0.1;port=5432;user=postgres;password=Pa55word');
	$postdata = file_get_contents("php://input"); 
	$json = array();
	$json = json_decode($postdata);
 
                //$schem = "\"dbtest\"";
                $tab = "\"METADATA\"";
				//$NCR= "\"NCR#\"";
				//$CL= "\"Cell\"";
				//$PD= "\"Logged Date 2\"";
				//$fieldNCR= "\"countncr\"";
				//$field1 = "\"Activity\"";
				//$STS="\"Pending\"";
	$field2 = "\"Start\"";
	$field2s = "Material Description";
	$field3 = "\"Finish\"";
	$field4 = "\"Material\"";
##XXXXXXXXXXXXXXXXXX        META_data           XXXXXXXXXXXXXXXXXXXX
$field92 = "\"Table\"";
$field93 = "\"Feedback_Type\"";
$field94 = "\"Datetime\"";
$field96 = "\"Status_Code\"";
$field97 = "\"LU\"";



##XXXXXXXXXXXXXXXXXX        META_data           XXXXXXXXXXXXXXXXXXXX
$field92s = "Table";
$field93s = "Feedback_Type";
$field94s = "Datetime";
$field96s = "Status_Code";

$field100s = "\"DWN\"";
$field101s = "\"PSH\"";
$field102s = "SUCCESS\"";

$sql = "SELECT 
a.{$field92}
,b.{$field97} as {$field100s}
,c.{$field97} as {$field101s}
FROM (SELECT DISTINCT {$field92} FROM {$schem}.{$tab} )a
LEFT JOIN (SELECT
  {$field92}
  ,MAX({$field94}) as {$field97}
FROM {$schem}.{$tab}
WHERE {$field96} = 'SUCCESS'
AND {$field93} IN ('DWN')
GROUP BY {$field92},{$field93}) b
ON a.{$field92} = b.{$field92} 
LEFT JOIN (SELECT
  {$field92}
  ,MAX({$field94}) as {$field97}
FROM {$schem}.{$tab}
WHERE {$field96} = 'SUCCESS'
AND {$field93} IN ('PSH')
GROUP BY {$field92},{$field93}) c
ON a.{$field92} = c.{$field92} 
;";
   
   //echo $sql;

$result = $db->query($sql);
$jsonData=array();

                if (!$result) 
                {
                                echo '<p>Ungültige Anfrage: </p>';
    die('  '. print_r($db->errorInfo()));
                
                } 
                else 
                {
                                foreach ($result as $row)
                {
                                 $jsonData[] = array('TAB'=>$row['Table'],'PSH'=>$row['PSH'],'DWN'=>$row['DWN']);
								 								 
                }
                $stringData= json_encode($jsonData );
				echo $stringData;
                                //echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm an die Programmierer";
                }
	} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
	

?>