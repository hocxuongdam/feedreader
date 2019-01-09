<?php /** @var \App\Feed $feed */ ?>
<div class="oneFeed">
    <a href="{{ $feed->url }}" class="feedTitle" target="_blank">{{ $feed->title }}</a>
    <img src="{{ $feed->thumbnail }}" class="feedThumbnail"/>
    <div class="feedPubDate">{{ $feed->publish_date }}</div>
    <div class="feedDescription">{{ html_entity_decode($feed->description) }}</div>
</div>