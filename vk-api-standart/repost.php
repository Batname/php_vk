<?php

class repost
{
    private $url = 'https://api.vk.com/method/'; // URL к методам API

    private $owner_id; //ID автора поста
    private $post_id; //ID поста
    public  $group_id; //Группа ID автора поста

    private $count = 1000; //По сколько "репостов" и "лайков" доставать
    private $users = array(); //Массив с пользователями
    private $memberusers = array(); //Массив с учасниками группы
    private $filterusers;  // Массив с подготовленным выводом
    private $countReposts; //Количество репостов у текущего пользователя
    private $findPost; //ID найденного репоста в пользовательских новостях
    private $find; //Флаг найден/не найден репост у пользователя

    public function __construct($owner_id = '-30022666', $post_id = '85035', $group_id = '30022666') {
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

    private function getUsers($owner_id, $post_id, $filter, $offset = 0, $onlyCount = false, $start = true) {
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

        $offset += $this->count;

        $this->getUsers( $post_id, $filter, $offset, $onlyCount, false);

        // Тест перепостов
        echo "Тест перепостов ";
        print_r($users);
        echo "<br>";


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


        // Назнечение глобальной переменной
        if ($start) {
            $this->memberusers = $member_to_array;
        }

        // Тест учасников
        echo "Тест учасников ";
        print_r($member_to_array);
        echo "<br>";


    }

    //Для удобства я изменил ключи в массиве. Ключами являются - ID пользователя сайта vk.com
    private function remakeUsersArray($usersWithInfo) {
        $new = array();
        foreach ($usersWithInfo as $value) {
            $new[$value['uid']] = $value;
        }

        return $new;


    }

    /* Получить информацию о пользователях
    * $vkIDs - массив с ID пользователей
    */
    private function getUsersInfo($vkIDs) {

        //$count = 1000;

        //Для получения информации о пользователе, используются положительные ID (ID со знаком минус имеют группы, сообщества)

        foreach ($vkIDs as $key => $val) {
            if ((int)$val < 0) unset($vkIDs[$key]);
        }

        // преобразования массива в строку через запятую для ввызова через api
        $uids = implode(',', $vkIDs);

        // Дополнительные параметры метода
        $fields = 'uid,first_name,last_name,nickname,screen_name,sex,city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,online,counters';
        // url для общего запроса по всем юзерам
        $url = $this->url.'users.get?&uids='.$uids.'&fields='.$fields.'&name_case=nom';

        $json = file_get_contents($url);
        $data = json_decode($json, true);

        // проверка и возврат response массива
        if (isset($data['response'])) {
            $response = $data['response'];
            return $response;
        }

        return 0;
    }

    //Получам посты пользователя
    private function getUsersPosts($owner_id, $offset = 0) {
        $maxNews = 600; //Максимальное колчиство новостей для поиска
        $count = 100; //100 - это максимальное количество новостей, которые можно получить за один запрос

        //Если обыскали $maxNews новостей и не нашли
        if ($offset > $maxNews - $count) {
            $this->printProgress('<b>Репост не был найден среди '.$maxNews.' новостей...</b>', false, true);
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
            $this->printProgress('<b>Ошибка получения нововстей</b>', false, true);
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

    private function findReposts()
    {
         // Получение массива, сделавших репост
        $this->getUsers($this->owner_id, $this->post_id, 'copies');
        $copies = $this->memberusers;
        // Получение массива, Поставивших лайк
        echo "Лайки!";
        //$this->getUsers($this->owner_id, $this->post_id, 'likes');
        // Получение массива, сделавших репост и которые учасники группы
        $this->getMembers($this->group_id, $this->users);
        // Массив проверяет наличие лейка и репоста
        foreach ($this->memberusers as $id) {
            if (in_array($id, $copies)) continue;
            $copies[] = $id;
        }
        // Тест нового массива
        echo "Тест массива на наличие лейка и репоста к этой записи ";
        print_r($copies);

        $this->memberusers = $copies;
        $this->printProgress('<b>Уникальных ID пользователей для получения их информации: '.count($this->memberusers).'</b>');
        // Получаю информацию о пользовотелях, учасниках группы
        $usersWithInfo = $this->getUsersInfo($this->memberusers);
        // считаю количество пользователей - учасников
        $this->printProgress('<b>Уникальных ID пользователей с информации: '.count($usersWithInfo).'</b>');
        // Изменение ключей
        $this->memberusers = $this->remakeUsersArray($usersWithInfo);

        $i = 1;
        // проверка сортировки
        foreach ($this->memberusers as $id => $data) {
            $this->getUsersPosts($id);
            $userinfo = $i .',' ;
            $userinfo1 = '<a href="http://vk.com/id'.$id.'">id'.$id.'</a>' . ',' ;
            $userinfo2=  $data['last_name'].' '.$data['first_name'].',' ;
            $userinfo3 = '<img src='.$data['photo_medium'].' alt="Title bg"></img>' . ',' ;
            // Поиск перепостов
            if ($this->find) {
                // Теперь используем метод для получения репостов у пользователей, которые репоснули с нашей группы
                $this->getUsers($id, $this->findPost, 'copies', 0, true);
                $userinfo4 = 'Id новости #'.$this->findPost.'';
                $userinfo5 = $this->countReposts.',';
                $this->memberusers[$id]['count_reposts'] = $this->countReposts;
                // Обычный вывод
                // echo '<tr>'.$userinfo. '</tr>';
                $userinfomass = $userinfo5 . $userinfo . $userinfo1 . $userinfo2 . $userinfo3 . $userinfo4;
                $member_to_array = (explode(',',$userinfomass));
                $group_member[] = $member_to_array;


            }
            $i++;
        }
        $this->filterusers = $group_member;
        var_dump($this->filterusers);


    }

    // сортировка по id
    private function position_sort($a,$group_member) {
        foreach($a as $k=>$v) {
            $b[$k] = strtolower($v[$group_member]);
        }
        arsort($b);
        foreach($b as $key=>$val) {
            $c[] = $a[$key];
        }
        return $c;
    }



    public function outputReposts() {

        //  вызывваем функцию
        $this->findReposts();

        $group_member = $this-> position_sort($this->filterusers, 0);

        var_dump($group_member);

        $i = 0;
        foreach($group_member as $value) {
            echo '<tr>';
            echo '<td>' . $value[0] . '</td>';
            echo '<td>' . $value[1] . ' Номер:'.$i. '</td>';
            echo '<td>' . $value[2] . '</td>';
            echo '<td>' . $value[3] . '</td>';
            echo '<td>' . $value[4] . '</td>';
            echo '<td>' . $value[5] . '</td>';
            echo '</tr>';

            if (++$i==10) break;

            }

        $total_time = round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4);
        echo $total_time;

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
<?php $repost = new repost(); $repost->outputReposts() ?>
</table>
</div>

</body>
</html>

<!-- -->