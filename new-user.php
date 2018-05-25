<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>Create an Account</title>
</head>
<body>
	<h1>Create an Account</h1>
	<p style="color:red">A * next to a field indicates it is required.</p>
	<form action="registration-finished.php" method="post">
		<p>
			Email (*):<br/>
			<input type="text" name="email"/>
		</p>
		<p>
			Password (*):<br/>
			<input type="password" name="pass"/>
		</p>
		<p>
			Confirm password (*):<br/>
			<input type="password" name="confirmPass"/>
		</p>
		<button type="button" onclick="window.location='new-application.php';">Cancel</button>
		<input type="submit" value="Register"/>
	</form>
</body>
</html>
<?php include 'sql-end.php'; ?>