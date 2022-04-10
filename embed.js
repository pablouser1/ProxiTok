// Workaround to allow TikTok embed

const blockquotes = document.getElementsByClassName('tiktok-embed')
for (let i = 0; i < blockquotes.length; i++) {
  const blockquote = blockquotes[i]
  if (blockquote.children.length > 0 && blockquote.children[0].tagName !== 'iframe') {
    const iframe = document.createElement('iframe')
    iframe.style = 'width: 100%; height: 710px; display: block; visibility: unset; max-height: 710px;'
    iframe.src = 'https://www.tiktok.com/embed/v2/' + blockquote.dataset.videoId // This url will get redirected
    // Remove placeholder section
    blockquote.children[0].remove()
    // Add iframe
    blockquote.appendChild(iframe)
  }
}
