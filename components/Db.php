<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-03-20
 * Time: 15:07
 */

class Db
{
    public static function create_table()
    {
        $db = self::getConnection();;
        if ($db !== null){
            try
            {
                $sql = file_get_contents(ROOT."/config/table.sql");
                $create = $db->prepare("USE `".DB_NAME."`");
                $create->execute();
                $db->exec($sql);
                return true;
            }
            catch (PDOException $ex) {
                die ("Fail to create table : ".$ex->getMessage().PHP_EOL);
            }
        }
        else
            return false;
    }

    static function create_db()
    {
        try {
            $mysql = new PDO(DB_DSNF, DB_USER, DB_PASSWORD);
            $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $create = $mysql->prepare("CREATE DATABASE IF NOT EXISTS `".DB_NAME."`");
            $create->execute();

        } catch (PDOException $ex) {
            die ("Failure to create database".$ex->getMessage().PHP_EOL);
        }
    }


    public static function getConnection()
    {
        try
        {
            $db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $use_db = $db->prepare("USE `".DB_NAME."`");
            $use_db->execute();
        }
        catch (PDOException $ex)
        {
            echo ("Conection error: ". $ex->getMessage() .PHP_EOL );
            $db = NULL;
        }
        return $db;
    }
}