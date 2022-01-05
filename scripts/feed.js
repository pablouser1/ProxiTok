const video = document.getElementById('video')
const item_title = document.getElementById('item_title')
const audio = document.getElementById('audio')
const audio_title = document.getElementById('audio_title')
const modal = document.getElementById('modal')
const download_button = document.getElementById('download_button')

// -- HELPERS -- //
const getHash = () => window.location.hash.substring(1)

const getVideoDataById = (id) => {
  const el = document.getElementById(id)
  if (el) {
    return el.dataset
  }
  return false
}

const isModalActive = () => modal.classList.contains('is-active')

const toggleButton = (id, force) => document.getElementById(id) ? document.getElementById(id).toggleAttribute('disabled', force) : alert('That button does not exist')

// -- MODAL -- //
const swapData = ({ video_url, video_width, video_height, desc, video_download, music_title, music_url }) => {
  video.src = video_url
  video.width = video_width
  video.height = video_height
  item_title.innerText = desc
  download_button.href = video_download
  audio_title.innerText = music_title
  audio.src = music_url
}

const showModal = (id) => {
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

const getPrevOrNext = (forward) => {
  const hash = getHash()
  if (hash) {
    const el = document.getElementById(hash)
    if (el) {
      if (forward) {
        return el.parentElement.nextElementSibling ? el.parentElement.nextElementSibling.children[0] : null
      }
      return el.parentElement.previousElementSibling ? el.parentElement.previousElementSibling.children[0] : null
    }
  }
  return null
}

const moveVideo = (forward) => {
  // Re-enable buttons
  toggleButton('back-button', false)
  toggleButton('next-button', false)
  const new_el = getPrevOrNext(forward)
  if (new_el) {
    window.location.hash = new_el.id
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
const hashChange = () => {
  if (window.location.hash) {
    const hash = getHash()
    if (hash) {
      // Check first if the modal is already active
      if (isModalActive()) {
        // If it is, get hash video id and swap data
        const dataset = getVideoDataById(hash)
        if (dataset) {
          swapData(dataset)
          video.play()
        }
      } else {
        showModal(hash)
      }
    }
  }
}

const swapImages = (e, mode) => {
  if (mode === 'gif') {
    const a = e.target
    const img = a.children[0]
    const gif = a.children[1]
    img.classList.add('hidden')
    gif.classList.remove('hidden')
  } else if (mode === 'img') {
    const gif = e.target
    const img = e.target.parentElement.children[0]
    img.classList.remove('hidden')
    gif.classList.add('hidden')
  }
}

document.getElementById('modal-background').addEventListener('click', hideModel, false)
document.getElementById('modal-close').addEventListener('click', hideModel, false)
document.getElementById('back-button').addEventListener('click', () => moveVideo(false))
document.getElementById('next-button').addEventListener('click', () => moveVideo(true))
window.addEventListener('hashchange', hashChange, false)

// Image hover
const images = document.getElementsByClassName("clickable-img")
for (let i = 0; i < images.length; i++) {
  images[i].addEventListener('mouseenter', e => swapImages(e, 'gif'), false)
  images[i].addEventListener('mouseout', e => swapImages(e, 'img'), false)
}

hashChange()
