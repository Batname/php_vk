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



    $html = file_get_html('http://drpepper.net.ua/canada-dry-ginger-ale-12-banochek.html');
    $i = '0';

    foreach ($html->find('div.product-name') as $name) {
        $item['text'] = $name->find('h1', 0)->innertext;
        $items[] = $item;
    };

    //var_dump($items);


    foreach ($html->find('li.item') as $name) {
        $tem['text'] = $name->find('a', 0)->innertext;
        $tems[] = $tem;
    };

    //var_dump($tems);

    // find image
    $es = $html->find('a.cloud-zoom img[src]');
    echo $es[0]->src;

    //var_dump($es);





    ?>

</div>
</body>
</html>