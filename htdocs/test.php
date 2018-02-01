<?php

echo "User: ". $_ENV['USER'].PHP_EOL;
echo PHP_EOL;
echo "VCAP_APP: ".$_ENV['VCAP_APPLICATION'].PHP_EOL .PHP_EOL .PHP_EOL;
echo "VCAP_SERVICES: ".$_ENV['VCAP_SERVICES'].PHP_EOL .PHP_EOL .PHP_EOL;
$ip = "REMOTE ADDR: ".$_SERVER['REMOTE_ADDR'].PHP_EOL;
echo $ip;
$root = "DOC ROOT: ".getenv("DOCUMENT_ROOT").PHP_EOL ; 
 Echo $root;
$ad = "ADM: ".getenv("SERVER_ADMIN").PHP_EOL ; 
 Echo $ad; 
 echo "Server: ".$_SERVER['SERVER_NAME'].PHP_EOL;
 $hs = "HOST: ".getenv("HOST").PHP_EOL ; 
 Echo $hs;
 $hm = "Home: ".getenv("HOME").PHP_EOL ; 
 Echo $hm;
 $hostname = "HostName: ".getenv('HOSTNAME').PHP_EOL; 
 echo $hostname;
 echo "The condition is 10.96.126.30";
 echo "IS IT TRUE?";
 echo getenv('HOSTNAME')==="10.96.126.30";
 $HST = "HTTP_HOST: ".$_SERVER["HTTP_HOST"].PHP_EOL;
 echo $HST ;
 
$ip = $_SERVER['REMOTE_ADDR'];
echo $ip . "\r\n".PHP_EOL;
$pt = getenv('path');
echo $pt. "\r\n".PHP_EOL;
$root = getenv("DOCUMENT_ROOT") ; 
 Echo $root. "\r\n";
$ad = getenv("SERVER_ADMIN") ; 
 Echo $ad. "\r\n";
 echo $_SERVER['SERVER_NAME']. "\n";;
 $hs = getenv("HOST") ; 
 Echo $hs. "\r\n";
 $hm = getenv("HOME") ; 
 Echo $hm. "\r\n";
 $hostname = getenv('HOSTNAME'); 
 echo $hostname. "\r\n";
 $HST = $_SERVER["HTTP_HOST"];
 echo $HST. "\r\n";
 $HST = $_SERVER['SERVER_ADDR'];
 echo "\r\n Server Address: " . $HST. "\r\n";
 $HST = $_SERVER['SERVER_PORT'];
 echo "\r\n Server Port: " . $HST. "\r\n";
 
?>