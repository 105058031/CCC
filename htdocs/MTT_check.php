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

                 $tab1 = "\"Coois_Headers\"";
				$tab2= "\"MB51\"";
				$tab3= "\"ZP03\"";

#XXXXXXXXXXXXXXXXXX        MB51     XXXXXXXXXXXXXXXXXXX'
$field4 = "\"Material\"";
$field5 = "\"Material Description\"";
$field6 = "\"Plnt\"";
$field7 = "\"SLoc\"";
$field8 = "\"MvT\"";
$field9 = "\"Movement Type Text\"";
$field10 = "\"Mat. Doc.\"";
$field11 = "\"Item\"";
$field12 = "\"Pstng Date\"";
$field13 = "\"Qty in UnE\"";
$field14 = "\"Amount LC\"";
$field15 = "\"PO\"";
$field16 = "\"Item1\"";
$field17 = "\"Order\"";
$field18 = "\"Crcy\"";
#XXXXXXXXXXXxxxXXX        Coois_Headers xxxXXXXXXXXXXXXX'
$field19 = "\"Order\"";
$field20 = "\"Material\"";
$field21 = "\"MRP ctrlr\"";
$field22 = "\"Order Type\"";
$field23 = "\"Target qty\"";
$field24 = "\"Unit\"";
$field25 = "\"Bsc start\"";
$field26 = "\"Basic fin.\"";
$field27 = "\"Material description\"";
$field28 = "\"System Status\"";
$field29 = "\"Firming\"";
$field30 = "\"Plant\"";
$field31 = "\"Pull_Date\"";
#XXXXXXXXXXXxxxXXX        Zp03 xxxXXXXXXXXXXXXX'
$field32 = "\"Work_Center\"";

				
				$plant= "\"Plant\"";
				$Order= "\"Order\"";
				$Material= "\"Material\"";
				$wc= "\"\"";
				$MRP= $field21;
				$gap="\"gap\"";
				$Dlvdate=$field12;
				$Fdate=$field26;
				$Qty = "\"Qty\"";




				
	$dow = date("w");			
//$dow =1 ;
if (($dow < 2) OR ($dow > 5)) {
	
$sql = "SELECT {$field12},{$Material},{$field5},{$Order}, {$field8},{$field9}, {$field15}, SUM({$field13}) as {$Qty}
FROM {$schem}.{$tab2} 
WHERE {$field15} IS NULL 
AND {$field8} = 101 
AND {$field12} < CAST((current_date) as TIMESTAMP)
AND {$field12} > CAST((current_date-4) as TIMESTAMP)
and {$field6} = '". $argument2 ."'
GROUP BY {$field12},{$Material},{$field5},{$Order}, {$field8},{$field9}, {$field15};";

}
else
{

$sql = "SELECT {$field12},{$Material},{$field5},{$Order}, {$field8},{$field9}, {$field15}, SUM({$field13}) as {$Qty}   
FROM {$schem}.{$tab2} 
WHERE {$field15} IS NULL 
AND {$field8} = 101 
AND {$field12} < CAST((current_date) as TIMESTAMP)
AND {$field12} > CAST((current_date-2) as TIMESTAMP)
and {$field6} = '". $argument2 ."'
GROUP BY {$field12},{$Material},{$field5},{$Order}, {$field8},{$field9}, {$field15};";
}


//echo "dow : " . $dow;


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
                                 $jsonData[] = array('Pstng_Date'=>$row['Pstng Date'],
								 'Material'=>$row['Material'],
								 'Mat_des'=>$row['Material Description'],
								 'Order'=>$row['Order'],
								 'MvT'=>$row['MvT'],
								 'MvTText'=>$row['Movement Type Text'],
								 'Qty'=>$row['Qty'],
								 'PO'=>$row['PO']);
								
                }
                $stringData= json_encode($jsonData );
				echo $stringData;
                                //echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm an die Programmierer";
                }
	
	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



?>