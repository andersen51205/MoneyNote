<nav class="navbar navbar-expand-md bg-light shadow-sm">
    <div class="container">
        {{-- 網站名稱 --}}
        @guest
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        @else
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        @endguest
        {{-- 收縮按鈕 --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse fs-5" id="navbarSupportedContent">
            {{-- 左側選單 --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account.index') }}">帳戶管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('category.index') }}">類別管理</a>
                </li>
            </ul>
            {{-- 右側選單 --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    {{-- 身分認證選單 --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login.form') }}">登入</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register.form') }}">註冊</a>
                    </li>
                @else
                    {{-- 使用者選單 --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
