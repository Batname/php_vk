<?php
require_once('../includes/database.php');
require_once("../includes/user.php");
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
<div class="container">
    <?php


    $user = User::find_by_id(1);
    echo $user->username . "<br>";
    echo $user->userimage. "<br>";




    echo "<hr />";

    $users = User::find_all();
    foreach ($users as $user) {
        echo "User: ". $user->id ."<br />";
        echo "User: ". $user->userimage ."<br />";
    }




    ?>
</div>

</body>
</html>

