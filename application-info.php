<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>Application Information</title>
	<?php movePostToSession(); ?>
</head>
<body>
	<h1>Application Information</h1>
	<p style="color:red">A * next to a field indicates it is required.</p>
	<form action="confirmation.php" method="post">
		<p>
			Will you be applying for financial aid (*)?<br/>
			<?php renderYesNo("finAid"); ?>
		</p>
		<p>
			Do you have employer tuition assistance? (*)?<br/>
			<?php renderYesNo("tuitionAsst"); ?>
		</p>
		<p>
			Are you applying to other programs (*)?<br/>
			<?php renderYesNo("otherPrograms"); ?>
		</p>
		<p>
			Have you ever been convicted of a felony or a gross misdemeanor (*)?<br/>
			<?php renderYesNo("felony"); ?>
			A conviction will not necessarily bar admission but will require additional documentation prior to a decision.<br/> 
			You will be contacted shortly via email with instructions on reporting the nature of your conviction.
		</p>
		<p>
			Have you ever been placed on probation, suspended from, dismissed from or <br/>
			otherwise sanctioned by (for any period of time) any higher education institution (*)?<br/>
			<?php renderYesNo("probation"); ?>
		</p>
		<button type="button" onclick="window.location='new-application.php';">Cancel</button>
		<input type="submit" value="Next ->"/>
	</form>
</body>
</html>
<?php include 'sql-end.php'; ?>