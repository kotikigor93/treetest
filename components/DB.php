<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 19:26
 */

namespace components;


class DB extends \PDO
{
    /**
     * @var array|string[]
     */
    private array $config = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'table' => 'treetest',
    ];

    public function __construct()
    {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['table']}";
        try {
            parent::__construct($dsn, $this->config['user'], $this->config['pass']);
        } catch (\PDOException $error){
            echo 'Connection problem: ' . $error->getMessage();
        }
    }
}