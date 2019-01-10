<div class="onePage">
    <a href="/feed?url={{urlencode($page->url)}}" class="onePageTitle">{{ $page->title . ' - ' . $page->pageDate}}</a>
    <a href="/page/remove/{{$page->id}}" class="removePage">Remove</a>
</div>

<script>
    $(function(){
    });
</script>