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
    <?php


    $dp_array = array('http://drpepper.net.ua/canada-dry-ginger-ale-12-banochek.html','http://drpepper.net.ua/cheerwine-12-banochek.html','http://drpepper.net.ua/dr-pepper-cherry.html','http://drpepper.net.ua/');
    var_dump($dp_array);

    foreach ($dp_array as $dp) {
        $html = file_get_html("{$dp}");
        // find image
        $es = $html->find('a.cloud-zoom img[src]');
        if (isset($es[0])){
            echo $es[0]->src . "<br>";
        } else{
            echo 'нет в разметке';
        }

    }


    ?>

</div>
</body>
</html>