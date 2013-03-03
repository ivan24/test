<?php

class MyStatic
{
    protected static $dsn = 'sqlite:products.db';
    protected static $pdo = null;

    static function getDSN()
    {
        return self::$dsn;
    }

    static function setDSN($value)
    {
        self::$dsn = $value;
    }

    static function getPdo()
    {
        return self::$pdo;
    }

    static function setPdo($value)
    {
        if (!self::$pdo) {
            return self::$pdo = new PDO($value);
        }
        return self::$pdo;
    }

    public static function getInstance($id)
    {
        try {
            $pdo = self::setPdo(self::$dsn);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
            $result = $stmt->execute(array($id));
            if (!$result) {
                throw new PDOException("пустой запрос");
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
            var_dump($pdo->errorInfo());
        }

        if (empty($row)) {
            return null;
        }
        return $row;
    }
}

$a = MyStatic::getInstance(5);
var_dump($a);