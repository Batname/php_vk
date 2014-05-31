<?php
header("Content-type: text/html; charset=utf-8");
  // 1. Create a database connection
  $dbhost = "localhost";
  $dbuser = "widget_cms";
  $dbpass = "secretpassword";
  $dbname = "widget_corp";
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  mysqli_set_charset('utf8', $connection);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }

/* change character set to utf8 */
if (!$connection->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $connection->error);
} else {
    printf("Current character set: %s\n", $connection->character_set_name());
}

?>
<?php
	// Often these are form values in $_POST
	$menu_name = "привет";
	$position = (int) 4;
	$visible = (int) 1;
	
	// Escape all strings
	$menu_name = mysqli_real_escape_string($connection, $menu_name);
	
	// 2. Perform database query
	$query  = "INSERT INTO subjects (";
	$query .= "  menu_name, position, visible";
	$query .= ") VALUES (";
	$query .= "  '{$menu_name}', {$position}, {$visible}";
	$query .= ")";
    mysql_query("SET NAMES 'utf8'");
	$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		// redirect_to("somepage.php");
		echo "Success!";
	} else {
		// Failure
		// $message = "Subject creation failed";
		die("Database query failed. " . mysqli_error($connection));
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Databases</title>
	</head>
	<body>
		
	</body>
</html>

<?php
  // 5. Close database connection
  mysqli_close($connection);
?>