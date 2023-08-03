@extends('layouts.app')

@section('content')
<div class="content-page container-md">
    {{-- 麵包屑 --}}
    @include('layouts.components.breadcrumb', [
        'breadcrumbs' => [
            ['name' => '類別管理']
        ]
    ])
    {{-- 標題 --}}
    <h1>類別管理</h1>
    {{-- 分頁 --}}
    <ul id="Tab_category" class="nav nav-tabs justify-content-center" role="tablist">
        @foreach ($types as $key => $type)
            <li class="nav-item" role="presentation">
                <button @class([
                            'nav-link',
                            'px-5',
                            'fs-3',
                            'active' => $loop->first,
                        ])
                        data-bs-toggle="tab" data-bs-target="#Div_categroy_type_{{ $key }}"
                        type="button" role="tab">
                    {{ $type }}
                </button>
            </li>
        @endforeach
    </ul>
    {{-- 內容 --}}
    <div class="d-flex justify-content-end my-3">
        <a class="btn btn-outline-primary" href="{{ route('category.create') }}">
            <i class="fa-solid fa-plus"></i> 新增
        </a>
    </div>
    <div class="tab-content">
        @foreach ($types as $key => $type)
            <div id="Div_categroy_type_{{ $key }}" @class([
                        'tab-pane',
                        'fade',
                        'show' => $loop->first,
                        'active' => $loop->first,
                    ]) role="tabpanel" tabindex="0">
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
                        @forelse ($categories[$key] as $i => $category)
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
                                    <a class="btn btn-outline-primary m-1"
                                            href="{{ route('category.show', $category->id) }}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                    <a class="btn btn-outline-success m-1"
                                            href="{{ route('category.edit', $category->id) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger m-1"
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
        @endforeach
    </div>
</div>
@endsection

@section('script')
<script>
    function deleteCategory(el) {
        const dataId = el.getAttribute('data-id');
        const dataName = el.getAttribute('data-name');
        if(dataId) {
            UtilSwal.deleteSubmit(dataName, function () {
                const route = "{{ route('category.destroy', 'ID') }}";
                const method = 'DELETE';
                let postData = {};
                
                UtilAjax.formSubmit(route.replace('ID', dataId), method, postData);
            });
        }
    }
</script>
@endsection
