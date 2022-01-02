<section class="section">
  <div class="columns is-multiline is-vcentered">
		@foreach ($feed->items as $item)
    <div class="column is-one-quarter">
			<a id="{{$item->id}}" href="#{{$item->id}}" class="clickable-img"
				data-video_url="./stream?url={{ $item->video->playAddr }}"
				data-video_download="./stream?url={{urlencode($item->video->downloadAddr)}}"
        data-desc="{{ $item->desc }}"
        data-video_width="{{ $item->video->width }}"
        data-video_height="{{ $item->video->height }}"
        data-music_title="{{ $item->music->title }}"
        data-music_url="./audios?url={{ urlencode($item->music->playUrl) }}">
        <img loading="lazy" src="./images?url={{ urlencode($item->video->originCover) }}"/>
      </a>
    </div>
    @endforeach
  </div>
	<div class="buttons">
    @isset ($_GET['cursor'])
    <a class="button is-danger" href="?cursor=0">First</a>
    @endisset
    <a class="button is-danger" href="javascript:history.back()">Back</a>
    @if ($feed->hasMore)
    <a class="button is-success" href="?cursor={{ $feed->maxCursor }}">Next</a>
    @else
    <a class="button is-success" disabled title="No more videos available">Next</a>
    @endif
	</div>
</section>
<div id="modal" class="modal">
	<div id="modal-background" class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<button id="modal-close" class="delete" aria-label="close"></button>
			<p class="modal-card-title" id="item_title"></p>
		</header>
		<section class="modal-card-body has-text-centered" style="overflow: hidden;">
			<video id="video" controls preload="none"></video>
    </section>
		<footer class="modal-card-foot has-text-centered">
			<div class="container">
				<a id="download_button" target="_blank" class="button is-info" href="" download>Download</a>
        <p id="audio_title"></p>
        <audio id="audio" controls preload="none"></audio>
        <div class="buttons">
					<button id="back-button" class="button is-danger">Back</button>
          <button id="next-button" class="button is-success">Next</button>
        </div>
      </div>
    </footer>
  </div>
</div>
<script src="../scripts/feed.js"></script>
