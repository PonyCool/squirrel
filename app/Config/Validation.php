<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $register = [
        'account_name' => 'required|min_length[3]',
        'pwd' => 'required|min_length[6]',
        'pass_confirm' => 'required|matches[pwd]',
        'name' => 'required|min_length[3]',
    ];
    public $register_errors = [
        'account_name' => [
            'required' => '请检查账户名称字段，此字段为必填项',
            'min_length' => '请输入不少于6位字符长度的密码',
        ],
        'pwd' => [
            'required' => '请输入不少于6位字符长度的密码',
            'min_length' => '请输入不少于6位字符长度的密码',
        ],
        'pass_confirm' => [
            'required' => '确认密码不匹配',
            'matches' => '确认密码不匹配'
        ],
        'name' => [
            'required' => '请检查用户名字段，此字段为必填项',
            'min_length' => '用户名太短，请输入不少于3位字符长度的用户名',
        ]
    ];
    public $createAccount = [
        'account_name' => 'required',
        'pwd' => 'required|min_length[6]',
        'name' => 'required|min_length[3]',
    ];
    public $createAccount_errors = [
        'account_name' => [
            'required' => '请检查账户名称字段，此字段为必填项',
            'min_length' => '请输入不少于6位字符长度的密码',
        ],
        'pwd' => [
            'required' => '请输入不少于6位字符长度的密码',
            'min_length' => '请输入不少于6位字符长度的密码',
        ],
        'name' => [
            'required' => '请检查用户名字段，此字段为必填项',
            'min_length' => '用户名太短，请输入不少于3位字符长度的用户名',
        ],
    ];
}
