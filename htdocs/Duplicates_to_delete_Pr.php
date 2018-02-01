


<?php 

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
    }
else {
    $argument1 = $_GET['argument1'];
    }

require_once __DIR__ .'/../vendor/autoload.php';
use CfCommunity\CfHelper\CfHelper;
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
$cfHelper = CfHelper::getInstance();
try {
    //if we are in cloud foundry we use the connection given by cf-helper-php otherwise we use our database in local
    if ($cfHelper->isInCloudFoundry()) {
        $logger = CfHelper::getInstance()->getLogger();
        $logger->info("Trying to query data");
        $db = $cfHelper->getDatabaseConnector()->getConnection();

	
 #$db = new PDO('pgsql:dbname=postgres;host=127.0.0.1;port=5432;user=postgres;password=Pa55word');
	$postdata = file_get_contents("php://input"); 
	$json = array();
	$json = json_decode($postdata);
 
	$schem = "\"dbtest\"";
	$tab = "\"MB_test\"";
	$field1 = "\"Activity\"";
	$field2 = "\"Start\"";
	$field2s = "Material Description";
	$field3 = "\"Finish\"";
	$field4 = "\"Material\"";
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
$field34s="Operation short text";
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
$field46s=" Processing";
$field47s="Text key";


##'XXXXXXXXXXXX       MB51 fields    XXXXXXXXXXXXXXXXXX'
$field4s="Material";
$field5s="Material Description";
$field6s="Plnt";
$field7s="SLoc";
$field8s="MvT";
$field9s="Movement Type Text";
$field10s="Mat. Doc.";
$field11s="Item";
$field12s="Pstng Date";
$field13s="Qty in UnE";
$field14s="  Amount LC";
$field15s="PO";
$field16s="Item";
$field17s="Order";
$field18s="Crcy";
#XXXXXXXXXXXXXx          CM01 Fields at phppgadmin      XXXXXXXXXXXXXXXXXXX
$field68s = "Day";
$field69s = "Material";
$field70s = "Material description";
$field71s = "Order";
$field72s = "Op.";
$field73s = "Stat";
$field74s = " PgRqmtQty";
$field75s = " TgtSetup";
$field76s = " TrgtProc";
$field77s = "Sales ord.";
$field78s = "LatestFin.";
$field79s = "MRP";
$field80s = "Work Ctr";
$field81s = "Plnt";
$field82s = "Operation text";
$field83s = "Finish";



	
 
     $tab = "\"ZP03\"";
	$sql = "delete from {$schem}.{$tab}
    where exists (select 1
                  from (SELECT *,ROW_NUMBER() OVER (PARTITION BY (CAST({$schem}.{$tab}.{$field50} as text) || CAST( {$schem}.{$tab}.{$field51} as text)||Cast({$schem}.{$tab}.{$field55} as text))) as Cnt FROM {$schem}.{$tab}) t2
                  where t2.{$field50} = {$schem}.{$tab}.{$field50} and
                        t2.{$field51} = {$schem}.{$tab}.{$field51} and
                        t2.{$field55} = {$schem}.{$tab}.{$field55} and
                       t2.Cnt > 1);";
echo $sql;
					   $result = $db->query($sql);
if  (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print($db->errorInfo()));
	
	} 
	else 
	{
		echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
	}
	 $tab = "\"MB51\"";
	$sql = "delete from {$schem}.{$tab}
    where exists (select 1
                  from (SELECT *,ROW_NUMBER() OVER (PARTITION BY (CAST({$schem}.{$tab}.{$field10} as text) || CAST( {$schem}.{$tab}.{$field11} as text)||Cast({$schem}.{$tab}.{$field12} as text))) as Cnt FROM {$schem}.{$tab}) t2
                  where t2.{$field10} = {$schem}.{$tab}.{$field10} and
                        t2.{$field11} = {$schem}.{$tab}.{$field11} and
                        t2.{$field12} = {$schem}.{$tab}.{$field12} and
                       t2.Cnt > 1);";
echo $sql;
					   $result = $db->query($sql);
	if  (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print($db->errorInfo()));
	
	} 
	else 
	{
		echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
	}
	
	}
	
	
	
	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

	
#echo $postdata

?>


