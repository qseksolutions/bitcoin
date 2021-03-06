<?php 
include_once 'config/db.php';
include_once "library/ccxt.php";
// error_reporting(E_ALL);

// date_default_timezone_set ('UTC');

$sql_row_update_bithumb	= [];

$allexpair = $DB->query("SELECT id,pair,exchange_name FROM pairnew WHERE exchange_name='bithumb'");

$exchange = new \ccxt\bithumb(); // default id

foreach ($allexpair as $expair) {

	$fetchticker = $exchange->fetchTicker($expair['pair']);

	$sql = " UPDATE pairnew ";
	$sql .= " SET high=\"" . (float)$fetchticker["high"] . "\" ";
	$sql .= ", low = \"". (float)$fetchticker['low'] ."\" ";
	$sql .= ", open = \"". (float)$fetchticker['open'] ."\" ";
	$sql .= ", close = \"". (float)$fetchticker['close'] ."\" ";
	$sql .= ", basevolume = \"". (int)$fetchticker['baseVolume'] ."\" ";
	$sql .= ", quotevolume = \"". (float)$fetchticker['quoteVolume'] ."\" ";
	$sql .= ", update_date = \"". date('Y-m-d H:i:s') ."\" ";
	$sql .= " WHERE ";
	$sql .= " id=" . $expair["id"] . " ;";		
	if($DB->query($sql) === TRUE) {
		$sql_row_update_bithumb[] = $expair["pair"];
	} else {
		$sql_row_update_bithumb[] = "Error: " . $sql . "<br>" . $DB->error."<br>";
	}				
}

echo "<pre>"; print_r('========= BITHUMB ROW UPDATE =========='); echo "</pre>"; 
echo "<pre>"; print_r($sql_row_update_bithumb); echo "</pre>"; 

$DB->close();
?>