<?php
header("Content-type: text/html; charset=utf-8");
// 1. Create a database connection
$dbhost = "localhost";
$dbuser = "widget_cms";
$dbpass = "secretpassword";
$dbname = "widget_corp";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
mysqli_set_charset($connection, 'utf8');
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


?>

    <html>
    <head>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <title>Repost</title>
        <meta charset="UTF-8">
    </head>
    <body>

<?php

$result = mysqli_query($connection,"SELECT * FROM arays ORDER BY `arays`.`position_id` DESC  LIMIT 0 , 30");

echo "<table border='1'>
<tr>
<th>position_id</th>
<th>menu_name</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['position_id'] . "</td>";
    echo "<td>" . $row['menu_name'] . "</td>";
    echo "</tr>";
}

echo "</table>";



?>



    </body>
    </html>

<?php
// 5. Close database connection
mysqli_close($connection);
?>