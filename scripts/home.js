const goToUser = e => {
  e.preventDefault()
  const formData = new FormData(e.target)
  const username = formData.get('username')
  window.location.href = `./@${username}`
}

const goToTag = e => {
  e.preventDefault()
  const formData = new FormData(e.target)
  const tag = formData.get('tag')
  window.location.href = `./tag/${tag}`
}

const goToVideo = e => {
  e.preventDefault()
  const formData = new FormData(e.target)
  const video_id = formData.get('video_id')
  window.location.href = `./video/${video_id}`
}

document.getElementById('username_form').addEventListener('submit', goToUser, false)
document.getElementById('tag_form').addEventListener('submit', goToTag, false)
document.getElementById('video_form').addEventListener('submit', goToVideo, false)
