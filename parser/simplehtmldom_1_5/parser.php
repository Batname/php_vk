<?php
include('simple_html_dom.php'); // библиотека для парсинга

$html = file_get_html('http://drpepper.net.ua/'); //работает и с https://

foreach($html->find('img') as $element) { //выборка всех тегов img на странице
    echo $element->src . '<br>'; // построчный вывод содержания всех найденных атрибутов src
}

echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';

$i = 1;
foreach( $ret = $html->find('a') as $element1) {
    echo $i.')' . $element1->href . '<br>';
    $i++;
};

