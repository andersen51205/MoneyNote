{{-- Breadcrumb --}}
<div class="breadcrumbs">
    <a href="{{ route('home') }}" class="item">首頁</a>
    @foreach ($breadcrumbs as $i => $breadcrumb)
        @if ($loop->last)
            @if (isset($breadcrumb['url']))
                <a href="{{ $breadcrumb['url'] }}" class="item active">{{ $breadcrumb['name'] }}</a>
            @else
                <a class="item active">{{ $breadcrumb['name'] }}</a>
            @endif
        @else
            @if (isset($breadcrumb['url']))
                <a href="{{ $breadcrumb['url'] }}" class="item">{{ $breadcrumb['name'] }}</a>
            @else
                <a class="item active">{{ $breadcrumb['name'] }}</a>
            @endif
        @endif
    @endforeach
</div>
