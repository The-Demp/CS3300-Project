<html>
<head>
	<title>Results</title>
</head>
<body>
<?php
foreach( $_POST as $name => $value) {
	echo $name . ": " . $value . "<br/>\n";
}
?>
</body>
</html>