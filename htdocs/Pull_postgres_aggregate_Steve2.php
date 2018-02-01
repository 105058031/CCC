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

                $tab = "\"ZP03\"";
$tab2 = "\"Coois_Headers\"";
$tab3 = "\"MB51\"";

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
#XXXXXXXXXXXXXXXXXX   Coois Headers XXXXXXXXXXXXXXXXXXX'
$field19 = "\"Order\"";
$field20 = "\"Material\"";
$field21 = "\"MRP ctrlr\"";
$field22 = "\"Order Type\"";
$field23 = "\"Target qty\"";
$field24 = "\"Unit\"";
$field25 = "\"Bsc start\"";
$field26 = "\"Basic fin.\"";
$field27 = "\"Material Description\"";
$field28 = "\"System Status\"";
$field29 = "\"Firming\"";
$field30 = "\"Plant\"";

###'XXXXXXXXXXXX Coois Operations XXXXXXXXXXXXXXXXXXX'
$field31 = "\"Order\"";
$field32 = "\"Operation/Activity\"";
$field33 = "\"Work center\"";
$field33o = "\"Work cntr.\"";
$field34 = "\"Operation short text\"";
$field35 = "\"Operation Quantity\"";
$field36 = "\"Act#/Operation UoM\"";
$field37 = "\"ActStartDateExecution\"";
$field38 = "\"ActFinishDateExecutn\"";
$field39 = "\"LastFinishDateExecutn\"";
$field40 = "\"System Status\"";
$field41 = "\"Confirmed yield\"";
$field42 = "\"Standard value 3\"";
$field43 = "\"Confirmed activ# 3\"";
$field44 = "\"Rework qty\"";
$field45 = "\"Plant\"";
$field46 = "\"Processing time\"";
$field47 = "\"Standard text key\"";

###'XXXXXXXXXXXX       Zp03       XXXXXXXXXXXXXXXXXXX'
$field48 = "\"Work_Center\"";
$field49 = "\"Plant\"";
$field50 = "\"Date\"";
$field51 = "\"Time\"";
$field52 = "\"N/P\"";
$field53 = "\"Order\"";
$field54 = "\"Operation No\"";
$field55 = "\"Emp\"";
$field56 = "\"Setup\"";
$field57 = "\"Unit\"";
$field58 = "\"Machine\"";
$field59 = "\"Unit1\"";
$field60 = "\"Labor\"";
$field61 = "\"Unit2\"";
$field62 = "\"Rework\"";
$field63 = "\"Unit3\"";
$field64 = "\"Qty\"";
$field65 = "\"BUn\"";
$field66 = "\"F\"";
$field67 = "\"Op_STD_Lab\"";
			


				
				
	$dow = date("w");			

if (($dow < 2) OR ($dow > 5)) {
$sql = "SELECT b.{$field20} as {$field50}, SUM(a.{$field62}) as sumrework FROM (SELECT * FROM {$schem}.{$tab} WHERE char_length({$schem}.{$tab}.{$field53}) > 5) a
	LEFT JOIN (SELECT CAST({$field53} as text),{$field20} FROM {$schem}.{$tab3} WHERE {$field8} = '101' AND CAST({$field53} as text) IN ( 
	SELECT DISTINCT {$field53} FROM {$schem}.{$tab} 
	WHERE {$field50} = CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-1 as TIMESTAMP)
	AND Substring({$field48},1,3)='". $argument1 ."_' AND {$field62} > 0) 
	GROUP BY {$field53},{$field20}
	UNION SELECT {$field53},{$field20} FROM {$schem}.{$tab2} WHERE {$field53} IN ( 
	SELECT DISTINCT {$field53} FROM {$schem}.{$tab} 
	WHERE {$field50} = CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-1 as TIMESTAMP)
	AND Substring({$field48},1,3)='". $argument1 ."_' AND {$field62} > 0)  
	GROUP BY {$field53},{$field20})  b
	ON b.{$field53} = a.{$field53}
WHERE a.{$field50} = CAST(current_date-CAST(date_part('dow',current_date+1) as INTEGER)-1 as TIMESTAMP)
AND a.{$field62} > 0
AND Substring(a.{$field48},1,3)='". $argument1 ."_'
and {$field49} = '". $argument2 ."'
GROUP BY b.{$field20};";

}
else
{
$sql = "SELECT b.{$field20} as {$field50}, SUM(a.{$field62}) as sumrework FROM (SELECT * FROM {$schem}.{$tab} WHERE char_length({$schem}.{$tab}.{$field53}) > 5) a
	LEFT JOIN (SELECT CAST({$field53} as text),{$field20} FROM {$schem}.{$tab3} WHERE {$field8} = '101' AND CAST({$field53} as text) IN ( 
	SELECT DISTINCT {$field53} FROM {$schem}.{$tab} 
	WHERE {$field50} = CAST((current_date-1) as TIMESTAMP)
	AND Substring({$field48},1,3)='". $argument1 ."_' AND {$field62} > 0) 
	GROUP BY {$field53},{$field20}
	UNION SELECT {$field53},{$field20} FROM {$schem}.{$tab2} WHERE {$field53} IN ( 
	SELECT DISTINCT {$field53} FROM {$schem}.{$tab} 
	WHERE {$field50} = CAST((current_date-1) as TIMESTAMP)
	AND Substring({$field48},1,3)='". $argument1 ."_' AND {$field62} > 0)  
	GROUP BY {$field53},{$field20})  b
	ON b.{$field53} = a.{$field53}
WHERE a.{$field50} = CAST((current_date-1) as TIMESTAMP)
AND a.{$field62} > 0
AND Substring(a.{$field48},1,3)='". $argument1 ."_'
and {$field49} = '". $argument2 ."'
GROUP BY b.{$field20};";}


//echo $sql;


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
                                 $jsonData[] = array('sumrework'=>$row['sumrework'],
								 'Date'=>$row['Date']);
								 //$jsonData[] = array('ID'=>['ID'],'Work_Center'=>['Work_Center'],'Plant'=>['Plant'],'Date'=>['Date'],'Time'=>['Time'],'N/P'=>['N/P'],'Order'=>['Order'],'Operation No'=>['Operation No'],'Emp'=>['Emp'],'Setup'=>['Setup'],'Unit'=>['Unit'],'Machine'=>['Machine'],'Unit1'=>['Unit1'],'Labor'=>['Labor'],'Unit2'=>['Unit2'],'Rework'=>['Rework'],'Unit3'=>['Unit3'],'Qty'=>['Qty'],'BUn'=>['BUn'],'F'=>['F']);
					
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

// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";
#XXXXXXXXXXXXXXXXXX        MB51     XXXXXXXXXXXXXXXXXXX'
$field5 = "\"Material Desccription\"";
$field6 = "\"Plant\"";
$field7 = "\"Storage Location\"";
$field8 = "\"Movement Type\"";
$field9 = "\"Movement Type Text\"";
$field10 = "\"Material Document\"";
$field11 = "\"Material Doc#Item\"";
$field12 = "\"Posting Date\"";
$field13 = "\"Qty in Un# of Entry\"";
$field14 = "\"Amount in LC\"";
$field15 = "\"Purchase Order\"";
$field16 = "\"Item\"";
$field17 = "\"Order\"";
$field18 = "\"Currency\"";
#XXXXXXXXXXXXXXXXXX   Coois Headers XXXXXXXXXXXXXXXXXXX'
$field19 = "\"Order\"";
$field20 = "\"Material\"";
$field21 = "\"MRP ctrlr\"";
$field22 = "\"Order Type\"";
$field23 = "\"Target qty\"";
$field24 = "\"Unit\"";
$field25 = "\"Bsc start\"";
$field26 = "\"Basic fin.\"";
$field27 = "\"Material Description\"";
$field28 = "\"System Status\"";
$field29 = "\"Firming Plant\"";
###'XXXXXXXXXXXX Coois Operations XXXXXXXXXXXXXXXXXXX'
$field30 = "\"Order\"";
$field31 = "\"Operation/Activity\"";
$field32 = "\"Work center\"";
$field33 = "\"Operation short text\"";
$field34 = "\"Operation Quantity\"";
$field35 = "\"Act#/Operation UoM\"";
$field36 = "\"ActStartDateExecution\"";
$field37 = "\"ActFinishDateExecutn\"";
$field38 = "\"LastFinishDateExecutn\"";
$field39 = "\"System Status\"";
$field40 = "\"Confirmed yield\"";
$field41 = "\"Standard value 3\"";
$field42 = "\"Confirmed activ# 3\"";
$field43 = "\"Rework qty\"";
$field44 = "\"Plant\"";
$field45 = "\"Processing time\"";
$field46 = "\"Standard text key\"";
##'XXXXXXXXXXXX       MB51 fields    XXXXXXXXXXXXXXXXXX'
$field4s='Material';
$field5s='Material Description';
$field6s="Plnt";
$field7s="SLoc";
$field8s="MvT";
$field9s="Movement Type Text";
$field10s="Mat. Doc.";
$field11s="Item";
$field12s="Pstng Date";
$field13s="Quantity";
$field14s="  Amount LC";
$field15s="PO";
$field16s="Item";
$field17s="Order";
$field18s="Crcy";
##'XXXXXXXXXXx       Coois_H         xXXXXXXXXXXXX'
$field19s="Order";
$field20s="Material";
$field21s="MRP ctrlr";
$field22s="Order Type";
$field23s="Target qty";
$field24s="Unit";
$field25s="Bsc start";
$field26s="Basic fin.";
$field27s="Material description";
$field28s="System Status";
$field29s="Firming";
$field30s="Plant";
##'XXXXXXXXXXXXX       Coois Ops Fields    XXXXXXXXXXXXXXXXXX'
$field31s="Order";
$field32s="Oper./Act.";
$field33s="Work cntr.";
$field34s="Opr. short text";
$field35s="Op. Qty";
$field36s="Act/Op.UoM";
$field37s="Act. start";
$field38s="Act.finish";
$field39s="LatestFin.";
$field40s="System Status";
$field41s="Yield";
$field42s="Std Value";
$field43s="Conf. act.";
$field44s="Rework";
$field45s="Plnt";
$field46s="Processing time";
$field47s="Standard text key";

	
	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}



?>