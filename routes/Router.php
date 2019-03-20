<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-20
 * Time: 18:50
 */

if (isset($_POST['show'])){
    $results = Action::show();
}

if (isset($_POST['delete'])){
    Action::delete(htmlspecialchars(trim($_POST['id'])));
    $results = Action::show();
    $msg = "Фільм успішно видалено";
}

if (isset($_POST['add'])){
    $year = htmlspecialchars(trim($_POST['year']));
    $title = htmlspecialchars(trim($_POST['name']));
    $select = htmlspecialchars(trim($_POST['select']));
    $actor = htmlspecialchars(trim($_POST['actors']));
    if (!$year || !$title || !$select || !$actor)
        $error = "Заповніть всі поля";
    else if (!is_numeric($year) || ($year <= 1500 || $year >= 2019))
        $error = "Введіть коректний рік випуску фільму";
    else{
        Action::add($title,$year, $select, $actor);
        $msg = "Фільм успішно додано";
        //    $results = Action::show();
    }
}

if (isset($_POST['add_file'])){
    if ($_FILES['userfile']['name']) {
        Action::add_file();
        $msg = "Фільми успішно імпортовано";
    }
    else
        $error ="Виберіть файл";
}

if (isset($_POST['search_actor'])){
    $actor = htmlspecialchars(trim($_POST['actor']));
    if($actor) {
        $results = Action::search_by_actor('%' . $actor . '%');
        if (!isset($results[0])) {
            $error_search = "За даним актором: '" . $actor . "' фільмів не знайдено.";
        }
    }
    else
        $error = "Введіть ім'я актора";
}

if (isset($_POST['search_title'])){
    $title = htmlspecialchars(trim($_POST['title']));
    if ($title) {
        $results = Action::search_by_title($title);
        if (!isset($results[0])) {
            $error_search = "Фільм з назвою: '" . $title . "' не знайдено.";
        }
    }
    else
        $error = "Введіть назву фільма";
}

if (isset($_POST['info'])){
    $info = Action::info(htmlspecialchars($_POST['id']));
}