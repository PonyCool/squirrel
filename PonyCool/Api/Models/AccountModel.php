<?php


namespace PonyCool\Api\Models;

class AccountModel extends BaseModel
{
    protected $table = 'account';
    protected $primaryKey = 'id';
    protected $returnType = 'PonyCool\Api\Entities\Account';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['account_name', 'pwd', 'salt'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $validationRules = [
        'account_name' => 'required|alpha_numeric_space|min_length[3]',
        'pwd' => 'required|min_length[6]',
        'pass_confirm' => 'required_with[pwd]|matches[pwd]'
    ];
    protected $validationMessages = [
        'account_name' => [
            'required' => '账户名称为必填项',
            'min_length' => '账户名称长度必须大于3个字符'
        ],
        'pwd' => [
            'required' => '密码为必填项',
            'min_length' => '密码长度必须大于6个字符'
        ]
    ];
}