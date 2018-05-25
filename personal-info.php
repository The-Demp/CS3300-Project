<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<html>
<head>
	<title>Personal Information</title>
</head>
<body>
	<h1>Personal Information</h1>
	<p style="color:red">A * next to a field indicates it is required.</p>
	<form action="application-info.php" method="post">
		<p>
			First Name (*):<br/>
			<input type="text" name="fName"/>
		</p>
		<p>
			Last Name (*):<br/>
			<input type="text" name="lName"/>
		</p>
		<p>
			Preferred Name:<br/>
			<input type="text" name="prefName"/>
		</p>
		<p>
			Date of Birth (DD/MM/YYYY) (*):<br/>
			<input type="text" name="dob"/>
		</p>
		<p>
			Street Address (*):<br/>
			<input type="text" name="addr"/>
		</p>
		<p>
			City (*):<br/>
			<input type="text" name="city"/>
		</p>
		<p>
			<label for="state">State (*):</label>
			<?php renderDropdown($conn, "state", "STATE", "STATE_CODE"); ?>
		</p>
		<p>
			ZIP code (*):<br/>
			<input type="text" name="zip"/>
		</p>
		<p>
			Phone Number (*):<br/>
			<input type="text" name="phone"/>
		</p>
		<p>
			Are you a US Citizen (*)?<br/>
			<?php renderYesNo("usCitizen"); ?>
		</p>
		<p>
			Is English your native language (*)?<br/>
			<?php renderYesNo("enNative"); ?>
		</p>
		<p>
			What is your gender (*)?<br/>
			<?php renderSelectOne($conn, "gender", "GENDER"); ?>
		</p>
		<p>
			What is your veteran status (*)?<br/>
			<?php renderSelectOne($conn, "vetStatus", "VET_STATUS"); ?>
		</p>
		<p>
			If applicable, which military branch(es) have you served for (select all that apply)?<br/>
			<?php renderSelectMany($conn, "militaryBranch", "MILITARY_BRANCH"); ?>
		</p>
		<p>
			Are you Hispanic/Latino origin (*)?<br/>
			<?php renderYesNo("hispLat"); ?>
		</p>
		<p>
			Which race/ethnicity do you identify as (select all that apply)?<br/>
			<?php renderSelectMany($conn, "race", "RACE"); ?>
		</p>
		<button type="button" onclick="window.location='new-application.php';">Cancel</button>
		<input type="submit" value="Next ->"/>
	</form>
</body>
</html>
<?php include 'sql-end.php'; ?>