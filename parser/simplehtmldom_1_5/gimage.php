<?php
include('simple_html_dom.php'); // библиотека для парсинга
$html = file_get_html('https://www.google.com.ua/search?safe=off&hl=en&site=imghp&tbm=isch&source=hp&biw=1855&bih=983&q=%D0%BA%D0%B0%D1%80%D1%82%D0%B0+%D1%80%D0%BE%D1%81%D1%81%D0%B8%D0%B8&oq=%D0%BA%D0%B0%D1%80&gs_l=img.1.4.0l10.4246.5116.0.8587.3.3.0.0.0.0.95.214.3.3.0....0...1ac.1.45.img..0.3.211.NFWLYaCXZPM#facrc=_&imgdii=_&imgrc=4FAkMLCJgOT1DM%253A%3BjimiXuadwP8LFM%3Bhttp%253A%252F%252Frossiikarta.ru%252Fkarta-rossii-s-gorodami.jpg%3Bhttp%253A%252F%252Frossiikarta.ru%252Fkarta-rossii-gorodami.html%3B2317%3B1294'); //работает и с https://

foreach($html->find('img') as $element) { //выборка всех тегов img на странице
    echo $element->src . '<br>'; // построчный вывод содержания всех найденных атрибутов src
}