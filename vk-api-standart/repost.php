<?php

class repost
{
    private $url = 'https://api.vk.com/method/'; // URL к методам API

    private $owner_id; //ID автора поста
    private $post_id; //ID поста
    public  $group_id; //ID автора поста

    private $count = 1000; //По сколько "репостов" и "лайков" доставать
    private $users = array(); //Массив с пользователями
    private $countReposts; //Количество репостов у текущего пользователя
    private $findPost; //ID найденного репоста в пользовательских новостях
    private $find; //Флаг найден/не найден репост у пользователя

    public function __construct($owner_id = '-67280997', $post_id = '2', $group_id = '67280997') {
        $this->owner_id = $owner_id;
        $this->post_id = $post_id;
        $this->group_id = $group_id;
    }

    //Сообщение о действиях
    private function printProgress($text, $start = true, $error = false) {
        if ($error) $color = 'red';
        else if ($start) $color = '#444';
        else $color = 'green';

        echo '<li style="color: '.$color.';">'.$text.'</li>';
        ob_flush();
        flush();
    }

    /*Считываем всех пользователей, кто поделился нашим постом
    * $onwer_id - ID автора поста
     * $post_id - ID-поста
     * $fitler - "likes" или "copies"
     * $offset - смещение по пользователям. Можно достать максимум 1000 пользователей
    * $onlyCount - вернуть только количество репостов
     * $start - используется для рекурсии
     */

    private function getMembers($group_id, $user_id) {


        $extended = 1;
        //Формируем URL
        $url = $this->url.'groups.isMember?';
        $url .= 'group_id='.$group_id.'&';
        $url .= 'user_id='.$user_id.'&';
        $url .= 'extended='.$extended.'&';
        $json = file_get_contents($url); //Получаем JSON-ответ
        $data = json_decode($json, true);

        $response = $data['response'];

        return $response['member'];


    }

    public function findReposts()
    {
        for ($i = 245041606; $i <= 245041616; $i++) {
            echo "<br>";
            echo $this->getMembers($this->group_id, $i);

        }
    }


}


?>

<html>
<head>
    <title>Repost</title>
    <meta charset="UTF-8">
</head>
<body>

<?php
$repost = new repost();
$repost->findReposts()

?>
</body>
</html>