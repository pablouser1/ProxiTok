const video = document.getElementById('video')
const item_title = document.getElementById('item_title')
const audio = document.getElementById('audio')
const audio_title = document.getElementById('audio_title')
const modal = document.getElementById('modal')
const download = document.getElementById('download_button')

const showModal = (e) => {
    video.src = e.target.dataset.video_url
    video.width = e.target.dataset.video_width
    video.height = e.target.dataset.video_height
    item_title.innerText = e.target.dataset.desc
    download.href = e.target.dataset.video_download
    audio_title.innerText = e.target.dataset.music_title
    audio.src = e.target.dataset.music_url
    modal.classList.toggle('is-active')
    video.play()
}

const hideModel = () => {
    video.pause()
    audio.pause()
    video.currentTime = 0
    modal.classList.toggle('is-active')
    video.width = ''
    video.height = ''
}

// EVENTS //

// Click to show modal
const figures = document.getElementsByClassName("clickable-img")
for (let i = 0; i < figures.length; i++) {
    const figure = figures[i]
    figure.addEventListener('click', showModal, true)
}

// Click to hide modal
document.getElementById('modal-background').addEventListener('click', hideModel, true)
document.getElementById('modal-close').addEventListener('click', hideModel, true)
