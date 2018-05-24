<?php
function renderDropdown($conn, $elementId, $tableName, $sortCol=null) {
	echo "<select id='$elementId'>\n";
	
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
?>