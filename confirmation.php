<?php include 'sql-begin.php'; ?>
<?php include 'layout-helpers.php'; ?>
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
	<!--We can check $_SERVER["REQUEST_METHOD"]. If it's GET, we only need to get data. If it's POST, we need to add AND get data
	<!--This is just debug info and will be formatted better when actually dealing with MySQL-->
	<!--
	<p>
		<?php
		foreach($_SESSION as $name => $value) {
			if(is_array($value)) {
				echo $name . ": [";
				foreach($value as $arrElement) {
					echo "$arrElement" . ", ";
				}
				echo "]</br>";
			}
			else {
				echo $name . ": " . $value . "<br/>\n";
			}
		}
		?>
	</p>-->
	<p>
		Click <a href="new-application.php">here</a> to return to the homepage.
	</p>
</body>
</html>
<?php include 'sql-end.php'; ?>