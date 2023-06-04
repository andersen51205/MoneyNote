@extends('layouts.app')

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-11 col-md-8 col-lg-6 col-xl-5 bg-white rounded-4 mt-4 p-5">
            <form method="POST" action="{{ route('password.reset') }}" id="Form_reset_password" class="mx-2 mx-md-4">
                @csrf
                <div class="text-center">
                    <h1>重設密碼</h1>
                </div>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mt-3">
                    <span class="d-block mb-1">電子郵件</span>
                    <input type="email" class="form-control py-2 necessary" name="email">
                </div>
                <div class="mt-3">
                    <span class="d-block mb-1">密碼</span>
                    <input type="password" class="form-control py-2 necessary" name="password">
                </div>
                <div class="mt-3">
                    <span class="d-block mb-1">確認密碼</span>
                    <input type="password" class="form-control py-2 necessary" name="password_confirmation">
                </div>
                <button type="button" class="btn btn-lg btn-secondary rounded-pill px-5 my-3"
                        onclick="formSubmit()">
                    送出
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // 頁面初始化
    window.onload = function() {
        // 自動聚焦
        document.querySelector('input[name=email]').focus();
    }
    // 表單提交
    function formSubmit() {
        UtilSwal.formSubmit(function () {
            const route = "{{ route('password.reset') }}";
            const method = "POST";
            const form = document.querySelector('#Form_reset_password');
            let postData = new FormData(form);
            
            UtilAjax.formSubmit(route, method, postData);
        });
    }
</script>
@endsection
