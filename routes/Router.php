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
    Action::delete($_POST['id']);
    $results = Action::show();
    $msg = "Фільм успішно видалено";
}

if (isset($_POST['add'])){
    if (!is_numeric($_POST['year']) || ($_POST['year'] <= 1500 || $_POST['year'] >= 2019))
        $error = "Введіть коректний рік випуску фільму";
    else{
        Action::add($_POST['name'],$_POST['year'], $_POST['select'], $_POST['actors']);
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
    $results = Action::search_by_actor('%'.$_POST['actor'].'%');
    if (!isset($results[0])){
        $error_search = "За даним актором: '".$_POST['actor']."'фільмів не знайдено.";
    }
}

if (isset($_POST['search_title'])){
    $results = Action::search_by_title($_POST['title']);
    if (!isset($results[0])){
        $error_search = "Фільм з назвою: '".$_POST['title']."' не знайдено.";
    }
}

if (isset($_POST['info'])){
    $info = Action::info($_POST['id']);
}