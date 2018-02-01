<?php
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

				$tab1 = "\"ActionItems\"";
				$plant= "\"plant\"";
				$shared= "\"shared\"";
				$topic= "\"topic\"";
				$wc= "\"wc\"";
				$id= "\"id\"";
				$sharedtxt= "\"sharedtxt\"";
				$var="$$";
	
 
$sql = "CREATE OR REPLACE FUNCTION SHAR(i numeric, top as text, wc as text, pl as text, shtxt as text) RETURNS boolean AS {$var}
    BEGIN


IF (SELECT {$shared} FROM {$schem}.{$tab1} WHERE {$id} = i) THEN
    IF (SELECT {$sharedtxt} FROM {$schem}.{$tab1} WHERE {$id} = i) LIKE '%-'||shtext||'-%' THEN
        
		IF (SELECT trim(both '-'||shtxt||'-' FROM {$sharedtxt}) FROM {$schem}.{$tab1} WHERE {$id} = i) = '' THEN
			UPDATE {$schem}.{$tab1}
			SET {$shared} = FALSE,
			{$sharedtxt} = ''
			WHERE {$id} = i
			AND {$topic} = top
			AND {$plant} = pl
			AND {$wc} = wc;
                        
			
		ELSE
			UPDATE {$schem}.{$tab1}
			SET {$sharedtxt} = trim(both '-'||shtxt||'-' FROM {$sharedtxt})
			WHERE {$id} = i
			AND {$topic} = top
			AND {$plant} = pl
			AND {$wc} = wc;
                        
		END IF;		
		
    ELSE
	    UPDATE {$schem}.{$tab1}
			SET {$sharedtxt} = {$sharedtxt}||'-'||shtxt||'-'
			WHERE {$id} = i
			AND {$topic} = top
			AND {$plant} = pl
			AND {$wc} = wc;
                        
		
    END IF;


ELSE
    UPDATE {$schem}.{$tab1}
    SET {$shared} = TRUE, {$sharedtxt} = {$sharedtxt}||'-'||shtxt||'-'
    WHERE {$id} = i
    AND {$topic} = top
    AND {$plant} = pl
    AND {$wc} = wc;
    

END IF;
RETURN TRUE;

    END;
    {$var} LANGUAGE plpgsql;";
   //SELECT SHR(".$argument3.");
  
 echo $sql;
 $result = $db->query($sql);
 
if (!$result) 
	{
		echo '<p>Ungültige Anfrage: </p>';
    die('  '. print_r($db->errorInfo()));
	
	} 
	else 
	{
		//echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
	}
	//$sql= "SELECT SHR(".$argument3.");";
//$result = $db->query($sql);
 
//if (!$result) 
	//{
	//	echo '<p>Ungültige Anfrage: </p>';
//    die('  '. print_r($db->errorInfo()));
	
///	} 
//	else 
//	{
		//echo "<br></br>Anfrage erfolgreich ausgeführt! <br></br> Ehrgeiz und Ehre! <br></br> Pracht und Ruhm für Programmierer";
//	}
	


//$stmt = sqlsrv_query( $serverName, $sql );
//if( $stmt === false) {
//    die( print_r( sqlsrv_errors(), true) );
//}

	
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>

