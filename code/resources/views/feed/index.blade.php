@extends('layout.app')

@section('content')

    <div class="col-md-3 col-xs-12 pageList">
        <h3>Your feeds</h3>
        @each('feed.onePage', $pages, 'page')
    </div>

    <div class="feedReader text-center col-md-9 col-xs-12">
        <h2>Feeds reader</h2>

        <form method="get">
            <input type="text" name="url" placeholder="RSS Source">
            <button type="submit">Fetch</button>
        </form>

        {{ $error ?? '' }}

        <?php /** @var \App\Page $page */ ?>
        @if(isset($page))
            <h3 class="pageTitle text-center">{{ $page->title }}</h3>

            @if($feeds->count() > 0)
                <div class="feedList offset-md-2 col-md-8 col-xs-10 offset-xs-1">
                    @each('feed.oneItem', $feeds, 'feed')
                </div>
            @else
                <div>There is no feeds</div>
            @endif
        @endif
    </div>

@endsection