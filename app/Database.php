<?php

namespace SimpleTodo;

use PDO;
use RuntimeException;


class Database extends PDO
{
    private static $instance = null;

    private static array $config;

    private function __construct()
    {
        if (!isset(self::$config)) {
            throw new RuntimeException('Missing database config.');
        }

        parent::__construct(self::$config['dsn'], self::$config['user'], self::$config['password']);
    }

    public static function setConfig(array $config): void
    {
        self::$config = $config;
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}
