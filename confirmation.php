<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
<?php include 'prepared-queries.php'; ?>
<html>
<head>
	<title>Confirmation</title>
	<?php movePostToSession(); ?>
</head>
<body>
	<h1>Confirmation</h1>
	<p>
		Thanks for <s>selling your soul to us</s> completing your application!<br/>
		You'll be contacted shortly with next steps.
	</p>
	<!--We can check $_SERVER["REQUEST_METHOD"]. If it's GET, we only need to get data. If it's POST, we need to add AND get data-->
	<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		extract($_SESSION);
		//start up a transaction cuz we doing a lot!
		mysqli_begin_transaction($conn);
		
		//step 1: app info
		$sql = mysqli_prepare($conn, PreparedQuery::INSERT_APP_INFO);
		mysqli_stmt_bind_param($sql, "sssss", $finAid, $tuitionAsst, $otherPrograms, $felony, $probation);
		mysqli_stmt_execute($sql);
		mysqli_stmt_close($sql);
		$appInfoID = mysqli_insert_id($conn);
		
		//step 2: personal info
		$sql = mysqli_prepare($conn, PreparedQuery::INSERT_PERS_INFO);
		$dayMonthYear = explode("/", $dob);
		$birthday = join("-", array_reverse($dayMonthYear));
		mysqli_stmt_bind_param($sql, "sssssssssssiii", $fName, $lName, $prefName, $birthday, $phone,
			$usCitizen, $enNative, $hispLat, $addr, $city, $zip, $state, $vetStatus, $gender);
		mysqli_stmt_execute($sql);
		mysqli_stmt_close($sql);
		$persInfoID = mysqli_insert_id($conn);
		
		//step 3: race and military
		$sql = mysqli_prepare($conn, PreparedQuery::BIND_RACE);
		mysqli_stmt_bind_param($sql, "ii", $persInfoID, $raceID);
		foreach($race as $raceID) {
			mysqli_stmt_execute($sql);
		}
		mysqli_stmt_close($sql);
		
		$sql = mysqli_prepare($conn, PreparedQuery::BIND_BRANCH);
		mysqli_stmt_bind_param($sql, "ii", $persInfoID, $branchID);
		foreach($militaryBranch as $branchID) {
			mysqli_stmt_execute($sql);
		}
		mysqli_stmt_close($sql);
		
		//step 4: now put it all together!
		$sql = mysqli_prepare($conn, PreparedQuery::INSERT_APP);
		//todo: handle term, for now just use 1
		$testTerm = 3;
		mysqli_stmt_bind_param($sql, "iiiiiiii", $user, $persInfoID, $appInfoID, $college, $major, $degreeType, $testTerm, $studentType);
		mysqli_stmt_execute($sql);
		mysqli_stmt_close($sql);
		$appID = mysqli_insert_id($conn);
		
		//end the transaction, everything is good
		mysqli_commit($conn);
		echo "<p>New app</p>";
	}
	else {
		$appID = $_GET["app"];
	}
	echo "<p>Reviewing app# $appID</p>";
	?>
	<p>
		Click <a href="my-applications.php">here</a> to return to the homepage.
	</p>
</body>
</html>
<?php include 'sql-end.php'; ?>