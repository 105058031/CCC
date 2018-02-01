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
				$MvT=$field8;
								$Fdate=$field26;
				$Qty = "\"Qty\"";
				
				
//on {$schem}.{$tab1}.{$Order}={$schem}.{$tab2}.{$Order}
//where {$tab1}.{$Op} = (SELECT min({$Op}) from {$schem}.{$tab1} as {$tghost} where {$tghost}.{$Order}={$schem}.{$tab1}.{$Order})
//and Substring({$tab1}.{$wc},1,3)='". $argument1 ."_' and {$tab1}.{$plant}='". $argument2 ."'
//order by {$tab1}.{$wc},{$tab1}.{$latdate},{$tab1}.{$Order},{$tab1}.{$Op};";
$Src = "\"Source\"";
$OT = "\"OT\"";
$LT = "\"LT\"";
$OTD = "\"OTD\"";
$OTn = "OT";
$CNT = "\"Count\"";
$dow = date("w");			

if (($dow > 2) AND ($dow < 5)) {

$sql = "SELECT COALESCE(SUM({$Src}.{$OT}),0) as {$OT} , COALESCE(SUM({$Src}.{$LT}),0) as {$LT}, COUNT({$Src}.{$Order}) as {$CNT}
FROM (SELECT {$tab1}.{$Order}
,CASE WHEN date_part('day',age(l.{$Dlvdate},{$tab1}.{$Fdate})) <= 0 THEN 1 END as {$OT}  
,CASE WHEN date_part('day',age(l.{$Dlvdate},{$tab1}.{$Fdate})) > 0 THEN 1 END as {$LT}  
FROM {$schem}.{$tab1} 
JOIN (SELECT {$field12},{$Material},{$Order}, {$field8}, {$field15}, SUM({$field13}) as {$Qty} 
FROM {$schem}.{$tab2} WHERE {$field15} IS NULL AND {$field8} = 101 GROUP BY {$field12}, {$Material}, {$Order}, {$field8}, {$field15}) l
on cast({$schem}.{$tab1}.{$Order} as text)=cast(l.{$Order} as text) 
WHERE l.{$field12} < CAST((current_date) as TIMESTAMP)
AND l.{$field12} > CAST(current_date-CAST(date_part('dow',current_date+2) as INTEGER) as TIMESTAMP)
AND {$tab1}.{$plant}='". $argument2 ."'
AND CASE '". $argument1 ."' 
WHEN 'PL' THEN {$tab1}.{$MRP}='9HA' or {$tab1}.{$MRP}='9HD'or {$tab1}.{$MRP}='9HE'or {$tab1}.{$MRP}='9HF'or {$tab1}.{$MRP}='9HH' or {$tab1}.{$MRP}='9HG'
WHEN 'WI' THEN {$tab1}.{$MRP}='9HI' or {$tab1}.{$MRP}='9HK' or {$tab1}.{$MRP}='9HL' 
WHEN 'OH' THEN {$tab1}.{$MRP}='9HB' or {$tab1}.{$MRP}='9HC' or {$tab1}.{$MRP}='9HJ'
END) {$Src};";
}else{
	$sql = "SELECT COALESCE(SUM({$Src}.{$OT}),0) as {$OT} , COALESCE(SUM({$Src}.{$LT}),0) as {$LT}, COUNT({$Src}.{$Order}) as {$CNT}
FROM (SELECT {$tab1}.{$Order}
,CASE WHEN date_part('day',age(l.{$Dlvdate},{$tab1}.{$Fdate})) <= 0 THEN 1 END as {$OT}  
,CASE WHEN date_part('day',age(l.{$Dlvdate},{$tab1}.{$Fdate})) > 0 THEN 1 END as {$LT}  
FROM {$schem}.{$tab1} 
JOIN (SELECT {$field12},{$Material},{$Order}, {$field8}, {$field15}, SUM({$field13}) as {$Qty} 
FROM {$schem}.{$tab2} WHERE {$field15} IS NULL AND {$field8} = 101 GROUP BY {$field12}, {$Material}, {$Order}, {$field8}, {$field15}) l
on cast({$schem}.{$tab1}.{$Order} as text)=cast(l.{$Order} as text) 
WHERE l.{$field12} < CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER) as TIMESTAMP)
AND l.{$field12} > CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-6 as TIMESTAMP)
AND {$tab1}.{$plant}='". $argument2 ."'
AND CASE '". $argument1 ."' 
WHEN 'PL' THEN {$tab1}.{$MRP}='9HA' or {$tab1}.{$MRP}='9HD'or {$tab1}.{$MRP}='9HE'or {$tab1}.{$MRP}='9HF'or {$tab1}.{$MRP}='9HH' or {$tab1}.{$MRP}='9HG'
WHEN 'WI' THEN {$tab1}.{$MRP}='9HI' or {$tab1}.{$MRP}='9HK' or {$tab1}.{$MRP}='9HL' 
WHEN 'OH' THEN {$tab1}.{$MRP}='9HB' or {$tab1}.{$MRP}='9HC' or {$tab1}.{$MRP}='9HJ'
END) {$Src};";
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
                                 $jsonData[] = array('OT'=>$row['OT'],'LT'=>$row['LT'],'CNT'=>$row['Count']
								 );
                                
                }
                $stringData= json_encode($jsonData );
				echo $stringData;
                                //echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm an die Programmierer";
                }

				} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



?>

