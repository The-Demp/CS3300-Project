<?php 

class PreparedQuery {
	const NEW_USER = "INSERT INTO APPLICANT(EMAIL, PASSWORD_HASH) VALUES(?, ?);";
	const VERIFY_USER = "SELECT APPLICANT_ID, EMAIL FROM APPLICANT WHERE EMAIL=? AND PASSWORD_HASH=?;";
	const GET_APPS = <<<GETAPPS
		SELECT A.APP_ID, C.COL_NAME, D.DEG_NAME, DT.DEG_DESC, T.TERM_YEAR, S.SEASON_DESC
		FROM APPLICATION A
		NATURAL JOIN COLLEGE C
		NATURAL JOIN DEGREE D
		NATURAL JOIN DEGREE_TYPE DT
		NATURAL JOIN TERM T
		NATURAL JOIN SEASON S
		WHERE APPLICANT_ID = ?
		ORDER BY APP_ID;
GETAPPS;
	
	//A big gross join that gets everything you could ever hope to know about the APPLICATION from the table
	//Presently, * is a placeholder. We actually should filter to only the relevant data, i.e. no PKs are needed here
	//We actually need PERS_INFO_ID to be able to get military branches, races.
	const READ_APP = <<<BIG_ICKY_JOIN
		SELECT ST.STU_TYPE_DESC, C.COL_NAME, DT.DEG_DESC, D.DEG_NAME, T.TERM_ID,
                PI.PERS_INFO_ID, PI.FIRST_NAME, PI.LAST_NAME, PI.PREF_FIRST_NAME,
		PI.BIRTH_DATE, PI.ADDRESS, PI.CITY, S.STATE_CODE, PI.ZIPCODE, PI.PHONE,
		PI.US_CITIZEN, PI.ENG_NATIVE, G.GENDER_DESC, VS.VET_TYPE_DESC, 
		PI.HISP_LAT, AI.FIN_AID, AI.EMP_TUITION, AI.OTHER_PROGRAMS, AI.FELONY,
		AI.ACADEMIC_PROBATION
                FROM APPLICATION A
		NATURAL JOIN DEGREE D
		NATURAL JOIN DEGREE_TYPE DT
		NATURAL JOIN COLLEGE C
		NATURAL JOIN TERM T
		NATURAL JOIN STUDENT_TYPE ST
		NATURAL JOIN APP_INFO AI
		NATURAL JOIN PERSONAL_INFO PI
		NATURAL JOIN STATE S
		NATURAL JOIN GENDER G
		NATURAL JOIN VET_STATUS VS
		WHERE APP_ID = ? AND APPLICANT_ID = ?;
BIG_ICKY_JOIN;
	//also need queries for military branches, races.
	
	//This is heredoc syntax; it allows strings over multiple lines.
	//the identifier NEEDS to be the first thing on the last line or THERE WILL BE ERRORS!
	//These are designed to be queried in this order.
	const INSERT_APP_INFO = <<<APPINF
		INSERT INTO APP_INFO(FIN_AID, EMP_TUITION, OTHER_PROGRAMS, FELONY, ACADEMIC_PROBATION)
		VALUES(?, ?, ?, ?, ?);
APPINF;
	//Call mysqli_insert_id($conn) to get APP_INFO_ID for the application
	const INSERT_PERS_INFO = <<<PERSINF
		INSERT INTO PERSONAL_INFO(FIRST_NAME, LAST_NAME, PREF_FIRST_NAME, BIRTH_DATE, PHONE,
		US_CITIZEN, ENG_NATIVE, HISP_LAT, ADDRESS, CITY, ZIPCODE, STATE_ID, VET_TYPE_ID,
		GENDER_ID)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
PERSINF;
	//Call mysqli_insert_id($conn) to get PERS_INFO_ID for children and for the application
	const BIND_RACE = "INSERT INTO APP_RACE(PERS_INFO_ID, RACE_ID) VALUES(?, ?);";
	const BIND_BRANCH = "INSERT INTO APP_MILITARY_BRANCH(PERS_INFO_ID, BRANCH_ID) VALUES(?, ?);";
	const GET_TERM_ID = "SELECT TERM_ID FROM TERM WHERE TERM_YEAR = ? AND SEASON_ID = ?;";
	//We have everything we need here. This is the point where we can make the real APPLICATION
	const INSERT_APP = <<<APP
		INSERT INTO APPLICATION(APPLICANT_ID, PERS_INFO_ID, APP_INFO_ID, COL_ID, DEG_ID, DEG_TYPE_ID,
		TERM_ID, STU_TYPE_ID)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?);
APP;
}

?>