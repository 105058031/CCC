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
if (($dow < 2) OR ($dow > 5)) {

$sql = "SELECT h.{$MRP}, h.{$Order}, l.{$Material}, date_part('day',age(l.{$field12},h.{$field26})) as {$gap}, l.{$field12}
FROM (SELECT {$field12},{$Material},{$Order}, {$field8}, {$field15}, SUM({$field13}) as {$Qty} 
FROM {$schem}.{$tab2} WHERE {$field15} IS NULL AND {$field8} = 101 GROUP BY {$field12}, {$Material}, {$Order}, {$field8}, {$field15}) l
LEFT JOIN (SELECT pr.{$Order}, pr.{$MRP}, {$tab1}.{$field26} FROM 
(SELECT {$Order}, {$MRP}, MAX({$field31}) as {$field31} FROM {$schem}.{$tab1}
WHERE {$tab1}.{$plant}='". $argument2 ."' 
AND CASE '". $argument1 ."'
WHEN 'PL' THEN {$tab1}.{$MRP}='9HA' or {$tab1}.{$MRP}='9HD'or {$tab1}.{$MRP}='9HE'or {$tab1}.{$MRP}='9HF'or {$tab1}.{$MRP}='9HH' or {$tab1}.{$MRP}='9HG' 
WHEN 'WI' THEN {$tab1}.{$MRP}='9HI' or {$tab1}.{$MRP}='9HK' or {$tab1}.{$MRP}='9HL'
WHEN 'OH' THEN {$tab1}.{$MRP}='9HB' or {$tab1}.{$MRP}='9HC' or {$tab1}.{$MRP}='9HJ'
END
GROUP BY {$Order},{$MRP}) pr
LEFT JOIN {$schem}.{$tab1} 
ON {$tab1}.{$Order}=pr.{$Order} AND {$tab1}.{$field31}=pr.{$field31}) h
ON CAST(h.{$Order} as text)= CAST(l.{$Order} as text) 
WHERE l.{$field12} < CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER) as TIMESTAMP)
AND l.{$field12} > CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-2 as TIMESTAMP)
AND h.{$Order} IS NOT NULL;";
}
else
{
$sql = "SELECT h.{$MRP}, h.{$Order}, l.{$Material}, date_part('day',age(l.{$field12},h.{$field26})) as {$gap}, l.{$field12}
FROM (SELECT {$field12},{$Material},{$Order}, {$field8}, {$field15}, SUM({$field13}) as {$Qty} FROM {$schem}.{$tab2} WHERE {$field15} IS NULL  AND {$field8} = 101 GROUP BY {$field12},{$Material},{$Order}, {$field8}, {$field15}) l
LEFT JOIN (SELECT pr.{$Order}, pr.{$MRP}, {$tab1}.{$field26} FROM 
(SELECT {$Order},{$MRP}, MAX({$field31}) as {$field31} FROM {$schem}.{$tab1}
WHERE {$tab1}.{$plant}='". $argument2 ."' 
AND CASE '". $argument1 ."'
WHEN 'PL' THEN {$tab1}.{$MRP}='9HA' or {$tab1}.{$MRP}='9HD'or {$tab1}.{$MRP}='9HE'or {$tab1}.{$MRP}='9HF'or {$tab1}.{$MRP}='9HH' or {$tab1}.{$MRP}='9HG' 
WHEN 'WI' THEN {$tab1}.{$MRP}='9HI' or {$tab1}.{$MRP}='9HK' or {$tab1}.{$MRP}='9HL'
WHEN 'OH' THEN {$tab1}.{$MRP}='9HB' or {$tab1}.{$MRP}='9HC' or {$tab1}.{$MRP}='9HJ'
END
GROUP BY {$Order},{$MRP}) pr
LEFT JOIN {$schem}.{$tab1} 
ON {$tab1}.{$Order}=pr.{$Order} AND {$tab1}.{$field31}=pr.{$field31}) h
ON CAST(h.{$Order} as text)= CAST(l.{$Order} as text) 
WHERE l.{$field12} < CAST((current_date) as TIMESTAMP)
AND l.{$field12} > CAST((current_date-2) as TIMESTAMP)
AND h.{$Order} IS NOT NULL;";	
}

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
                                 $jsonData[] = array('Gap'=>$row['gap'],								 
								 'MRPController'=>$row['MRP ctrlr'],
								 'Order'=>$row['Order'],
								 'Material'=>$row['Material'],
								 'Pstng_Date'=>$row['Pstng Date']	 							 
								 );

                }
                $stringData= json_encode($jsonData );
				echo $stringData;
                                //echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm an die Programmierer";
                }

				} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

				
// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";


?>