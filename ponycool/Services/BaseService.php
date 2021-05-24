<?php


namespace PonyCool\Services;

use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BaseService
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $env = getenv('default');
        $this->setDb($env);
    }

    /**
     * 获取数据库连接
     * @return object
     */
    public function getDb(): object
    {
        if (is_null($this->db)) {
            throw new DatabaseException('数据库设置错误');
        }
        return Database::connect($this->db);
    }

    /**
     * @param mixed $db
     */
    public function setDb(string $db): void
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        if (is_null($this->table)) {
            $class = get_class($this);
            $tmpArr = explode('\\', $class);
            $table = str_replace('Service', '', $tmpArr[count($tmpArr) - 1]);
            $table = strtolower($table);
            $this->setTable($table);
        }
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table): void
    {
        $this->table = $table;
    }

}