<?php

namespace Src\Config;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    public static function getConnection(): PDO
    {
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');
        if (!empty($envPath)) {
            $env = parse_ini_file($envPath);
        }
        if (
            isset($env) &&
            is_array($env) &&
            (!empty($env['host']) || !empty($env['database']) || !empty($env['username']) || !empty($env['password']))
        ) {
            return (new self())->createConnection($env['host'], $env['database'], $env['username'], $env['password']);
        }
        die("Cheque os parâmetros no seu arquivo env.ini");
    }

    public function createConnection(string $host, string $database, string $username, string $password): PDO
    {
        try {
            $conn = new PDO("mysql:host={$host};dbname={$database}", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die('Erro: ' . $e->getMessage());
        }
    }

    public static function getResultFromQuery(string $sql): PDOStatement
    {
        $conn = self::getConnection();
        $result = $conn->query($sql);
        $conn = null;
        if (empty($result)) {
            die('ERRO: cheque sua consulta SQL');
        }
        return $result;
    }

    public static function executeSQL(string $sql): string
    {
        $conn = self::getConnection();
        $prepared_query = $conn->prepare($sql);
        $prepared_query->execute();
        $id = $conn->lastInsertId();
        $conn = null;
        return $id;
    }
}
