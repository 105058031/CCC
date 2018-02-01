<?php
include 'MSSQL_Connection.php';
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$sql = "SELECT distinct hgrd.Material
FROM (SELECT k.*, g.[Labor] as Sum_Std FROM 
(Select h.[Posting Date]
	  ,j.[Work_Center]
      ,j.[Order]
      ,sum(j.[Labor]) as Sum_Lab    
	  ,h.[Material]
	  , h.[Movement Type]
  FROM [Searing_Dragon_Hell_Fire].[dbo].[ZP03] j
  left join [Searing_Dragon_Hell_Fire].[dbo].[MB51] h
  on h.[Order]=convert(float,j.[Order])
  group by h.[Posting Date],j.[Work_Center],j.[order],h.[Material], h.[Movement Type]) k
  left join [Searing_Dragon_Hell_Fire].[dbo].[Routing] g
  on g.[Material]=k.[Material]
  and g.[Work Ctr]=k.[Work_Center]

    where k.[Material] is not null
  and k.[Movement Type] = 101) hgrd";
   
   
if( $conn ) {
     //echo "Connection established.<br />";
	 //echo $sql ."<br />";
}else{
     //echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}



$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	  $jsonData[] = array('Material'=>$row['Material']);	
}

$stringData= json_encode($jsonData );
echo $stringData;
// $sql = INSERT INTO MyGuests (firstname, lastname, email)
//VALUES ('John', 'Doe', 'john@example.com')";


?>

