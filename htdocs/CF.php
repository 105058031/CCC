<?php
if (strlen($_ENV['VCAP_APPLICATION'])>0)
{
	echo true;
}else
{
	echo 0;
}

?>

