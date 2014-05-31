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
// Often these are form values in $_POST
$menu_name = "Denis Today's Widget Trivia";
$position = (int) 140;
$visible = (int) 0;

// Escape all strings
$menu_name = mysqli_real_escape_string($connection, $menu_name);

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

// query
$ages = array("54,number,Id,Имя","71,number,Id,Имя","14,number,Id,Имя","23,number,Id,Имя","65,number,Id,Имя","314,number,Id,Имя");


echo '<br>';
echo '<br>';
echo '<br>';

$group_member = array();
foreach($ages as $attribute => $data) {

    $member_to_array = (explode(',',$data));
    $group_member[] = $member_to_array;
}

var_dump($group_member);

echo '<br>';
echo '<br>';
echo '<br>';

function position_sort($a,$group_member) {
    foreach($a as $k=>$v) {
        $b[$k] = strtolower($v[$group_member]);
    }
    arsort($b);
    foreach($b as $key=>$val) {
        $c[] = $a[$key];
    }
    return $c;
}

$group_member = position_sort($group_member, 0);
var_dump($group_member);



// 2. Drop table

    $query = "DROP TABLE arays";
    $query_result = mysqli_query($connection, $query);


// 2.2  Create table

   $create_table  = "CREATE TABLE IF NOT EXISTS `arays` (`id` int(11) NOT NULL AUTO_INCREMENT,`position_id` int(255) NOT NULL,`menu_name` varchar(30) CHARACTER SET utf8 NOT NULL,`position` varchar(30) CHARACTER SET utf8 NOT NULL,`content` text CHARACTER SET utf8 COLLATE utf8_bin,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";
   $query_result = mysqli_query($connection, $create_table);


// 2.1  Perform database query


for ($i=1; $i <= 1000; $i++) {
foreach($group_member as $value) {
    $query  = "INSERT INTO arays (";
    $query .= "  position_id, menu_name, position, content";
    $query .= ") VALUES (";
    $query .= "  '{$value[0]}', '{$value[1]}', '{$value[2]}', '{$value[3]}.{$i}'";
    $query .= ")";


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

}
}



?>



    </body>
    </html>

<?php
// 5. Close database connection
mysqli_close($connection);
?>