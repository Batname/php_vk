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


    $username = 'DrPepperUkraine'; // Имя в twitter
    $maxpost = '10'; // к-во постов
    $html = file_get_html('https://twitter.com/' . $username);
    $i = '0';
    foreach ($html->find('div.ProfileTweet') as $article) { //выбираем все li сообщений
        $item['text'] = $article->find('p.js-tweet-text', 0)->innertext; // парсим текст сообщения в html формате
        $item['time'] = $article->find('span.js-short-timestamp ', 0)->innertext; // парсим время в html формате
        $articles[] = $item; // пишем в массив
        $i++;
        if ($i == $maxpost) break; // прерывание цикла
    }



    for ($j = 0; $j < $maxpost; $j++) {
        echo '<div class="twitter_message">';
        echo '<p class="twitter_text">' . $articles[$j]['text'] . '</p>';
        echo '<p class="twitter_time">' . $articles[$j]['time'] . '</p>';
        echo '</div>';
    }

    ?>

</div>
</body>
</html>