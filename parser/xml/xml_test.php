<?php
require_once("php_xml.php");
$xml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:bittorrent="http://www.borget.info/bittorrent-rss/">
      <channel>
            <title>Preved</title>
            <item>
                  <url>hello</url>
            </item>
            <item>
                  <url>hola</url>
            </item>
            <item>
                  <url>purr</url>
            </item>
      </channel>
</rss>
EOF;
echo '<pre>';
$rss = new XML($xml);
foreach ($rss->rss->channel->item as $it)
    echo $it->url."\n";

?>