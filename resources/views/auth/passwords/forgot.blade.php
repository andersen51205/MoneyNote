@extends('layouts.app')

@section('content')
<div class="container-md my-4">
    <div class="row justify-content-center">
        <div class="col-11 col-md-8 col-lg-6 col-xl-5 bg-white rounded-4 mt-4 p-5">
            <form method="POST" action="{{ route('password.send.email') }}" id="Form_forgot_password" class="mx-2 mx-md-4">
                <div class="text-center">
                    <h1>忘記密碼</h1>
                </div>
                <div class="my-4">
                    <span class="fs-5">輸入你的電子郵件，我們將會發送一封密碼重設信到你的電子郵件。</span>
                </div>
                <div class="my-3">
                    <span class="d-block mb-1">電子郵件</span>
                    <input type="email" class="form-control py-2 necessary" name="email">
                </div>
                <button type="button" class="btn btn-lg btn-secondary rounded-pill px-4 my-3"
                        onclick="formSubmit()">
                    發送重設信
                </button>
                <a class="btn btn-lg btn-outline-secondary rounded-pill px-4 ms-3 my-3"
                        href="{{ route('login.form') }}" tabindex="-1">
                    返回
                </a>
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
        UtilSwal.showLoading();
        const route = "{{ route('password.send.email') }}";
        const method = "POST";
        const form = document.querySelector('#Form_forgot_password');
        let postData = new FormData(form);
        
        UtilAjax.formSubmit(route, method, postData);
    }
</script>
@endsection
