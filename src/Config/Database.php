<?php

namespace Src\Config;

use PDO;
use PDOException;

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

    /** como declarar um array
     * @param array{host: string, username: string, password:string, database:string} $env
     */
}
