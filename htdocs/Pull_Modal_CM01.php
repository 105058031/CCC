<?php

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	$argument2 = $argv[2];
	$argument3 = $argv[3];
} else {
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

                $tab1 = "\"CM01_Det\"";
				$tab2= "\"COOIS_Head\"";
				$tab3= "\"COOIS_OPs\"";
				$plant= "\"Plnt\"";
				$Order= "\"Order\"";
				$Op= "\"Op.\"";
				$OpT= "\"Operation text\"";
				$Day= "\"Day\"";
				$MDay = "\"MDay\"";
				$wc= "\"Work Ctr\"";
				$MRP= "\"MRPCont\"";
				$latdate="\"LatestFin.\"";
				$tghost="\"ghost\"";
				$MOp = "\"Mop.\"";
				$MRPC = "\"MRP\"";
				$f="\"ord\"";
				$fr="\"rep\"";
				$Prim = "\"a\"";
				$Seco = "\"D\"";
				$OStat = "\"OStat\"";
				$Seq = "\"Seq\"";
				$Stat = "\"Stat\"";
				$PStat = "\"Prev Stat\"";

				##'XXXXXXXXXXX     CM01 Details        XXXXXXXXXXXXXXXX'
$field68 = "\"Day\"";
$field69 = "\"Material\"";
$field70 = "\"Material description\"";
$field71 = "\"Order\"";
$field72 = "\"Op.\"";
$field73 = "\"Stat\"";
$field74 = "\" PgRqmtQty\"";
$field75 = "\"  TgtSetup\"";
$field76 = "\"  TrgtProc\"";
$field77 = "\"Sales ord.\"";
$field78 = "\"LatestFin.\"";
$field79 = "\"MRP\"";
$field80 = "\"Work Ctr\"";
$field81 = "\"Plnt\"";
$field82 = "\"Operation text\"";
$field83 = "\"Finish\"";
$field99 = "\"OStat\"";
#{$Prim}.{$wc},{$Prim}.{$Op},{$Prim}.{$OpT},{$Prim}.{$Stat},{$Prim}.{$MRPC}
#,MAX({$Prim}.{$field74}) as {$field74},MAX({$Prim}.{$field76}) as {$field76},MAX({$Prim}.{$field78}) as {$field78},MAX({$Prim}.{$field83}) as {$field83}				
#WHERE {$Prim}.{$plant}='". $argument2 ."'
#		AND CAST({$Prim}.{$Order} as TEXT)='". $argument3 ."'
#GROUP BY {$wc}, {$Op},{$OpT},{$Stat},{$MRPC}	
$sql = "SELECT {$Prim}.{$wc},{$Prim}.{$Op},{$Prim}.{$OpT},{$Prim}.{$Stat},{$Prim}.{$MRPC}
,MAX({$Prim}.{$field74}) as {$field74},MAX({$Prim}.{$field76}) as {$field76},MAX({$Prim}.{$field78}) as {$field78},MAX({$Prim}.{$field83}) as {$field83}
FROM   ( SELECT {$wc}, {$Op},{$OpT},{$Stat},{$MRPC}, 
		{$field74},{$field76}, {$field78},{$field83}, {$field81}, {$field71} 
		from {$schem}.{$tab1}
		WHERE {$OStat} = 'REL') {$Prim}	
		WHERE {$Prim}.{$plant}='". $argument2 ."'
		AND CAST({$Prim}.{$Order} as TEXT)='". $argument3 ."'
		GROUP BY {$wc}, {$Op},{$OpT},{$Stat},{$MRPC}
ORDER BY {$Prim}.{$Op};";

#WHERE (Substring({$Prim}.{$wc},1,3)='". $argument1 ."_' or Substring({$Prim}.{$wc},1,2)='HP' or Substring({$Prim}.{$wc},1,3)='SF_') 

#echo "argument 1 : ".$argument1.PHP_EOL;
#echo "\t\n".PHP_EOL;
#echo "argument 2 : ".$argument2.PHP_EOL;
#echo "\t\n".PHP_EOL;
#echo "argument 3 : ".$argument3.PHP_EOL;
#echo "\t\n".PHP_EOL;
#echo $sql;

	
	//SELECT * FROM "dbtest"."CM01_Det" 
//INNER JOIN (SELECT "Order", Min("MOp.") FROM "dbtest"."CM01_Det" GROUP BY "Order") "ghost"
//ON "ghost"."Order" = "dbtest"."CM01_Det"."Order" and "ghost"."MOp." = "dbtest"."CM01_Det"."Op."
//WHERE Substring()

	
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
                                 $jsonData[] = array(
								 'Operation'=>$row['Op.'],
								 'Qty'=>$row[' PgRqmtQty'],
								 'Unit'=>'EA',
								 'MRPController'=>$row['MRP'],
								 'Material'=>$row['Material'],
								 'Mat_des'=>$row['Material description'],
								 'OpDescription'=>$row['Operation text'],
								 'LatestFinish'=>$row['LatestFin.'],
								 'ProcessTime'=>$row['  TrgtProc'],
								 'OrderFinish'=>$row['Finish'],
								 'WorkCenter'=>$row['Work Ctr'],
								 'Stat'=>$row['Stat']);
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