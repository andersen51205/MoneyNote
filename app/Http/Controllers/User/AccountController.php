<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $accountRepo;

    public function __construct(
        AccountRepository $accountRepo
    )
    {
        $this->accountRepo = $accountRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 取得資料
        $accounts = $this->accountRepo->getData();
        $types = [
            1 => '現金',
            2 => '儲值卡',
            3 => '銀行',
            4 => '信用卡',
        ];
        // Response
        return view('user.account.index', [
            'accounts' => $accounts,
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
            1 => '現金',
            2 => '儲值卡',
            3 => '銀行',
            4 => '信用卡',
        ];
        // Response
        return view('user.account.create', [
            'types' => $types,
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
            'name' => $validated['name'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'balance' => $validated['amount'],
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 建立資料
        $result = $this->accountRepo->createData($createData);
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
        // 取得資料
        $account = $this->accountRepo->getDataById($id);
        $types = [
            1 => '現金',
            2 => '儲值卡',
            3 => '銀行',
            4 => '信用卡',
        ];
        // 檢查資料是否存在
        if(!$account) {
            abort(404);
        }
        // Response
        return view('user.account.edit', [
            'account' => $account,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 表單驗證
        $validated = $request->validate($this->validationRules());
        // 取得原始資料
        $accountData = $this->accountRepo->getDataById($id);
        if(!$accountData) {
            return response()->json([
                'message' => '更新失敗',
            ], 404);
        }
        // 計算原始金額變化
        $balance = $validated['amount'] - $accountData->amount + $accountData->balance;
        // 資料處理
        $updateData = [
            'user_id' => Auth::user()->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'balance' => $balance,
            'remark' => $validated['remark'],
            'hidden' => $validated['hidden'] ?? 0,
        ];
        // 更新資料
        $result = $this->accountRepo->updateDataById($id, $updateData);
        // Response
        return response()->json([
            'message' => '更新成功',
            'redirect' => route('account.index'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // 取得要刪除的資料
        $account = $this->accountRepo->getDataById($id);
        // 檢查是否存在
        if(!$account) {
            return response()->json([
                'message' => '找不到',
            ], 404);
        }
        // 刪除資料
        $result = $this->accountRepo->deleteDataById($account->id);
        // Response : 回傳204會使response為空，因此改為200
        return response()->json([
            'message' => '刪除成功',
            'redirect' => route('account.index'),
        ], 200);
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
