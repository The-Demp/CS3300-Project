<?php
function movePostToSession() {
	foreach($_POST as $name => $value) {
		$_SESSION[$name] = $_POST[$name];
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
	mysqli_stmt_bind_result($sql, $appId, $colId, $degId, $degType,
		$applicantId, $termId, $studentType, $persInfo, $appInfo);
	echo "<table border='1'><tr><th>App ID</th><th>College</th><th>Degree</th><th>Major</th><th>Term</th></tr>\n";
	$count = 0;
	while (mysqli_stmt_fetch($sql)) {
		//todo: more queries to get text data for enum types
		echo "<tr><td><a href='confirmation.php?appid=$appId>$appId</a></td><td>$colId</td><td>$degType</td><td>$degId</td><td>$termId</td></tr>\n";
		$count = $count + 1;
	}
	echo "</table>";
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