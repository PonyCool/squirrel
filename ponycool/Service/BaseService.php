<?php


namespace PonyCool\Service;

use Config\Database;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BaseService
{
    protected $db;
    protected $table;
    private $readDB;
    private $writeDB;

    public function __construct()
    {
        if (getenv('database.read.database')) {
            $this->setReadDB('read');
        }
        if (getenv('database.write.database')) {
            $this->setWriteDB('write');
        }
    }

    /**
     * 获取数据库连接
     * @param int $isWriteType 0：单节点，1：读库，2：写库
     * @return object
     */
    public function getDb(int $isWriteType = 0): object
    {
        if (!$isWriteType) {
            if (is_null($this->db)) {
                return Database::connect();
            }
        }
        if (1 === $isWriteType) {
            $this->setDb($this->getReadDB());
        }
        if (2 === $isWriteType) {
            $this->setDb($this->getWriteDB());
        }
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
    private function getReadDB()
    {
        return $this->readDB;
    }

    /**
     * @param mixed $readDB
     */
    private function setReadDB($readDB): void
    {
        $this->readDB = $readDB;
    }

    /**
     * @return mixed
     */
    private function getWriteDB()
    {
        return $this->writeDB;
    }

    /**
     * @param mixed $writeDB
     */
    private function setWriteDB($writeDB): void
    {
        $this->writeDB = $writeDB;
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