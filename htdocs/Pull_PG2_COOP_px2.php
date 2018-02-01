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
				$tab2= "\"Coois_Headers\"";
				$tab3= "\"Coois_Ops\"";
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
				$PCNF = "\"PCNF\"";
				$PStat = "\"Prev Stat\"";
				$field95="\"Pull_Date\""; 
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
//on {$schem}.{$tab1}.{$Order}={$schem}.{$tab2}.{$Order}
#XXXXXXXXXXXXXXXXXX   Coois Headers XXXXXXXXXXXXXXXXXXX'
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

###'XXXXXXXXXXXX Coois Operations XXXXXXXXXXXXXXXXXXX'
$field31 = "\"Order\"";
$field32 = "\"Oper./Act.\"";
$field33 = "\"Work cntr.\"";
$field34 = "\"Operation short text\"";
$field35 = "\"Op. Qty\"";
$field36 = "\"Act/Op.UoM\"";
$field37 = "\"Act. start\"";
$field38 = "\"Act.finish\"";
$field39 = "\"LatestFin.\"";
$field40 = "\"System Status\"";
$field41 = "\"Yield\"";
$field42 = "\"Std Value\"";
$field43 = "\"Conf. act.\"";
$field44 = "\"Rework\"";
$field45 = "\"Plnt\"";
$field46 = "\"Processing\"";
$field47 = "\"Text key\"";

$sql = "SELECT gh.* FROM (SELECT 
CASE 
WHEN Substring(a.{$field33},4,7)='WIRE' THEN 1 
WHEN Substring(a.{$field33},4,7)='MECH' THEN 2 
WHEN Substring(a.{$field33},4,7)='TEST' THEN 3 
WHEN Substring(a.{$field33},1,8)='HPPT_RIG' THEN 4 
WHEN Substring(a.{$field33},1,8)='HPHT_RIG' THEN 5 
WHEN Substring(a.{$field33},1,7)='STORES' AND to_number(a.{$field32},'9999') < 30 THEN 6
WHEN Substring(a.{$field33},1,7)='STORES' AND to_number(a.{$field32},'9999') < 9990 THEN 7 
WHEN Substring(a.{$field33},1,7)='STORES' AND to_number(a.{$field32},'9999') > 9988 THEN 8 
WHEN Substring(a.{$field33},1,7)='SF_INSP' THEN 9
ELSE 10 END as {$f},
CASE 
WHEN CAST(a.{$field31} as numeric)>59999999 
THEN 0 ELSE 1 END as {$fr}, 
ROW_NUMBER() OVER (partition by a.{$field31} order by a.{$field32}) as {$Seq}, 
CASE 
WHEN Substring(a.{$field40},1,4)='PCNF' THEN 'PCNF' 
WHEN Substring(replace(a.{$field40}, 'EODL ', ''),1,7)='PRT REL' THEN 'REL' 
WHEN Substring(replace(a.{$field40}, 'EODL ', ''),1,3)='REL' THEN 'REL' 
WHEN Substring(a.{$field40},1,4)='CRTD' THEN 'CRTD' 
WHEN Substring(a.{$field40},1,4)='PREL' THEN 'PART' 
WHEN Substring(a.{$field40},1,4)='OPGN' THEN 'GENE' 
ELSE '-' END
as {$PCNF},
sd.*,
a.*
FROM ( SELECT * FROM {$schem}.{$tab3} WHERE {$field19} IN 
(SELECT b.{$field19} FROM (SELECT {$field19}, CASE 
WHEN Substring({$field33},1,3)='". $argument1 ."_'
THEN 1
ELSE 0 END as IND FROM {$schem}.{$tab3}) b
WHERE IND > 0)) a
INNER JOIN (SELECT DISTINCT {$field31} as f,{$field20}, {$field26}, {$field40},{$field27}, {$field21} FROM {$schem}.{$tab2} 
WHERE SUBSTRING({$field40},1,3)='REL' OR SUBSTRING({$field40},1,4)='PREL' ) sd
ON CAST(sd.f as text) = CAST(a.{$field31} as  text)
WHERE a.{$field45} ='". $argument2 ."'
AND SUBSTRING(a.{$field40},1,3) <> 'CNF' AND SUBSTRING(a.{$field40},1,4) <> 'CRTD'
AND {$field41} < 1
AND a.{$field95} > CAST((current_date-1) as TIMESTAMP)
ORDER BY {$f} ASC , {$fr} DESC, {$Seq} ASC, {$field39},{$field31},{$field32}) gh
WHERE gh.{$Seq} = 1
AND (Substring(gh.{$field33},1,3)='". $argument1 ."_'  or Substring(gh.{$field33},1,2)='HP' or Substring(gh.{$field33},1,3)='SF_' or gh.{$field33} = 'STORES')"
;

//echo " Query: <br/>";
//echo $sql . "<br/>"."<br/>";
	
	
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
								 'Operation'=>$row['Oper./Act.'],
								 'Qty'=>$row['Op. Qty'],
								 'Unit'=>'EA',
								 'MRPController'=>$row['MRP ctrlr'],
								 'Material'=>$row['Material'],
								 'Mat_des'=>$row['Material description'],
								 'OpDescription'=>$row['Operation short text'],
								 'LatestFinish'=>$row['LatestFin.'],
								 'ProcessTime'=>$row['Processing'],
								 'OrderFinish'=>$row['Basic fin.'],
								 'WorkCenter'=>$row['Work cntr.'],
								 'Stat'=>$row['PCNF'],
								 'ord'=>$row['ord']);
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