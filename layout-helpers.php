<?php
function movePostToSession() {
	foreach($_POST as $name => $value) {
		$_SESSION[$name] = $_POST[$name];
	}
}

function makeSummaryEntry($label, $value) {
	echo "<tr><td>$label</td><td>$value</td></tr>\n";
}

function renderAppSummary($conn, $appid, $userid) {
	$sql = mysqli_prepare($conn, PreparedQuery::READ_APP);
	mysqli_stmt_bind_param($sql, "ii", $appid, $userid);
	mysqli_stmt_execute($sql);
	mysqli_stmt_bind_result($sql, $studentType, $college, $degType, $degree, $termYear, $termSeason,
		$personalInfo, $fName, $lName, $prefName, $dob, $addr, $city, $state, $zip, $phone, 
		$usCitizen, $engNative, $gender, $vetStatus, $hispLat,
		$finAid, $tuitionAsst, $otherPrograms, $felony, $probation);
	$gotResults = mysqli_stmt_fetch($sql);
	mysqli_stmt_close($sql);
	if($gotResults) {
		//do output
		//new application
		echo "<h2>New Application</h2>\n";
		echo "<table cellpadding='7'>";
		makeSummaryEntry("Which type of student are you?", $studentType);
		makeSummaryEntry("Which college are you applying to?", $college);
		makeSummaryEntry("What type of degree are you applying for?", $degType);
		makeSummaryEntry("Which term are you applying for?", $termSeason . " " . $termYear);
		echo "</table>\n";
		
		//personal info
		echo "<h2>Personal Information</h2>\n";
		echo "<table cellpadding='7'>";
		makeSummaryEntry("First name:", $fName);
		makeSummaryEntry("Last name:", $lName);
		makeSummaryEntry("Preferred name:", $prefName);
		//make date back to day/month/year
		$ymd = explode("-", $dob);
		makeSummaryEntry("Date of birth:", join("/", array_reverse($ymd)));
		makeSummaryEntry("Street address:", $addr);
		makeSummaryEntry("City:", $city);
		makeSummaryEntry("State", $state);
		makeSummaryEntry("Zip code:", $zip);
		makeSummaryEntry("Phone number:", $phone);
		makeSummaryEntry("Are you a US Citizen?", $usCitizen);
		makeSummaryEntry("Is English your native language?", $engNative);
		makeSummaryEntry("What is your gender?", $gender);
		makeSummaryEntry("What is your veteran status?", $vetStatus);
		//do the query for military branches
		$sql = mysqli_prepare($conn, PreparedQuery::GET_MILITARY_BRANCHES);
		mysqli_stmt_bind_param($sql, "i", $personalInfo);
		mysqli_stmt_execute($sql);
		mysqli_stmt_bind_result($sql, $branchName);
		$branches = array();
		while(mysqli_stmt_fetch($sql)) {
			array_push($branches, $branchName);
		}
		mysqli_stmt_close($sql);
		makeSummaryEntry("Which military branch(es) have you served for?", join(", ", array_reverse($branches)));
		makeSummaryEntry("Are you Hispanic/Latino origin?", $hispLat);
		//do the query for race/ethnicity
		$sql = mysqli_prepare($conn, PreparedQuery::GET_RACES);
		mysqli_stmt_bind_param($sql, "i", $personalInfo);
		mysqli_stmt_execute($sql);
		mysqli_stmt_bind_result($sql, $race);
		$races = array();
		while(mysqli_stmt_fetch($sql)) {
			array_push($races, $race);
		}
		mysqli_stmt_close($sql);
		makeSummaryEntry("Which race/ethnicity do you identify as?", join(", ", array_reverse($races))); //query for races
		echo "</table>\n";
		
		//application info
		echo "<h2>Application Info</h2>\n";
		echo "<table cellpadding='7'>";
		makeSummaryEntry("Will you be applying for financial aid?", $finAid);
		makeSummaryEntry("Do you have employer tuition assistance?", $tuitionAsst);
		makeSummaryEntry("Are you applying to other programs?", $otherPrograms);
		makeSummaryEntry("Have you ever been convicted of a felony or a gross misdemeanor?", $felony);
		makeSummaryEntry("Have you ever been placed on probation, suspended from, dismissed from or <br/>" .
			"otherwise sanctioned by (for any period of time) any higher education institution", $probation);
		echo "</table>\n";
	}
	else {
		//no results; either app doesn't exist or someone is trying to hax
		echo '<p style="color:red">This application doesn\'t belong to you!</p>';
	}
}

function createApplicationTable($conn, $userid) {
	if(!$userid) {
		echo "You're not logged in!";
		return null;
	}
	$sql = mysqli_prepare($conn, PreparedQuery::GET_APPS);
	if(!sql) {
		echo mysqli_error($conn);
	}
	if(mysqli_stmt_bind_param($sql, "i", $userid)) {
		echo mysqli_stmt_error($sql);
	}
	if(mysqli_stmt_execute($sql)) {
		echo mysqli_error($conn);
	}
	mysqli_stmt_bind_result($sql, $appId, $colName, $degName, $degType, $termYear, $season);
	echo "<table border='1' cellpadding='5'><tr><th>App ID</th><th>College</th><th>Degree</th><th>Major</th><th>Term</th></tr>\n";
	$count = 0;
	while (mysqli_stmt_fetch($sql)) {
		//todo: more queries to get text data for enum types
		echo <<<TABLE_ENTRY
			<tr>
				<td><a href='confirmation.php?app=$appId'>$appId</a></td>
				<td>$colName</td>
				<td>$degType</td>
				<td>$degName</td>
				<td>$season $termYear</td>
			</tr>
TABLE_ENTRY;
		$count = $count + 1;
	}
	echo "</table>\n";
	mysqli_stmt_close($sql);
	if($count == 0) {
		echo "It's empty in here :(";
	}
}

function renderYearSelector($elementId) {
	$curYear = date("Y");
	for($i = 0; $i < 3; $i++) {
		$value = $curYear + $i;
		if($i == 0) {
			echo "<input type='radio' name='$elementId' value='$value' checked>$value</input><br/>";
		}
		else {
			echo "<input type='radio' name='$elementId' value='$value'>$value</input><br/>";
		}
	}
	
	echo "</select>\n";
}

function renderDropdown($conn, $elementId, $tableName, $sortCol=null) {
	echo "<select id='$elementId' name='$elementId'>\n";
	
	$queryStr = "SELECT * FROM $tableName";
	if(isset($sortCol)) {
		$queryStr .= " ORDER BY $sortCol";
	}
	$result = mysqli_query($conn, $queryStr);
	while($row = mysqli_fetch_row($result)) {
		$id = $row[0];
		$value = $row[1];
		echo "<option value='$id'>$value</option>";
	}
	echo "</select>\n";
	mysqli_free_result($result);
}

function renderSelectOne($conn, $elementId, $tableName, $sortCol=null) {
	$queryStr = "SELECT * FROM $tableName";
	if(isset($sortCol)) {
		$queryStr .= " ORDER BY $sortCol";
	}
	$result = mysqli_query($conn, $queryStr);
	$first = true;
	while($row = mysqli_fetch_row($result)) {
		$id = $row[0];
		$value = $row[1];
		if ($first) {
			echo "<input type='radio' name='$elementId' value='$id' checked>$value</input><br/>";
			$first = false;
		}
		else {
			echo "<input type='radio' name='$elementId' value='$id'>$value</input><br/>";
		}
	}
	mysqli_free_result($result);
}

function renderSelectMany($conn, $elementId, $tableName, $sortCol=null) {
	$queryStr = "SELECT * FROM $tableName";
	if(isset($sortCol)) {
		$queryStr .= " ORDER BY $sortCol";
	}
	$result = mysqli_query($conn, $queryStr);
	while($row = mysqli_fetch_row($result)) {
		$id = $row[0];
		$value = $row[1];
		echo "<input type='checkbox' name='$elementId" . "[]' value='$id'>$value</input><br/>";
	}
	mysqli_free_result($result);
}

function renderYesNo($elementId) {
	echo "<input type='radio' name='$elementId' value='Yes'>Yes</input><br/>";
	echo "<input type='radio' name='$elementId' value='No' checked>No</input><br/>";
}
?>