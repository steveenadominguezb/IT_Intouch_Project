<?php
$now = strtotime("now");
$now = date("Y-m-d", $now);
echo $now, "\n";
echo date("Y-m-d",strtotime("10 September 2000")), "\n";
echo date("Y-m-d",strtotime("+1 day")), "\n";
echo date("Y-m-d",strtotime("+1 week")), "\n";
echo date("Y-m-d",strtotime("+1 week 2 days 4 hours 2 seconds")), "\n";
echo date("Y-m-d",strtotime("next Thursday")), "\n";
echo date("Y-m-d",strtotime("last Monday")), "\n";
echo date("Y-m-d",strtotime("last Sunday")), "\n";
?>