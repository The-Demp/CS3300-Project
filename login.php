<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<?php include 'prepared-queries.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql = mysqli_prepare($conn, PreparedQuery::VERIFY_USER);
	if(!sql) {
		echo mysqli_error($conn);
	}
	if(mysqli_stmt_bind_param($sql, "ss", $_POST["email"], hash("sha256", $_POST["pass"]))) {
		echo mysqli_stmt_error($sql);
	}
	if(mysqli_stmt_execute($sql)) {
		echo mysqli_error($conn);
	}
	mysqli_stmt_bind_result($sql, $userid, $userEmail);
	$count = 0;
	while (mysqli_stmt_fetch($sql)) {
		$count = $count + 1;
	}
	mysqli_stmt_close($sql);
	if($count > 0) {
		$_SESSION['user'] = $userid;
		$_SESSION['email'] = $userEmail;
		//this is critical. The header must be the first and only output, 
		//so this goes BEFORE the <html> tag and then we call exit() to stop further output.
		header("location:my-applications.php");
		//since we're ending this prematurely, we need to close off the sql!
		include 'sql-end.php';
		exit();
	}
}
?>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo "<p>Login failed!</p>";
	}
	?>
	<form action="login.php" method="post">
		<p>
			Email (*):<br/>
			<input type="text" name="email"/>
		</p>
		<p>
			Password (*):<br/>
			<input type="password" name="pass"/>
		</p>
		<input type="submit" value="Login"/>
	</form>
	<p>New here? <a href="new-user.php">Create an account</a>!</p>
</body>
</html>
<?php include 'sql-end.php'; ?>