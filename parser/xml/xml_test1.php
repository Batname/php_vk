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
require_once("php_xml.php");
require_once('../simplehtmldom_1_5/simple_html_dom.php');
$xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<channel>
<url><loc>http://drpepper.net.ua/produkti.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/dr-pepper-ukraine.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/suvenirs.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/produkti/cofe.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/produkti/diserti.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/dr-pepper-ukraine/dr-pepper-cherry-52.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/dr-pepper-ukraine/dr-pepper-original.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.5</priority></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-12.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/d2/dr-pepper-original-12-banochek-a6.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/52/dr-pepper-original-12-banochek-2d.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/30/dr-pepper-original-12-banochek-f2.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/a5/dr-pepper-original-12-banochek-f0.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/f8/dr-pepper-original-12-banochek-fe.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/75/dr-pepper-original-12-banochek-28.png</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-cherry.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/f4/dr-pepper-cherry-12-banochek-86.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/29/dr-pepper-cherry-12-banochek-43.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/a9/dr-pepper-cherry-12-banochek-2a.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/28/dr-pepper-cherry-12-banochek-35.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/d1/dr-pepper-cherry-12-banochek-4b.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/7b/dr-pepper-cherry-12-banochek-45.png</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-cherry-24.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/5f/dr-pepper-cherry-24-banochki-b2.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/4a/dr-pepper-cherry-24-banochki-a1.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-cherry-36.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/63/dr-pepper-cherry-36-banochek-e7.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-75.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/b0/dr-pepper-original-24-banochki-4c.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/bd/dr-pepper-original-24-banochki-bb.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-36.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/b2/dr-pepper-original-36-banochek-1f.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-optom.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/e2/dr-pepper-original-optom-ot-20-ti-jaschikov-po-12-banochek-2f.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/bc/dr-pepper-original-optom-ot-20-ti-jaschikov-po-12-banochek-07.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-optom-54.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/b9/dr-pepper-cherry-optom-ot-20-ti-jaschikov-po-12-banochek-86.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/test-001.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority></url>
<url><loc>http://drpepper.net.ua/dr-pepper-original-12-skidka.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/ed/dr-pepper-original-12-banochek-nefirmennaja-upakovka-difekty-banochek-70.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/c9/dr-pepper-original-12-banochek-nefirmennaja-upakovka-difekty-banochek-e2.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/1f/dr-pepper-original-12-banochek-nefirmennaja-upakovka-difekty-banochek-80.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/58/dr-pepper-original-12-banochek-nefirmennaja-upakovka-difekty-banochek-dd.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/dr-pepper-sherry-12-skidka.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/ca/dr-pepper-cherry-12-banochek-nefirmennaja-upakovka-difekty-banochek-0e.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/59/dr-pepper-cherry-12-banochek-nefirmennaja-upakovka-difekty-banochek-62.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/24/dr-pepper-cherry-12-banochek-nefirmennaja-upakovka-difekty-banochek-0d.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/1d/dr-pepper-cherry-12-banochek-nefirmennaja-upakovka-difekty-banochek-21.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/5d/dr-pepper-cherry-12-banochek-nefirmennaja-upakovka-difekty-banochek-7d.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/canada-dry-ginger-ale-12-banochek.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/ee/canada-dry-ginger-ale-12-banochek-37.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/0c/canada-dry-ginger-ale-12-banochek-0f.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/3a/canada-dry-ginger-ale-12-banochek-1d.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/23/canada-dry-ginger-ale-12-banochek-34.png</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/cheerwine-12-banochek.html</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>1.0</priority><image:image><image:loc>http://drpepper.net.ua/media/product/7f/cheerwine-cherry-soda-12-banochek-eb.jpg</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/ab/cheerwine-cherry-soda-12-banochek-d7.png</image:loc></image:image><image:image><image:loc>http://drpepper.net.ua/media/product/98/cheerwine-cherry-soda-12-banochek-fb.jpg</image:loc></image:image></url>
<url><loc>http://drpepper.net.ua/no-route</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/home</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/about</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/enable-cookies</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/privacy-policy-cookie-restriction-mode</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/partnership</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/dostavka</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/documenty</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/opt</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/distributors</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/license</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/new_partnes</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/community</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/video</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/magazines</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
<url><loc>http://drpepper.net.ua/management</loc><lastmod>2014-06-05</lastmod><changefreq>hourly</changefreq><priority>0.2</priority></url>
</channel>
</urlset>
EOF;

$rss = new XML($xml);
foreach ($rss->urlset->channel->url as $it) {
    $sitemap[] = $it->loc . "";
}


foreach ($sitemap as $dp) {
    $html = file_get_html("{$dp}");
    // find image
    $es = $html->find('a.cloud-zoom img[src]');
    if (isset($es[0])){
        echo $es[0]->src . "<br>";
    } else{
        echo 'нет в разметке' . "<br>";
    }

}


?>

</div>
</body>
</html>
