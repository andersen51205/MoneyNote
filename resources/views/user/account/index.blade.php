@extends('layouts.app')

@section('content')
<div class="content-page container-md">
    {{-- 麵包屑 --}}
    @include('layouts.components.breadcrumb', [
        'breadcrumbs' => [
            ['name' => '帳戶管理']
        ]
    ])
    {{-- 標題 --}}
    <h1>帳戶管理</h1>
    {{-- 內容 --}}
    <div class="d-flex justify-content-end my-3">
        <a class="btn btn-outline-primary" href="{{ route('account.create') }}">
            <i class="fa-solid fa-plus"></i> 新增
        </a>
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th style="width:5%">#</th>
                <th style="width:20%">名稱</th>
                <th style="width:20%">餘額</th>
                <th style="width:30%">備註</th>
                <th style="width:10%">狀態</th>
                <th style="width:15%">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($accounts as $i => $account)
                <tr>
                    <td data-title="#">{{ $i+1 }}</td>
                    <td data-title="名稱">{{ $account->name }}</td>
                    <td data-title="餘額">{{ $account->balance }}</td>
                    <td data-title="備註">{{ $account->remark }}</td>
                    <td data-title="狀態">
                        @if($account->hidden)
                            <span class="badge rounded-pill fs-6 bg-secondary bg-opacity-75 p-2">
                                <i class="fa-solid fa-eye-slash"></i> 隱藏
                            </span>
                        @else
                            <span class="badge rounded-pill fs-6 bg-secondary p-2">
                                <i class="fa-solid fa-eye"></i> 顯示
                            </span>
                        @endif
                    </td>
                    <td data-title="操作">
                        <a class="btn btn-outline-success m-1 edit"
                                href="{{ route('account.edit', $account->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger m-1 delete"
                                data-id="{{ $account->id }}" data-name="{{ $account->name }}"
                                onclick="deleteAccount(this)">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">無帳戶資料</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    function deleteAccount(el) {
        const dataId = el.getAttribute('data-id');
        const dataName = el.getAttribute('data-name');
        if(dataId) {
            UtilSwal.deleteSubmit(dataName, function () {
                const route = "{{ route('account.destroy', 'ID') }}";
                const method = 'DELETE';
                let postData = {};
                
                UtilAjax.formSubmit(route.replace('ID', dataId), method, postData);
            });
        }
    }
</script>
@endsection
