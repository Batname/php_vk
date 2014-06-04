<?php
require_once('database.php');
require_once("user.php");
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
    //$user = User::find_by_id(1);
    //echo $user->username . "<br>";
    //echo $user->userimage. "<br>";
    ?>
<br>
    <h1>Топ 10 перепостов</h1>
    <table class="table table-striped">
    <?php
    $file = '/var/www/tutorial/php_vk/vk_app/includes/repost.html';
    $handle = fopen($file, 'w');

        fwrite($handle, ''); // returns number of bytes or false
        $users = User::find_top_10();
        foreach ($users as $user) {
            $content = "<tr>";
            $content .=  "<td>" . "Репостов: ". $user->reposts."<td />";
            $content .=  "<td>" . "Имя: ". $user->username ."<td />";
            $content .=  '<td>' .'<img src='.$user->userimage.' alt="Title bg"></img>' . '<td />';
            $content .=  '<td>' . '<a target="_blank" href="http://vk.com/id'.$user->userlink.'">id'.$user->userlink.'</a><td />';
            $content .=  "<td>" . "Id новости: ". $user->user_news_id ."<td />";
            $content .=  "</tr>";
            echo $content;
            fwrite($handle, $content);
        }

        fclose($handle);


    ?>
    </table>
</div>



</body>
</html>

