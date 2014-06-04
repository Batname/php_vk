

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
    <table class="table">
        <?php

        $songs =  array(
            '1' => array('artist'=>'114', 'songname'=>'Soma', 'help'=>'Soma'),
            '2' => array('artist'=>'10', 'songname'=>'The Island', 'help'=>'Soma'),
            '3' => array('artist'=>'15', 'songname' =>'Second-hand News', 'help'=>'Soma')
        );

        var_dump($songs);

        function subval_sort($a,$subkey) {
            foreach($a as $k=>$v) {
                $b[$k] = strtolower($v[$subkey]);
            }
            arsort($b);
            foreach($b as $key=>$val) {
                $c[] = $a[$key];
            }
            return $c;
        }

        $songs = subval_sort($songs,'artist');
        var_dump($songs);




        ?>
    </table>
</div>

</body>

