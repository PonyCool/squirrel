<?php
declare(strict_types=1);

namespace PonyCool\Entities;

use CodeIgniter\Entity\Entity;
use PonyCool\Library\SaltLib;

class Account extends Entity
{
    protected $id;
    protected $account_name;
    protected $pwd;
    protected $salt;
    protected $created_at;
    protected $updated_at;
    protected $deleted_at;
    protected $deleted;
    protected $_options = [
        'dates' => [
            'created_at',
            'updated_at',
            'deleted_at'
        ],
        'casts' => [
            'deleted' => 'boolean'
        ],
        'datamap' => []
    ];

    /**
     * @param mixed $pwd
     */
    public function setPwd($pwd): void
    {
        $this->setSalt();
        $salt = $this->getSalt();
        $this->pwd = hash_hmac('sha256', $pwd, $salt);
    }


    /**
     * @return object
     */
    public function setSalt(): object
    {
        $this->salt = SaltLib::generate();
        return $this;
    }

    /**
     * 获取盐值
     * @return string
     */
    public function getSalt(): string
    {
        $salt = $this->attributes['salt'];
        return $salt;
    }

}