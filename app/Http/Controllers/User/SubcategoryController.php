<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(
        CategoryRepository $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
    }

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
    public function create($parentId)
    {
        // 取得資料
        $parentCategory = $this->categoryRepo->getCategoryById($parentId);
        if(!$parentCategory) {
            abort(404);
        }
        // Response
        return view('user.subcategory.create', [
            'parentCategory' => $parentCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($parentId, Request $request)
    {
        // 表單驗證
        $validated = $request->validate($this->validationRules());
        // 取得資料
        $parentCategory = $this->categoryRepo->getCategoryById($parentId);
        if(!$parentCategory) {
            abort(404);
        }
        // 資料處理
        $createData = [
            'user_id' => Auth::user()->id,
            'parent_id' => $parentCategory->id,
            'type' => $parentCategory->type,
            'name' => $validated['name'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 建立資料
        $result = $this->categoryRepo->createCategory($createData);
        // Response
        return response()->json([
            'message' => '新增成功',
            'redirect' => route('category.show', $parentCategory->id),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * 表單驗證規則
     */
    private function validationRules()
    {
        return [
            'name' => 'required|string|max:100',
            'remark' => 'nullable|string|max:200',
            'hidden' => 'nullable|boolean',
        ];
    }
}
