<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountRepository
{
    public function __construct()
    {
    }

    /**
     * 取得使用者的資料
     */
    public function getData()
    {
        $accounts = Account::where('user_id', Auth::user()->id)
            ->get();
        return $accounts;
    }

    /**
     * 用id取得使用者的資料
     */
    public function getDataById($id)
    {
        $account = Account::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        return $account;
    }

    /**
     * 建立資料
     */
    public function createData($data)
    {
        $result = Account::create($data);
        return $result;
    }

    /**
     * 用id更新資料
     */
    public function updateDataById($id, $data)
    {
        $result = Account::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->update($data);
        return $result;
    }

    /**
     * 用id刪除資料
     */
    public function deleteDataById($id)
    {
        $result = Account::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->delete();
        return $result;
    }
}