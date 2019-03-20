<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-20
 * Time: 17:12
 */

function create_database_schem(){
    try {
        $mysql = new PDO(DB_DSNF, DB_USER, DB_PASSWORD);
        $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $mysql->prepare("SHOW DATABASES LIKE '".DB_NAME."'");
        $result->execute();
        $count = $result->rowCount();
        if (!$count) {
            Db::create_db();
        }
        Db::create_table();
    }
    catch (PDOException $ex)
    {
        die("Fail connection ".$ex->getMessage().PHP_EOL);
    }
}
