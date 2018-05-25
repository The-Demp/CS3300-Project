<?php
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