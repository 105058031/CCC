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

                $tab1 = "\"CM01_Det\"";
				$tab2= "\"COOIS_Head\"";
				$tab3= "\"COOIS_OPs\"";
				$plant= "\"Plnt\"";
				$Order= "\"Order\"";
				$Op= "\"Op.\"";
				$Day= "\"Day\"";
				$MDay = "\"MDay\"";
				$wc= "\"Work Ctr\"";
				$MRP= "\"MRPCont\"";
				$latdate="\"LatestFin.\"";
				$tghost="\"ghost\"";
				$MOp = "\"Mop.\"";
				$f="\"ord\"";
				$fr="\"rep\"";
				$Prim = "\"a\"";
				$Seco = "\"D\"";
				$OStat = "\"OStat\"";
				$Seq = "\"Seq\"";
				$Stat = "\"Stat\"";
				$PStat = "\"Prev Stat\"";

//on {$schem}.{$tab1}.{$Order}={$schem}.{$tab2}.{$Order}
$sql = "SELECT {$Prim}.*, 
CASE 
WHEN Substring({$Prim}.{$wc},4,7)='WIRE' THEN 1 
WHEN Substring({$Prim}.{$wc},4,7)='MECH' THEN 2 
WHEN Substring({$Prim}.{$wc},4,7)='TEST' THEN 3  
WHEN Substring({$Prim}.{$wc},1,8)='HPPT_RIG' THEN 4  
WHEN Substring({$Prim}.{$wc},1,8)='HPHT_RIG' THEN 5 
WHEN Substring({$Prim}.{$wc},1,7)='SF_INSP' THEN 6  
ELSE 7 END as {$f},
CASE 
WHEN {$Prim}.{$Order}>59999999 THEN 0 
ELSE 1 END as {$fr} 
FROM 
		(SELECT ROW_NUMBER() OVER (partition by {$Order} order by {$Op} DESC, {$Day}) as {$Seq}, *  from {$schem}.{$tab1}
		WHERE {$Stat} = 'PCNF' AND {$OStat} = 'REL'
		UNION 
		SELECT ROW_NUMBER() OVER (partition by {$Order} order by {$Op} ASC, {$Day}) as {$Seq}, *  from {$schem}.{$tab1}
		WHERE {$Stat} IN ('REL','PRT') AND {$OStat} = 'REL') {$Prim}
		WHERE {$Prim}.{$Seq} = 1
		AND (Substring({$Prim}.{$wc},1,3)='". $argument1 ."_' 
		or Substring({$Prim}.{$wc},1,2)='HP' 
		or Substring({$Prim}.{$wc},1,3)='SF_') 
		and {$Prim}.{$plant}='". $argument2 ."'
		ORDER BY  {$f} ASC , {$fr} DESC,   {$Prim}.{$latdate},{$Prim}.{$Order},{$Prim}.{$Op};";

//echo $sql;
	
	
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
                                 $jsonData[] = array('Order'=>$row['Order'],
								 'Operation'=>$row['Op.'],
								 'Qty'=>$row[' PgRqmtQty'],
								 'Unit'=>'EA',
								 'MRPController'=>$row['MRP'],
								 'Material'=>$row['Material'],
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

// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";


?>