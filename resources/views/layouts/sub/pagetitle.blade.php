<div class="pagetitle">
    <h1>{{ $title??'' }}</h1>
    @isset($breadcrumbs)
        <nav>
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li @class(['breadcrumb-item', 'active' => ($breadcrumb['active']??false)])>
                        @if ($breadcrumb['link']??false)
                            <a href="{{ $breadcrumb['link'] }}">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    @endisset
</div>