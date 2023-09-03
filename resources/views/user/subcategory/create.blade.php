@extends('layouts.app')

@section('content')
<div class="content-page container-md">
    {{-- 麵包屑 --}}
    @include('layouts.components.breadcrumb', [
        'breadcrumbs' => [
            ['name' => '類別管理', 'url' => route('category.index')],
            ['name' => $parentCategory->name, 'url' => route('subcategory.index', $parentCategory->id)],
            ['name' => '新增子類別']
        ]
    ])
    {{-- 表單 --}}
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="custom-card">
                <div class="header">
                    <h1>新增類別</h1>
                </div>
                <div class="content">
                    <form id="Form_category" class="" method="" action="">
                        @csrf
                        {{-- 名稱 --}}
                        <div class="mb-3">
                            <label for="Input_name" class="form-label">名稱</label>
                            <input type="text" id="Input_name" class="form-control"
                                name="name">
                        </div>
                        {{-- 備註 --}}
                        <div class="mb-3">
                            <label for="Textarea_remark" class="form-label">備註</label>
                            <textarea id="Textarea_remark" class="form-control"
                                name="remark" rows="3"></textarea>
                        </div>
                        {{-- 是否隱藏 --}}
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" id="Input_hide" class="form-check-input"
                                    name="hidden" value="1" role="switch">
                                <label class="form-check-label" for="Input_hide">隱藏類別</label>
                            </div>
                        </div>
                        {{-- 表單提交 --}}
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-lg btn-primary px-4 mx-2" onclick="formSubmit()">
                                送出
                            </button>
                            <a class="btn btn-lg btn-secondary px-4 mx-2" href="{{ route('category.index') }}">
                                返回
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // 頁面初始化
    window.onload = function() {
        // 自動聚焦
        document.querySelector('input[name=name]').focus();
    }
    // 表單提交
    function formSubmit() {
        UtilSwal.formSubmit(function () {
            const route = "{{ route('subcategory.store', $parentCategory->id) }}";
            const method = 'POST';
            const form = document.querySelector('#Form_category');
            let postData = new FormData(form);
            
            UtilAjax.formSubmit(route, method, postData);
        });
    }
</script>
@endsection
