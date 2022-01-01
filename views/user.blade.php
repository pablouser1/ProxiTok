<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $user->info->detail->user->nickname }} - TikTok</title>
    <link rel="stylesheet" href="https://unpkg.com/bulmaswatch/superhero/bulmaswatch.min.css">
    <link rel="stylesheet" href="../styles/user.css">
</head>
<body>
    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <p class="title">{{ $user->info->detail->user->uniqueId }}'s profile</p>
                <p class="subtitle">{{ $user->info->detail->user->signature }}</p>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="columns is-multiline is-vcentered">
            @foreach ($user->items as $item)
            <div class="column is-one-quarter">
                <figure class="image clickable-img">
                    <img data-video_url="{{ $item->video->playAddr }}"
                        data-video_download="{{ $item->video->downloadAddr }}"
                        data-desc="{{ $item->desc }}"
                        data-video_width="{{ $item->video->width }}"
                        data-video_height="{{ $item->video->height }}"
                        data-music_title="{{ $item->music->title }}"
                        data-music_url="{{ $item->music->playUrl }}"
                        src="{{ $item->video->originCover }}"/>
                </figure>
            </div>
            @endforeach
        </div>
    </section>
    <div id="modal" class="modal">
        <div id="modal-background" class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title" id="item_title"></p>
                <button id="modal-close" class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body has-text-centered" style="overflow: hidden;">
                <video id="video" controls preload="none"></video>
            </section>
            <footer class="modal-card-footer has-text-centered">
                <div class="box">
                <a id="download_button" target="_blank" class="button is-info" href="#" download>Download</a>
                <p id="audio_title"></p>
                <audio id="audio" controls></audio>
                </div>
            </footer>
        </div>
    </div>
    <script src="../scripts/user.js"></script>
</body>
</html>
