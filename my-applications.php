<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<?php include 'prepared-queries.php'; ?>
<html>
<head>
	<title>My Applications</title>
</head>
<body>
	<h1>
	<?php
		if(array_key_exists("user", $_SESSION)) {
			echo "Welcome, " . $_SESSION['email'];
		}
		else {
			echo "This is a little strange because you're not logged in!";
		}
		?>
	</h1>
	<p>
		Click an application below to review it, or <a href="new-application.php">create a new one</a>.
	</p>
	<?php createApplicationTable($conn, $_SESSION['user']); ?>
</body>
</html>
<?php include 'sql-end.php'; ?>