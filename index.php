<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-19
 * Time: 18:31
 */

//ini_set('display_errors', 1); Оповіщення Помилки!
//error_reporting(E_ALL);


define('ROOT', dirname(__FILE__ , 1));


require_once (ROOT."/components/Autoload.php");
require_once (ROOT."/config/db_params.php");
require_once (ROOT."/config/setup.php");
require_once (ROOT."/routes/Router.php");
    create_database_schem();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Test</title>
</head>
<body>
    <div class="container">

        <?php /*Повідомлення*/
        if (isset($msg)){?>
            <div class="alert alert-success" role="alert"><?=$msg?></div>
        <?php }
        if (isset($error)){?>
            <div class="alert alert-danger" role="alert"><?=$error?></div>
        <?php }?>

        <form method="post"> <!-- Додавання фільму-->
            <label for="titles">Назва фільму:</label>
                <input id="titles" type="text" name="name" placeholder="title" required><br>
            <label for="year_prod">Рік Випуску:</label>
            <input id="year_prod" type="text" name="year" placeholder="year" required><br>
            <label for="format">Формат:</label>
            <select name="select" id="format">
                <option value="VHS" >VHS</option>
                <option value="DVD">DVD</option>
                <option value="Blu-Ray">Blu-Ray</option>
            </select><br>
            <div><label for="actors">Актори:</label></div>
            <textarea name="actors" id="actors" cols="30" rows="5"  required></textarea><br>
            <button type="submit" class="btn btn-success" name="add">Добавити фільм</button>
        </form>
        <hr>
        <form enctype="multipart/form-data"  method="POST">  <!-- імпорт файлів-->
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <label for="file">Імпорт файла:</label>
            <input id="file" name="userfile" type="file"accept="text/plain" required/>
            <button type="submit" class="btn btn-success" name="add_file">Імпортувати</button>
        </form>
        <hr>
        <form  class="form-inline my-2 my-lg-0" method="post">  <!-- Пошук по імені актора-->
            <label for="actor">Знайти фільм за іменем актора:</label>
            <input id="actor" class="form-control mr-sm-2" type="search" placeholder="Введіть ім'я актора" aria-label="Search" name="actor" required>
            <button class="btn-outline-success my-2 my-sm-0" name="search_actor" type="submit">Пошук</button>
        </form>
        <hr>
        <form  class="form-inline my-2 my-lg-0" method="post"> <!-- Пошук по назві фільму-->
            <label for="title">Знайти фільм за назвою:</label>
            <input id="title" class="form-control mr-sm-2" type="search" placeholder="Введіть назву фільма" aria-label="Search" name="title" required>
            <button class="btn-outline-success my-2 my-sm-0" type="submit" name="search_title">Пошук</button>
        </form>

        <hr>
        <form method="post">
            <button type="submit" class="btn btn-success" name="show">Показати фільми</button> <!-- показати всі фільми-->
        </form>
        <?php
            if (isset($error_search)){ ?>
                <div class="alert alert-warning" role="alert">
                   <?=$error_search?>
                </div>
            <?php }
            if (isset($info)){
                ?>
                <div>Title: <?=$info['Title']?></div>
                <div>Year: <?=$info['Release_Year']?></div>
                <div>Format: <?=$info['format']?></div>
                <div>Stars: <?=$info['Stars']?></div>
                <?php
            }
            if (isset($results))
                foreach ($results as $result){
                    ?>
                    <div>
                        <form method="post">
                            <hr>
                            <div><?php echo($result['Title'])?></div>
                            <input type="hidden" name="id" value="<?=$result['id']?>">
                            <button type="submit" class="btn btn-danger" name="delete">Видалити</button> <!-- видалити фільми-->
                            <button type="submit" class="btn btn-info" name="info">Info</button> <!-- переглянути інформацію-->
                        </form>
                    </div>
                    <?php
                }
        ?>
    </div>
</body>
</html>
