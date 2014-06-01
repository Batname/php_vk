<?php

require_once("database.php");

class repost {

    private $url = 'https://api.vk.com/method/'; // URL к методам API
    private $owner_id; //ID автора поста
    private $post_id; //ID поста
    public  $group_id; //Группа ID автора поста
    private $count = 400; //По сколько "репостов" и "лайков" доставать
    private $countpost;  // считаем уоличество репостов новости в группе
    private $countmemberusers; // Количество юзеров в группе
    private $users = array(); //Массив с пользователями
    private $memberusers = array(); //Массив с учасниками группы
    private $filterusers;  // Массив с подготовленным выводом
    private $countReposts; //Количество репостов у текущего пользователя
    private $findPost; //ID найденного репоста в пользовательских новостях
    private $find; //Флаг найден/не найден репост у пользователя

    public function __construct($owner_id = '-30022666', $post_id = '85260', $group_id = '30022666') {
        $this->owner_id = $owner_id;
        $this->post_id = $post_id;
        $this->group_id = $group_id;
    }


    private function getUserCount($owner_id, $post_id, $filter, $offset=0, $onlyCount = false, $start = true) {
        $url = $this->url.'likes.getList?type=post&friends_only=0&offset='.$offset.'&count='.$this->count.'&owner_id='.$owner_id.'&item_id='.$post_id.'&filter='.$filter;
        //получаем результат запроса в JSON-фомате
        $json = file_get_contents($url);
        //преобразуем JSON в ассоциативный массив
        $data = json_decode($json, true);

        //если ответ, не содержит нужных данных
        if (!isset($data['response'])) return false;

        $response = $data['response'];
        $countpost = $response['count']; //Получаем количество пользователей

        $this->countpost = $countpost;

        print_r($this->countpost);
        echo "<br>";

    }

    private function getUsers($owner_id, $post_id, $filter, $offset, $onlyCount = false, $start = true) {
        //формируем URL со всеми параметрами
        $url = $this->url.'likes.getList?type=post&friends_only=0';
        $url .= '&offset='.$offset.'&';
        $url .= 'count='.$this->count.'&';
        $url .= 'owner_id='.$owner_id.'&';
        $url .= 'item_id='.$post_id.'&';
        $url .= 'filter='.$filter.'';

        //получаем результат запроса в JSON-фомате
        $json = file_get_contents($url);

        //преобразуем JSON в ассоциативный массив
        $data = json_decode($json, true);

        //если ответ, не содержит нужных данных
        if (!isset($data['response'])) return false;

        $response = $data['response'];

        $count = $response['count']; //Получаем количество пользователей

        //Понадобится, когда нужно будем определить ТОЛЬКО количество репостов у пользователя
        if ($onlyCount) {
            $this->countReposts = $count;
            return true;
        }

        //Далее рекурсивно будет получать пользователей до тех пор, пока не считаем все. При этом сдвигаем offset.
        $users = $response['users'];

        //если ответ, не содержит нужных данных
        if (count($users) == 0) return false;

        // старт рекурсии присвоение глобальной переменной user
        if ($start) {
            $this->users = $users;
        } else {
            $this->users = array_merge($this->users, $users);
        }

        //$offset += $this->count;

       // $this->getUsers( $post_id, $filter, $offset, $onlyCount, false);

    }

    private function getMembers($group_id, $user_id, $start = true) {

        foreach ($user_id as $key => $val) {
            if ((int)$val < 0) unset($user_id[$key]);
        }

        $uids = implode(',', $user_id);

        $url = $this->url.'groups.isMember?group_id='.$group_id.'&user_ids='.$uids.'&extended=1';

        $json = file_get_contents($url);
        $data = json_decode($json, true);

        //если ответ, не содержит нужных данных
        if (!isset($data['response'])) return false;

        $response = $data['response'];


        // извлечение из массива только учасников группы
        foreach ($response as $member) {
            if ($member['member'] == 1) {
                $group_member[] = $member['user_id'];
            }
        }

        // переведение учасников в строку
        $member_to_string = implode(',', $group_member);

        // Возврат в Массив
        $member_to_array = (explode(',',$member_to_string));

        $countresult = count($member_to_array);

        $this->countmemberusers = $countresult;


        // Назнечение глобальной переменной
        if ($start) {
            $this->memberusers = $member_to_array;
        }

    }

    //Для удобства я изменил ключи в массиве. Ключами являются - ID пользователя сайта vk.com
    private function remakeUsersArray($usersWithInfo) {
        $new = array();
        foreach ($usersWithInfo as $value) {
            $new[$value['uid']] = $value;
        }

        return $new;
    }

    private function getUsersInfo($vkIDs) {

        //$count = 1000;

        //Для получения информации о пользователе, используются положительные ID (ID со знаком минус имеют группы, сообщества)
        foreach ($vkIDs as $key => $val) {
            if ((int)$val < 0) unset($vkIDs[$key]);
        }


        $uids = implode(',', $vkIDs);
        $fields = 'uid,first_name,last_name,nickname,screen_name,sex,city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,online,counters';
        $url = $this->url.'users.get?&uids='.$uids.'&fields='.$fields.'&name_case=nom';

        $json = file_get_contents($url);
        $data = json_decode($json, true);
        if (isset($data['response'])) {
            $response = $data['response'];
            return $response;
        }

        return 0;
    }

    private function getUsersPosts($owner_id, $offset = 0) {
        $maxNews = 600; //Максимальное колчиство новостей для поиска
        $count = 100; //100 - это максимальное количество новостей, которые можно получить за один запрос

        //Если обыскали $maxNews новостей и не нашли
        if ($offset > $maxNews - $count) {
            $this->find = false;
            return false;
        }

        //Формируем URL
        $url = $this->url.'wall.get?';
        $url .= 'owner_id='.$owner_id.'&';
        $url .= 'offset='.$offset.'&';
        $url .= 'count='.$count.'&';
        $url .= 'filter=owner';

        $json = file_get_contents($url); //Получаем JSON-ответ
        $data = json_decode($json, true);

        //Если вдруг страница пользователя "заморожена" или удалена
        if (!isset($data['response'])) {
            $this->find = false;
            return false;
        }

        // Массив с новостями
        $response = $data['response'];


        //$this->printProgress('Поиск нашего репоста среди '.($count + $offset).' новостей..');

        //Обрабатываем $count новостей
        foreach ($response as $news) {
            if (!is_array($news)) continue;

            /* copy_owner_id - ID моей страницы или группы
             * copy_owner_id - ID моего поста
             */
            if (isset($news['copy_owner_id'], $news['copy_post_id']) && $news['copy_owner_id'] == $this->owner_id && $news['copy_post_id'] == $this->post_id) {
                $this->memberusers[$news['from_id']]['repost_id'] = $news['id'];
                // Находим новость
                //echo '<b>Репост успешно найден найден запись #'.$news['id'].'</b>', false;
                // присвоение глобальной переменной findPost для дальнейшего поиска репостов
                $this->findPost = $news['id'];
                // присвоение глобальной переменной find для дальнейшего поиска репостов если есть наша новость
                $this->find = true;
                return true;
            }
        }

        $offset += $count; //Увеличиваем смещение
        $this->getUsersPosts($owner_id, $offset); //Рекурсия

    }

    private function saveReposts($offset) {

        $this->getUsers($this->owner_id, $this->post_id, 'copies', $offset);
        $copies = $this->memberusers;

        $this->getMembers($this->group_id, $this->users);

        foreach ($this->memberusers as $id) {
            if (in_array($id, $copies)) continue;
            $copies[] = $id;
        }

        $this->memberusers = $copies;
        $usersWithInfo = $this->getUsersInfo($this->memberusers);
        $this->memberusers = $this->remakeUsersArray($usersWithInfo);

        $k = 1;

        // Глобальная переменная из сламма база данных

        global $database;

        // Запись в бд
        foreach ($this->memberusers as $id => $data) {
            $this->getUsersPosts($id);
            $userinfo = $k;
            $userinfo1 = $id;
            $userinfo2=  $data['last_name'].' '.$data['first_name'];
            $userinfo3 = $data['photo_medium'];
            // Поиск перепостов
            if ($this->find) {
                // Теперь используем метод для получения репостов у пользователей, которые репоснули с нашей группы
                $this->getUsers($id, $this->findPost, 'copies', 0, true);
                $userinfo4 = $this->findPost;
                $userinfo5 = $this->countReposts;
                $this->memberusers[$id]['count_reposts'] = $this->countReposts;
                $query  = "INSERT INTO arrays (";
                $query .= "  reposts, user_news_id, username, userlink, userimage";
                $query .= ") VALUES (";
                $query .= "  '{$userinfo5}', '{$userinfo}', '{$userinfo2}', '{$userinfo1}', '{$userinfo3}'";
                $query .= ")";

                $result = $database->query($query);

                if ($result) {
                    // Success
                    // redirect_to("somepage.php");
                    echo "Success!";
                } else {
                    // Failure
                    // $message = "Subject creation failed";
                    die("Database query failed. " );
                }

            }
            $k++;

        }

    }

    public function outputRepost() {

        $this->getUserCount($this->owner_id, $this->post_id, 'copies');

        echo "Репостов учасниками:" . $this->countmemberusers;

        for ($i = 0; $i <= (($this->countpost)-1); $i+=($this->count)) {

            echo "<br>";
            echo "Сдвиг" . $i ;
            echo "<br>";
            $this->saveReposts($i);
        }
    }



}

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
    <table class="table">
        <?php


        $query = "DROP TABLE arrays";
        $result = $database->query($query);

        $create_table  = "CREATE TABLE IF NOT EXISTS `arrays` (`id` int(100) NOT NULL AUTO_INCREMENT,`reposts` int(100) DEFAULT NULL,`username` varchar(150) CHARACTER SET utf8 DEFAULT NULL,`userlink` varchar(150) CHARACTER SET utf8 DEFAULT NULL,`userimage` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,`user_news_id` int(150) DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";
        $result = $database->query($create_table);

        $repost = new repost();
        $repost->outputRepost();

        ?>
    </table>
</div>

</body>
</html>