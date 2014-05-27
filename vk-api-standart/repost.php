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

        print_r($member_to_array);

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

    /* Получить информацию о пользователях
    * $vkIDs - массив с ID пользователей
    */
    public function getUsersInfo($vkIDs) {

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

        $response = $data['response'];
        $this->printProgress('Поиск нашего репоста среди '.($count + $offset).' новостей..');

        //Обрабатываем $count новостей
        foreach ($response as $news) {
            if (!is_array($news)) continue;

            /* copy_owner_id - ID моей страницы или группы
             * copy_owner_id - ID моего поста
             */
            if (isset($news['copy_owner_id'], $news['copy_post_id']) and $news['copy_owner_id'] == $this->owner_id and $news['copy_post_id'] == $this->post_id) {
                $this->users[$news['from_id']]['repost_id'] = $news['id'];
                $this->printProgress('<b>Репост успешно найден найден #'.$news['id'].'</b>', false);
                $this->findPost = $news['id'];
                $this->find = true;
                return true;
            }
        }

        $offset += $count; //Увеличиваем смещение
        $this->getUsersPosts($owner_id, $offset); //Рекурсия



    }

    public function findReposts()
    {

        $this->getUsers($this->owner_id, $this->post_id, 'copies');
        $this->getMembers($this->group_id, $this->users);

        $this->printProgress('<b>Уникальных ID пользователей для получения их информации: '.count($this->memberusers).'</b>');


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

<!-- -->