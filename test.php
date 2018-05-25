<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>Test things</title>
</head>
<body>
	<form action="testsubmit.php" method="post">
		<label for='states'>Pick a state:</label>
		<?php renderDropdown($conn, "states", "STATE", "STATE_CODE"); ?>
		<p>
			Yes or no #1?<br/>
			<?php renderYesNo("Group1"); ?>
		</p>
		<p>
			Yes or no #2<br/>
			<?php renderYesNo("Group2"); ?>
		</p>
		<input type="submit" value="Submit"/>
	</form>
</body>
</html>
<?php include 'sql-end.php'; ?>