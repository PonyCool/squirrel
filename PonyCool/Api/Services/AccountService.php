<?php


namespace PonyCool\Api\Services;

use PonyCool\Api\Entities\Account;
use PonyCool\Api\Models\AccountModel;
use Exception;

class AccountService extends BaseService
{

    /**
     * 创建账户
     * @param Account $account
     * @return bool
     */
    public function create(Account $account): bool
    {
        $db = $this->getDb();
        $accountModel = new AccountModel($db);
        try {
            $res = $accountModel->save($account);
            return $res;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 更新账户信息
     * @param Account $account
     * @return bool
     */
    public function update(Account $account): bool
    {
        if (is_null($account->id)) {
            return false;
        }
        $db = $this->getDb();
        $accountModel = new AccountModel($db);
        try {
            $res = $accountModel->save($account);
            return $res;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * 删除账户
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $db = $this->getDb();
        $accountModel = new AccountModel($db);
        try {
            $accountModel->delete($id);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}