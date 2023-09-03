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
    public function index($parentId)
    {
        // 取得資料
        $parentCategory = $this->categoryRepo->getCategoryById($parentId);
        if(!$parentCategory) {
            abort(404);
        }
        $categories = $this->categoryRepo->getSubcategoryByParentId($parentId);
        // Response
        return view('user.subcategory.index', [
            'parentCategory' => $parentCategory,
            'categories' => $categories,
        ]);
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
            'redirect' => route('subcategory.index', $parentCategory->id),
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
    public function edit($parentId, $id)
    {
        // 取得資料
        $parentCategory = $this->categoryRepo->getCategoryById($parentId);
        if(!$parentCategory) {
            abort(404);
        }
        $category = $this->categoryRepo->getCategoryById($id);
        if(!$category) {
            abort(404);
        }
        // Response
        return view('user.subcategory.edit', [
            'parentCategory' => $parentCategory,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($parentId, $id, Request $request)
    {
        // 表單驗證
        $validated = $request->validate($this->validationRules());
        // 取得資料
        $category = $this->categoryRepo->getCategoryById($id);
        if(!$category) {
            return response()->json([
                'message' => '找不到子類別，請重新載入後，再操作一次',
            ], 404);
        }
        if($category->parent_id !== intval($parentId)) {
            return response()->json([
                'message' => '類別有誤，請重新載入後，再操作一次',
            ], 404);
        }
        // 資料處理
        $updateData = [
            'name' => $validated['name'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 更新資料
        $result = $this->categoryRepo->updateCategoryById($category->id, $updateData);
        // Response
        return response()->json([
            'message' => '更新成功',
            'redirect' => route('subcategory.index', $category->parent_id),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($parentId, $id)
    {
        // 取得資料
        $category = $this->categoryRepo->getCategoryById($id);
        // 檢查收支類別是否存在
        if(!$category) {
            return response()->json([
                'message' => '找不到類別，請重新載入後，再操作一次',
            ], 404);
        }
        if($category->parent_id !== intval($parentId)) {
            return response()->json([
                'message' => '類別有誤，請重新載入後，再操作一次',
            ], 404);
        }
        // 刪除資料
        $result = $this->categoryRepo->deleteCategoryById($id);
        // Response : 回傳204會使response為空，因此使用200
        return response()->json([
            'message' => '刪除成功',
            'redirect' => route('subcategory.index', $category->parent_id),
        ], 200);
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
