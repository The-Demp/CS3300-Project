<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>Test things</title>
</head>
<body>
	<label for='states'>Pick a state:</label>
	<?php renderDropdown($conn, "states", "STATE"); ?>
</body>
</html>
<?php include 'sql-end.php'; ?>