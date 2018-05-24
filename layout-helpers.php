<?php
function renderDropdown($conn, $elementId, $tableName) {
	echo "<select id='$elementId'>\n";
	
	$queryStr = "SELECT * FROM $tableName;";
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