const goToUser = (e) => {
  e.preventDefault()
  const formData = new FormData(e.target)
  const username = formData.get('username')
  window.location.href = `./@${username}`
}

const goToTag = (e) => {
  e.preventDefault()
  const formData = new FormData(e.target)
  const tag = formData.get('tag')
  window.location.href = `./tag/${tag}`
}

document.getElementById('username_form').addEventListener('submit', goToUser, false)
document.getElementById('tag_form').addEventListener('submit', goToTag, false)
