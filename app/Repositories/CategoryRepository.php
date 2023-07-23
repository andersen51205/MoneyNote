<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository
{
    public function __construct()
    {
    }

    /**
     * 取得使用者的支出類別
     */
    public function getExpenseCategory()
    {
        $categories = Category::where('user_id', Auth::user()->id)
            ->where('type', 1)
            ->get();
        return $categories;
    }

    /**
     * 取得使用者的收入類別
     */
    public function getIncomeCategory()
    {
        $categories = Category::where('user_id', Auth::user()->id)
            ->where('type', 2)
            ->get();
        return $categories;
    }

    /**
     * 用id取得使用者的收支類別
     */
    public function getCategoryById($id)
    {
        $category = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        return $category;
    }

    /**
     * 建立收支類別
     */
    public function createCategory($data)
    {
        $result = Category::create($data);
        return $result;
    }

    /**
     * 用id更新類別
     */
    public function updateCategoryById($id, $data)
    {
        $result = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->update($data);
        return $result;
    }

    /**
     * 用id刪除類別
     */
    public function deleteCategoryById($id)
    {
        $result = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->delete();
        return $result;
    }
}