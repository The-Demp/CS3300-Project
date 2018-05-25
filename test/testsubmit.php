<html>
<head>
	<title>Results</title>
</head>
<body>
<?php
foreach( $_POST as $name => $value) {
	if(is_array($value)) {
		echo $name . ": [";
		foreach($value as $arrElement) {
			echo "$arrElement" . ", ";
		}
		echo "]</br>";
	}
	else {
		echo $name . ": " . $value . "<br/>\n";
	}
}
?>
</body>
</html>