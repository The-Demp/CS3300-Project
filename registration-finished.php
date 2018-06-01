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
		mysqli_stmt_bind_param($sql, "ss", $_POST["email"], hash("sha256", $_POST["pass"]));
		if(!mysqli_stmt_execute($sql)) {
			//the feasible error here is bad username
			//echo mysqli_error($conn);
			echo "A user with that name already exists!";
		}
		else {
			echo "Registration Successful!";
		}
		mysqli_stmt_close($sql);
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