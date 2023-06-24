<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
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
        return view('user.account.create');
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
            'name' => $validated['name'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'balance' => $validated['amount'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 建立資料
        $result = Account::create($createData);
        // Response
        return response()->json([
            'message' => '新增成功',
            'redirect' => route('account.index'),
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
    public function destroy(Request $request, string $id)
    {
        // 
    }

    /**
     * 帳戶驗證規則
     */
    private function validationRules()
    {
        return [
            'name' => 'required|string|max:100',
            'type' => 'required|integer|max:255',
            'amount' => 'required|integer|min:-2147483648|max:2147483647',
            'remark' => 'nullable|string|max:200',
            'hidden' => 'nullable|boolean',
        ];
    }
}
