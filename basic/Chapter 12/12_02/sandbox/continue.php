
<html>
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <title>Repost</title>
    <meta charset="UTF-8">
</head>
<body>

<!---->
<!--		--><?php

$bat = array(array('id' => 59, 'parentId' => 58, 'parentname' => 'Автосвет'),array('id' => 59, 'parentId' => 58, 'parentname' => 'Автосвет'),array('id' => 24, 'parentId' => 23, 'parentname' => 'Авто Аксессуары'));
var_dump($bat);

foreach ($bat as $value) {
    $new[$value['parentId']] = $value;
}

var_dump($new);


		?>
		

	</body>
</html>
