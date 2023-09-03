@extends('layouts.app')

@section('content')
<div class="content-page container-md">
    {{-- 麵包屑 --}}
    @include('layouts.components.breadcrumb', [
        'breadcrumbs' => [
            ['name' => '類別管理', 'url' => route('category.index')],
            ['name' => $parentCategory->name]
        ]
    ])
    {{-- 標題 --}}
    <h1>{{ $parentCategory->name }}</h1>
    {{-- 內容 --}}
    <div class="d-flex justify-content-end my-3">
        <a class="btn btn-outline-primary" href="{{ route('subcategory.create', $parentCategory->id) }}">
            <i class="fa-solid fa-plus"></i> 新增
        </a>
    </div>
    <div class="tab-content">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width:5">#</th>
                    <th style="width:20%">名稱</th>
                    <th style="width:50%">備註</th>
                    <th style="width:9%">狀態</th>
                    <th style="width:16%">操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $i => $category)
                    <tr>
                        <td data-title="#">{{ $i+1 }}</td>
                        <td data-title="名稱">{{ $category->name }}</td>
                        <td data-title="備註">{{ $category->remark }}</td>
                        <td data-title="狀態">
                            @if($category->hidden)
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
                            <a class="btn btn-outline-success m-1" href="{{ route('subcategory.edit', [$parentCategory->id, $category->id] ) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger m-1"
                                    data-parent-id="{{ $parentCategory->id }}"
                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                    onclick="deleteCategory(this)">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">無類別資料</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    function deleteCategory(el) {
        const dataParentId = el.getAttribute('data-parent-id');
        const dataId = el.getAttribute('data-id');
        const dataName = el.getAttribute('data-name');
        if(dataParentId && dataId) {
            UtilSwal.deleteSubmit(dataName, function () {
                const route = "{{ route('subcategory.destroy', ['PARENT_ID', 'ID']) }}";
                const method = 'DELETE';
                let url = route.replace('PARENT_ID', dataParentId).replace('ID', dataId);
                let postData = {};
                
                UtilAjax.formSubmit(url, method, postData);
            });
        }
    }
</script>
@endsection
