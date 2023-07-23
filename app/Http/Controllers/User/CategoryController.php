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
        //
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
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
