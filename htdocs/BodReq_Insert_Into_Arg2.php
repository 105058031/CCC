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
 
 $fieldPLL = "\"Pull_Date\"";
 
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
$field11 = "\"Item1\"";
$field12 = "\"Pstng Date\"";
$field13 = "\"Qty in UnE\"";
$field14 = "\"Amount LC\"";
$field15 = "\"PO\"";
$field16 = "\"Item\"";
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
$field99 = "\"OStat\"";

##XXXXXXXXXXXXXXXXXX        NCR_data           XXXXXXXXXXXXXXXXXXXX
$field84 = "\"Pending\"";
$field85 = "\"NCR#\"";
$field86 = "\"Part# 2\"";
$field87 = "\"Pending Stage\"";
$field88 = "\"Owner Inits\"";
$field89 = "\"Logged Date 2\"";
$field90 = "\"Cell\"";
$field91 = "\"CCC?\"";


##XXXXXXXXXXXXXXXXXX        NCR_fields          XXXXXXXXXXXXXXXXXXXX
$field84s = "Pending";
$field85s = "NCR#";
$field86s = "Part# 2";
$field87s = "Pending Stage";
$field88s = "Owner Inits";
$field89s = "Logged Date 2";
$field90s = "Cell";
$field91s = "CCC?";

##XXXXXXXXXXXXXXXXXX        META_data           XXXXXXXXXXXXXXXXXXXX
$field92 = "\"Table\"";
$field93 = "\"Feedback_Type\"";
$field94 = "\"Datetime\"";
$field96 = "\"Status_Code\"";

##XXXXXXXXXXXXXXXXXX        META_data           XXXXXXXXXXXXXXXXXXXX
$field92s = "Table";
$field93s = "Feedback_Type";
$field94s = "Datetime";
$field96s = "Status_Code";

##XXXXXXXXXXXXXXXXXX        CM01_Extra_data           XXXXXXXXXXXXXXXXXXXX
$field97 = "\"Available_cap\"";
$field98 = "\" Requirements\"";

##XXXXXXXXXXXXXXXXXX        CM01_Extra_data           XXXXXXXXXXXXXXXXXXXX
$field97s = "Available capacit";
$field98s = " Requirements";
$field99s = "OStat";
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
$field34s="Opr. short text";
$field35s="Op. Qty";
$field36s="Act/Op.UoM";
$field37s="Act. start";
$field38s="Act.finish";
$field39s="LatestFin.";
$field40s="System Status";
$field41s=" Yield";
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
$field16s="Item1";
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
$field95="\"Pull_Date\""; 

$sql1 = '1';
	switch ($argument1) {
    case 'log':
	$tab = "\"Pull_Log\"";
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field1},{$field2},{$field3})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->Activity."','".$ro->Start."','".$ro->Finish."'),";
	}
	break;
    case 'MB51':
    $tab = "\"MB51\"";
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field4},{$field5},{$field6},{$field7},{$field8},{$field9},{$field10},{$field11},{$field12},{$field13},{$field14},{$field15},{$field16},{$field17},{$field18})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field4s."','".$ro->$field5s."','".$ro->$field6s."','".$ro->$field7s."',to_number(NULLIF('".$ro->$field8s."','-'),'9999999999'),'".$ro->$field9s."',to_number(NULLIF('".$ro->$field10s."','-'),'9999999999'),CAST(NULLIF(trim( both ' ' from '".$ro->$field11s."'),'-') as INTEGER),to_timestamp('".$ro->$field12s."','dd.mm.yyyy'),CAST(to_number(NULLIF('".$ro->$field13s."','-'),'9999999999') as INTEGER),to_number('".$ro->$field14s."','99G999G999D9S'),to_number(NULLIF('".$ro->$field15s."','-'),'9999999999'),NULLIF('".$ro->$field16s."','-')::int,to_number(NULLIF('".$ro->$field17s."','-'),'9999999999'),'".$ro->$field18s."'),";
	}
	break;
    case 'ZP03':
     $tab = "\"ZP03\"";
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field48},{$field49},{$field50},{$field51},{$field52},{$field53},{$field54},{$field55},{$field56},{$field57},{$field58},{$field59},{$field60},{$field61},{$field62},{$field63},{$field64},{$field65},{$field66})
VALUES ";
//,,{$field59},{$field60},{$field61},{$field62},{$field63},{$field64},{$field65},{$field66},{$field67}
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field48s."','".$ro->$field49s."',to_timestamp('".$ro->$field50s."','dd.mm.yyyy'),to_timestamp('".$ro->$field51s."','HH24:MI:SS'),'".$ro->$field52s."','".$ro->$field53s."','".$ro->$field54s."','".$ro->$field55s."',".$ro->$field56s.",'".$ro->$field57s."',".$ro->$field58s.",'".$ro->$field59s."',".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."'),";
	}//,".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."',".$ro->$field67s."
	break;
	case 'Coois_H':
    $tab = "\"Coois_Headers\"";
	$sql0 = "DELETE FROM {$schem}.{$tab} WHERE {$field95} < CAST((current_date-14) as timestamp);";
	$result = $db->query($sql0);
	$sql1 = "delete from {$schem}.{$tab}
    where exists (select 1
                  from (SELECT * FROM {$schem}.{$tab}) t2
				where t2.{$field19} = {$schem}.{$tab}.{$field19} and
                        t2.{$field20} = {$schem}.{$tab}.{$field20} and
                       t2.{$field95} > {$schem}.{$tab}.{$field95});";
					   
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field19},{$field20},{$field21},{$field22},{$field23},{$field24},{$field25},{$field26},{$field27},{$field28},{$field29},{$field30},{$field95})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."(CAST(".$ro->$field19s." as TEXT),CAST('".$ro->$field20s."' as text),'".$ro->$field21s."','".$ro->$field22s."',".$ro->$field23s.",'".$ro->$field24s."',to_timestamp('".$ro->$field25s."','dd.mm.yyyy'),to_timestamp('".$ro->$field26s."','dd.mm.yyyy'),'".$ro->$field27s."','".$ro->$field28s."','".$ro->$field29s."',".$ro->$field30s.",CURRENT_TIMESTAMP),";
	}
	break;
	case 'Coois_O':
    $tab = "\"Coois_Ops\"";
	$sql0 = "DELETE FROM {$schem}.{$tab} WHERE {$field95} < CAST((current_timestamp-(2 ||' minutes')::interval) as timestamp);";
	$result = $db->query($sql0);
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field31},{$field32},{$field33},{$field34},{$field35},{$field36},{$field37},{$field38},{$field39},{$field40},{$field41},{$field42},{$field43},{$field44},{$field45},{$field46},{$field95})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."(".$ro->$field31s.",'".$ro->$field32s."','".$ro->$field33s."','".$ro->$field34s."',".$ro->$field35s.",'".$ro->$field36s."',to_timestamp(NULLIF('".$ro->$field37s."','-'),'dd.mm.yyyy'),to_timestamp(NULLIF('".$ro->$field38s."','-'),'dd.mm.yyyy'),to_timestamp(NULLIF('".$ro->$field39s."','-'),'dd.mm.yyyy'),'".$ro->$field40s."',".$ro->$field41s.",to_number(NULLIF('".$ro->$field42s."','-'),'999D99S'),to_number(NULLIF('".$ro->$field43s."','-'),'99999999D9S'),to_number(NULLIF('".$ro->$field44s."','-'),'99999999D9S'),'".$ro->$field45s."',to_number(NULLIF(trim( both ' ' from '".$ro->$field46s."'),'-'),'99999999D9S'),CURRENT_TIMESTAMP),";
	}
	break;	
	
	case 'CM01':
    $tab = "\"CM01_Det\"";
	$sql0 = "DELETE FROM {$schem}.{$tab};";
	// WHERE {$field95} < CAST((current_timestamp-(10 ||' minutes')::interval) as timestamp)
	$result = $db->query($sql0);
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field68},{$field69},{$field70},{$field71},{$field72},{$field73},{$field74},{$field75},{$field76},{$field77},{$field78},{$field79},{$field80},{$field81},{$field82},{$field83},{$field97},{$field98},{$field99},{$field95} )
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."(to_timestamp('".$ro->$field68s."','dd.mm.yyyy'),'".$ro->$field69s."','".$ro->$field70s."',to_number(NULLIF('".$ro->$field71s."','-'),'999999999'),CAST('".$ro->$field72s."' as integer),'".$ro->$field73s."',to_number(NULLIF('".$ro->$field74s."','-'),'9C999C999'),to_number(NULLIF('".$ro->$field75s."','-'),'999999D9S'),to_number(NULLIF('".$ro->$field76s."','-'),'999999D9S'),to_number(NULLIF('".$ro->$field77s."','-'),'999999999'),to_timestamp('".$ro->$field78s."','dd.mm.yyyy'),'".$ro->$field79s."','".$ro->$field80s."','".$ro->$field81s."','".$ro->$field82s."',to_timestamp('".$ro->$field83s."','dd.mm.yyyy'),to_number(NULLIF('".$ro->$field97s."','-'),'999999D9S'),to_number(NULLIF('".$ro->$field98s."','-'),'999999D9S'),'".$ro->$field99s."',CURRENT_TIMESTAMP),";
	}
	break;
	
	case 'NCR':
    $tab = "\"NCR_Data\"";
	$sql0 = "DELETE FROM {$schem}.{$tab};";
	$result = $db->query($sql0);
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field84},{$field85},{$field86},{$field87},{$field88},{$field89},{$field90},{$field91})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field84s."','".$ro->$field85s."','".$ro->$field86s."','".$ro->$field87s."','".$ro->$field88s."',to_timestamp('".$ro->$field89s."','dd/mm/yyyy'),'".$ro->$field90s."','".$ro->$field91s."'),";
	}
	break;
	
	case 'MB512':
    $tab = "\"MB51\"";
	$sql1 = "delete from {$schem}.{$tab}
    where exists (select 1
                  from (SELECT * FROM {$schem}.{$tab}) t2
				where t2.{$field10} = {$schem}.{$tab}.{$field10} and
                        t2.{$field16} = {$schem}.{$tab}.{$field16} and
                        t2.{$field12} = {$schem}.{$tab}.{$field12} and
                       t2.{$fieldPLL} > {$schem}.{$tab}.{$fieldPLL});";

	
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field4},{$field5},{$field6},{$field7},{$field8},{$field9},{$field10},{$field11},{$field12},{$field13},{$field14},{$field15},{$field16},{$field17},{$field18},{$fieldPLL})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field4s."','".$ro->$field5s."','".$ro->$field6s."','".$ro->$field7s."',to_number(NULLIF('".$ro->$field8s."','-'),'9999999999'),'".$ro->$field9s."',to_number(NULLIF('".$ro->$field10s."','-'),'9999999999'),CAST(NULLIF(trim( both ' ' from '".$ro->$field11s."'),'-') as INTEGER),to_timestamp('".$ro->$field12s."','dd-mm-yyyy'),CAST(to_number(NULLIF('".$ro->$field13s."','-'),'9999999999') as INTEGER),to_number('".$ro->$field14s."','99G999G999D9S'),to_number(NULLIF('".$ro->$field15s."','-'),'9999999999'),NULLIF('".$ro->$field16s."','-')::int,to_number(NULLIF('".$ro->$field17s."','-'),'9999999999'),'".$ro->$field18s."',CURRENT_TIMESTAMP),";
	}
	break;
	
    case 'ZP032':
     $tab = "\"ZP03\"";
	$sql1 = "delete from {$schem}.{$tab}
    where exists (select 1
                  from (SELECT * FROM {$schem}.{$tab}) t2
                  where t2.{$field50} = {$schem}.{$tab}.{$field50} and
                        t2.{$field51} = {$schem}.{$tab}.{$field51} and
                        t2.{$field55} = {$schem}.{$tab}.{$field55} and
                       t2.{$fieldPLL} > {$schem}.{$tab}.{$fieldPLL});";
					   
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field48},{$field49},{$field50},{$field51},{$field52},{$field53},{$field54},{$field55},{$field56},{$field57},{$field58},{$field59},{$field60},{$field61},{$field62},{$field63},{$field64},{$field65},{$field66},{$fieldPLL})
VALUES ";
//,,{$field59},{$field60},{$field61},{$field62},{$field63},{$field64},{$field65},{$field66},{$field67}
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field48s."','".$ro->$field49s."',to_timestamp('".$ro->$field50s."','dd/mm/yyyy'),to_timestamp('".$ro->$field51s."','HH24:MI:SS'),'".$ro->$field52s."','".$ro->$field53s."','".$ro->$field54s."','".$ro->$field55s."',".$ro->$field56s.",'".$ro->$field57s."',".$ro->$field58s.",'".$ro->$field59s."',".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."',CURRENT_TIMESTAMP),";
	}//,".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."',".$ro->$field67s."
	break;
	 
	case 'MTDWN':
     $tab = "\"METADATA\"";
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field92},{$field93},{$field94},{$field96})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field92s."','".$ro->$field93s."',to_timestamp('".$ro->$field94s."','dd/mm/yyyy HH24:MI:SS'),'".$ro->$field96s."'),";
	}//,".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."',".$ro->$field67s."
	break;
	
	case 'MTPSH':
	$tab = "\"METADATA\"";
	$sql = "INSERT INTO  {$schem}.{$tab} ({$field92},{$field93},{$field94},{$field96})
VALUES ";
	foreach ($json as $ro)
	{
		$sql = $sql."('".$ro->$field92s."','".$ro->$field93s."',to_timestamp('".$ro->$field94s."','dd/mm/yyyy HH24:MI:SS'),'".$ro->$field96s."'),";
	}//,".$ro->$field60s.",'".$ro->$field61s."',".$ro->$field62s.",'".$ro->$field63s."',".$ro->$field64s.",'".$ro->$field65s."','".$ro->$field66s."',".$ro->$field67s."
	break;
	
	
}

	$sql = substr($sql,0,strlen($sql)-1).";";
	
	echo $sql;
	
	}
	$result = $db->query($sql);
	if  (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print($db->errorInfo()));
	
	} 
	else 
	{
		echo "<br></br>Anfrage erfolgreich ausgefuhrt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm fur Programmierer";
	}
	
	if ($sql1!='1')
	{
	echo $sql1;
	$result = $db->query($sql1);
	if  (!$result) 
	{
		echo '<p>Zweite Anfrage Ungültig definiert: </p>';
    die('  '. print($db->errorInfo()));
	
	} 
	else 
	{
		echo "<br></br>Anfrage nocheinmal erfolgreich ausgefuhrt! <br></br> Mehr Ehrgeiz und Ehre! <br></br> Viele Pracht und Ruhm fur Programmierer";
	}
	}
	
	
	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

	
#echo $postdata

?>


