<?php
include('simple_html_dom.php'); // библиотека для парсинга

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

    bodytxt1
    <script>var y = a<b;</script>
    <style>body {display:none}</style>
    <p>I-m here</p>
    bodytxt2

    <?php

    $html = 'http://localhost/tutorial/php_vk/parser/simplehtmldom_1_5/habrtest.php';

    $tree =  str_get_html($html);

    echo $tree->find("body", 0)->plaintext;

    ?>

</div>
</body>
</html>