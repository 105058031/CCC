<?php

if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
	$argument2 = $argv[2];
}
else {
    $argument1 = $_GET['argument1'];
	$argument2 = $_GET['argument2'];
}

//$serverName = "DX48Q02\SQLEXPRESS"; 
//serverName\instanceName

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
				$tab2 = "\"tab2\"";
				$wc= "\"Work Ctr\"";
				$HReq= "\" Requirements\"";
				$HRq = "\"Req\"";
				$HAva= "\"Available_cap\"";
				$HAv = "\"Ava\"";
				$HRem= "\"Rem\"";
				$Date= "\"Date\"";
				$Plant= "\"Plnt\"";
				$Ct= "\"Ct\"";
				$WCA= "\"WC\"";
				$Day = "\"Day\"";
								

$sql = "SELECT f.{$wc} as {$WCA}, CAST(f.{$HRq} as numeric) as {$HRq}, cast(f.{$HAv} as numeric) as {$HAv}, 
CASE (f.{$HRq}-f.{$HAv})>0
WHEN TRUE THEN (f.{$HAv}-f.{$HRq})
ELSE 0 
END as {$HRem}, f.{$Day} as {$Date} FROM (SELECT {$wc}, {$Day}, Max({$HReq}) as {$HRq},Max({$HAva}) as {$HAv}
FROM {$schem}.{$tab1}
WHERE Substring({$wc},1,3) = '".$argument1."_'
AND {$Plant} = '".$argument2."'
AND {$Day} < CAST((Current_date+7) as TIMESTAMP)
GROUP BY {$wc}, {$Day}
ORDER BY {$wc},{$Day} ASC) as f ;";								


$sql = substr($sql,0,strlen($sql)-1).";";

//echo $sql;
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
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
	  $jsonData[] = array('WC'=>$row['WC'],'Req'=>$row['Req'],'Ava'=>$row['Ava'],'Rem'=>$row['Rem'],'Date'=>$row['Date']);	
}

$stringData= json_encode($jsonData );
echo $stringData;
// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";
				}

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>

