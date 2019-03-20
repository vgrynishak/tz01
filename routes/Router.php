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
    Action::delete(htmlspecialchars($_POST['id']));
    $results = Action::show();
    $msg = "Фільм успішно видалено";
}

if (isset($_POST['add'])){
    $year = htmlspecialchars($_POST['year']);
    $title = htmlspecialchars($_POST['name']);
    $select = htmlspecialchars($_POST['select']);
    $actor = htmlspecialchars($_POST['actors']);
    if (!is_numeric($year) || ($year <= 1500 || $year >= 2019))
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
}

if (isset($_POST['search_actor'])){
    $actor = htmlspecialchars($_POST['actor']);
    $results = Action::search_by_actor('%'.$actor.'%');
    if (!isset($results[0])){
        $error_search = "За даним актором: '".$actor."'фільмів не знайдено.";
    }
}

if (isset($_POST['search_title'])){
    $title = htmlspecialchars($_POST['title']);
    $results = Action::search_by_title($title);
    if (!isset($results[0])){
        $error_search = "Фільм з назвою: '".$title."' не знайдено.";
    }
}

if (isset($_POST['info'])){
    $info = Action::info(htmlspecialchars($_POST['id']));
}