<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-19
 * Time: 22:56
 */

class Action
{
    public static function show()
    {
        $db = Db::getConnection();
        $sql = "SELECT *   FROM films ORDER BY title ASC";
        $wait = $db->prepare($sql);
        $wait->execute();
        $results = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function delete($id)
    {
        $db = Db::getConnection();
        $sql = "DELETE   FROM films WHERE id=?";
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        return;
    }

    public static function add($title, $prod_year, $format, $Stars)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO films (Title, Release_Year, format, Stars) VALUES (?,?,?,?)";
        $wait = $db->prepare($sql);
        $wait->execute(array($title, $prod_year, $format, $Stars));
    }

    /**
     *
     */
    public static function search_by_title($title){
        $db = Db::getConnection();
        $sql = "SELECT * FROM films WHERE Title LIKE ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($title));
        $results = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function search_by_actor($actor){
        $db = Db::getConnection();
        $sql = "SELECT * FROM films WHERE Stars LIKE ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($actor));
        $results = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function info($id){
        $db = Db::getConnection();
        $sql = "SELECT * FROM films WHERE id LIKE ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $results = $wait->fetch(PDO::FETCH_ASSOC);
        return $results;
    }
    /**
     * Тут наведені два варіанти парсинга фильмів,
     * Перший варіант з допомогою регулярних виразів(активний),
     * Другий варіант з допомогою explode(неактивний).
     * а також два варіанта додавання фільмів до бази даних,
     * Перший (активний) ,більш продуктивний формуємо sql запрос
     * з усіма даними які потрібно додати і вже потім добавляєм,
     * Другий (неактивний) на кожному кроці циклу
     * добавляєм по одному рядку в базу даних.
     */

    public static function add_file()
    {
        $context = file_get_contents($_FILES['userfile']['tmp_name']);
        $films = explode("\n\n", $context);
        $values = '';
        foreach ($films as $film) {

            preg_match('/^Title: ([^\n]*)\nRelease Year: ([^\n]*)\nFormat: ([^\n]*)\nStars: ([^\n]*)/', $film, $matches); //регулярні вирази

            /**
             * Другий варіант парсинга за допомогою функції explode;
             *      $components = explode("\n", $film);
             *      $results = array();
             *      foreach ($components as $component){
             *          $result = explode(":", $component);
             *          $results[$result[0]] = $result[1];
             *      }
             */

            if (!isset($matches[0]) || !$matches[0]) {
                break;
            }
            $values .= ($values == '' ? '' : ', ') . '("' . $matches[1] . '","' . $matches[2] . '","' . $matches[3] . '","' . $matches[4] . '")';
            /**
             * Другий варіант додавання даних в базу даних;
             *      $db = Db::getConnection();
             *      $sql = "INSERT INTO camagru.films (Title, Release_Year, format, Stars) Values(?,?,?,?)";
             *      $wait = $db->prepare($sql);
             *      $wait->execute(array($matches[1],$matches[2], $matches[3], $matches[4]));
             */
        }
        $db = Db::getConnection();
        $sql = "INSERT INTO films (Title, Release_Year, format, Stars) VALUES " . $values;
        $wait = $db->prepare($sql);
        $wait->execute(array());
    }
}