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
    ?>
<br>
    <h1>Топ 10 перепостов</h1>
    <table class="table table-striped">
    <?php
    $users = User::find_top_10();
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . "Репостов: ". $user->reposts."<td />";
        echo "<td>" . "Имя: ". $user->username ."<td />";
        echo '<td>' .'<img src='.$user->userimage.' alt="Title bg"></img>' . '<td />';
        echo '<td>' . '<a target="_blank" href="http://vk.com/id'.$user->userlink.'">id'.$user->userlink.'</a><td />';
        echo "<td>" . "Id новости: ". $user->user_news_id ."<td />";
        echo "</tr>";
    }
    ?>
    </table>
</div>

</body>
</html>

