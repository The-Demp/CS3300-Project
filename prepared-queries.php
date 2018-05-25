<?php 

class PreparedQuery {
	const NEW_USER = "INSERT INTO APPLICANT(EMAIL, PASSWORD_HASH)
		VALUES(?, ?)";
?>