<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>New Application</title>
</head>
<body>
	<h1>New Application</h1>
	<p style="color:red">A * next to a field indicates it is required.</p>
	<form action="personal-info.php" method="post">
		<p>
			What type of student are you (*)?<br/>
			<?php renderSelectOne($conn, "studentType", "STUDENT_TYPE"); ?>
		</p>
		<p>
			<label for="college">Which college are you applying to (*)?</label>
			<?php renderDropdown($conn, "college", "COLLEGE"); ?>
		</p>
		<p>
			What type of degree are you applying for (*)?<br/>
			<?php renderSelectOne($conn, "degreeType", "DEGREE_TYPE"); ?>
		</p>
		<p>
			<label for="major">Which major are you applying to (*)?</label>
			<?php renderDropdown($conn, "major", "DEGREE"); ?>
		</p>
		<p>
			Which term are you applying for (*)?</br>
			<label for="season">Season (*):</label>
			<?php renderDropdown($conn, "season", "SEASON"); ?><br/>
			Year (*):</br>
			<?php renderYearSelector("year"); ?>
		</p>
		<button type="button" onclick="window.location='new-application.php';">Cancel</button>
		<input type="submit" value="Next ->"/>
	</form>
</body>
</html>
<?php include 'sql-end.php'; ?>