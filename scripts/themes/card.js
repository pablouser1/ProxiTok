var opened_video_id = null

const video = document.getElementById('video')
const item_title = document.getElementById('item_title')
const item_date = document.getElementById('item_date')
const audio = document.getElementById('audio')
const audio_title = document.getElementById('audio_title')
const modal = document.getElementById('modal')
const download_watermark = document.getElementById('download_watermark')
const download_nowatermark = document.getElementById('download_nowatermark')
const share_input = document.getElementById('share_input')

const getVideoDataById = id => {
  const el = document.getElementById(id)
  if (el) {
    opened_video_id = id
    return el.dataset
  }
  return null
}

const isModalActive = () => modal.classList.contains('is-active')

const toggleButton = (id, force) => document.getElementById(id).toggleAttribute('disabled', force)

// -- MODAL -- //
const swapData = ({ video_url, desc, createtime, video_download_watermark, video_download_nowatermark, video_share_url, music_title, music_url }) => {
  video.src = video_url
  item_title.innerText = desc
  item_date.innerText = new Date(createtime * 1000).toLocaleString()
  download_watermark.href = video_download_watermark
  download_nowatermark.href = video_download_nowatermark
  share_input.value = video_share_url
  audio_title.innerText = music_title
  audio.src = music_url
}

const showModal = id => {
  const dataset = getVideoDataById(id)
  if (dataset) {
    swapData(dataset)
    modal.classList.toggle('is-active')
    video.play()
  }
}

const hideModel = () => {
  video.pause()
  audio.pause()
  video.currentTime = 0
  modal.classList.toggle('is-active')
  toggleButton('back-button', false)
  toggleButton('next-button', false)
  history.pushState('', document.title, window.location.pathname + window.location.search)
}

const getPrevOrNext = forward => {
  if (opened_video_id) {
    const el = document.getElementById(opened_video_id)
    if (el) {
      if (forward) {
        return el.nextElementSibling
      }
      return el.previousElementSibling
    }
  }
  return null
}

const moveVideo = forward => {
  // Re-enable buttons
  toggleButton('back-button', false)
  toggleButton('next-button', false)
  const new_el = getPrevOrNext(forward)
  if (new_el) {
    opened_video_id = new_el.id
    swapData(new_el.dataset)
  } else {
    // Max reached, disable buttons depending on direction
    if (forward) {
      toggleButton('next-button', true)
    } else {
      toggleButton('back-button', true)
    }
  }
}

// EVENTS //
const openVideo = video_id => {
  if (isModalActive()) {
    const dataset = getVideoDataById(video_id)
    if (dataset) {
      swapData(dataset)
    }
  } else {
    showModal(video_id)
  }
}

const swapImages = e => {
  const div = e.target
  const img = div.children[0]
  const gif = div.children[1]
  if (!gif.src) {
    gif.src = gif.dataset.src
  }
  img.classList.toggle('hidden')
  gif.classList.toggle('hidden')
}

const copyShare = () => {
  share_input.select();
  navigator.clipboard.writeText(share_input.value);
  alert('Copied!')
}

document.getElementById('modal-background').addEventListener('click', hideModel)
document.getElementById('modal-close').addEventListener('click', hideModel)
document.getElementById('back-button').addEventListener('click', () => moveVideo(false))
document.getElementById('next-button').addEventListener('click', () => moveVideo(true))

// Image hover
const images = document.getElementsByClassName("clickable-img")
for (let i = 0; i < images.length; i++) {
  images[i].addEventListener('mouseenter', swapImages, false)
  images[i].addEventListener('mouseout', swapImages, false)
}
