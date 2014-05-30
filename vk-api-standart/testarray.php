

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


        $ages = array("54,Номер,Id,Имя","71,Номер,Id,Имя","14,Номер,Id,Имя","23,Номер,Id,Имя","65,Номер,Id,Имя","314,Номер,Id,Имя");

        print_r($ages);


        echo '<br>';
        echo '<br>';
        echo '<br>';

        $group_member = array();
        foreach($ages as $attribute => $data) {

            $member_to_array = (explode(',',$data));
            $group_member[] = $member_to_array;
        }

        var_dump($group_member);

        echo '<br>';
        echo '<br>';
        echo '<br>';

        function position_sort($a,$group_member) {
            foreach($a as $k=>$v) {
                $b[$k] = strtolower($v[$group_member]);
            }
            arsort($b);
            foreach($b as $key=>$val) {
                $c[] = $a[$key];
            }
            return $c;
        }

        $group_member = position_sort($group_member, 0);
        var_dump($group_member);



        ?>
    </table>
</div>

</body>

