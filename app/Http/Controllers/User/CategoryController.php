<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 取得資料
        $types = [
            1 => '支出',
            2 => '收入',
        ];
        $expenseCategories = Category::where('user_id', Auth::user()->id)
            ->where('type', 1)
            ->get();
        $incomeCategories = Category::where('user_id', Auth::user()->id)
            ->where('type', 2)
            ->get();
        // Response
        return view('user.category.index', [
            'categories' => [
                1 => $expenseCategories,
                2 => $incomeCategories,
            ],
            'types' => $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 取得資料
        $types = [
            1 => '支出',
            2 => '收入',
        ];
        // Response
        return view('user.category.create', [
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 表單驗證
        $validated = $request->validate($this->validationRules());
        // 資料處理
        $createData = [
            'user_id' => Auth::user()->id,
            'type' => $validated['type'],
            'name' => $validated['name'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 建立資料
        $result = Category::create($createData);
        // Response
        return response()->json([
            'message' => '新增成功',
            'redirect' => route('category.index'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // 取得資料
        $types = [
            1 => '支出',
            2 => '收入',
        ];
        $category = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        // 檢查資料是否存在
        if(!$category) {
            abort(404);
        }
        // Response
        return view('user.category.edit', [
            'category' => $category,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        // 表單驗證
        $validated = $request->validate($this->validationRules());
        // 取得資料
        $categoryData = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        // 檢查收支類別是否存在
        if(!$categoryData) {
            return response()->json([
                'message' => '找不到類別，請重新操作一次',
            ], 404);
        }
        // 資料處理
        $updateData = [
            'name' => $validated['name'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 更新資料
        $result = $categoryData->update($updateData);
        // Response
        return response()->json([
            'message' => '更新成功',
            'redirect' => route('category.index'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 取得資料
        $categoryData = Category::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        // 檢查收支類別是否存在
        if(!$categoryData) {
            return response()->json([
                'message' => '找不到類別，請重新操作一次',
            ], 404);
        }
        // 刪除資料
        $categoryData->delete();
        // Response : 回傳204會使response為空，因此使用200
        return response()->json([
            'message' => '刪除成功',
            'redirect' => route('category.index'),
        ], 200);
    }

    /**
     * 表單驗證規則
     */
    private function validationRules()
    {
        return [
            'type' => 'required|integer|max:255',
            'name' => 'required|string|max:100',
            'remark' => 'nullable|string|max:200',
            'hidden' => 'nullable|boolean',
        ];
    }
}
