<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<?php include 'prepared-queries.php'; ?>
<html>
<head>
	<title>Registration Complete</title>
</head>
<body>
	<h1>
	<?php 
	if($_POST["pass"] == $_POST["confirmPass"]) {
		$sql = mysqli_prepare($conn, PreparedQuery::NEW_USER);
		if(!sql) {
			echo mysqli_error($conn);
		}
		if(mysqli_stmt_bind_param($sql, "ss", $_POST["email"], hash("sha256", $_POST["pass"]))) {
			echo mysqli_stmt_error($sql);
		}
		if(mysqli_stmt_execute($sql)) {
			echo mysqli_error($conn);
		}
		echo "Registration Successful!";
	}
	else {
		echo "Registration Failed!";
	}
	?>
	</h1>
	<p>
		Click <a href="login.php">here</a> to return to login page.
	</p>
</body>
</html>
<?php include 'sql-end.php'; ?>