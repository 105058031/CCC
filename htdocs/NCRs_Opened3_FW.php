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

                $tab = "\"NCR_Data\"";
				$NCR= "\"NCR#\"";
				$CL= "\"Cell\"";
				$PD= "\"Logged Date 2\"";
				$fieldNCR= "\"countncr\"";
				$field1 = "\"Activity\"";
				$STS="\"Pending\"";
				$Part = "\"Part# 2\"";
	$field2 = "\"Start\"";
	$field2s = "Material Description";
	$field3 = "\"Finish\"";
	$field4 = "\"Material\"";
###'XXXXXXXXXXXX       Zp03       XXXXXXXXXXXXXXXXXXX'
$field47 = "\"Work_Center\"";
$field48 = "\"Plant\"";
$field49 = "\"Date\"";
$field50 = "\"Time\"";
$field51 = "\"N/P\"";
$field52 = "\"Order\"";
$field53 = "\"Operation No\"";
$field54 = "\"Emp\"";
$field55 = "\"Setup\"";
$field56 = "\"Unit\"";
$field57 = "\"Machine\"";
$field58 = "\"Unit1\"";
$field59 = "\"Labor\"";
$field60 = "\"Unit2\"";
$field61 = "\"Rework\"";
$field62 = "\"Unit3\"";
$field63 = "\"Qty\"";
$field64 = "\"BUn\"";
$field65 = "\"F\"";
$field66 = "\"Op_STD_Lab\"";

##'XXXXXXXXXXX     ZP03 fields        XXXXXXXXXXXXXXXX'
$field48s="Work_Center";
$field49s="Plant";
$field50s="Date";
$field51s="Time";
$field52s="N/P";
$field53s="Order";
$field54s="Operation No";
$field55s="Emp";
$field56s="Setup";
$field57s="Unit1";
$field58s="Machine";
$field59s="Unit2";
$field60s="Labor";
$field61s="Unit3";
$field62s="Rework";
$field63s="Unit4";
$field64s="Qty";
$field65s="BUn";
$field66s="F";
$field67s="Op_Std_Labor";

			

	$dow = date("w");			

					
//$dow =1 ;
if (($dow < 2) OR ($dow > 5)) {
$sql = "SELECT
  {$NCR} as {$PD},
	  {$Part}  as {$fieldNCR}
FROM {$schem}.{$tab}
where 
{$CL} = '".$argument1."'
and {$PD} < CAST((current_date+1) as TIMESTAMP)
and {$PD} > CAST((current_date-4) as TIMESTAMP)
AND {$STS} <> 'Pending'
ORDER BY {$PD} ASC;";
}else {
$sql = "SELECT
  {$NCR} as {$PD},
	  {$Part}  as {$fieldNCR}
FROM {$schem}.{$tab}
where 
{$CL} = '".$argument1."'
and {$PD} < CAST((current_date+1) as TIMESTAMP)
and {$PD} > CAST((current_date-2) as TIMESTAMP)
AND {$STS} <> 'Pending'
ORDER BY {$PD} ASC;";
}
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
                                 $jsonData[] = array('countncr'=>$row['countncr'],
								 'Logged_Date_2'=>$row['Logged Date 2']);
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
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>