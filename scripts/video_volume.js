// This will save the video volume and keep all the players on the page in sync
document.addEventListener("DOMContentLoaded", function() {
  const videos = document.querySelectorAll("video");

  // Function to save the volume to localStorage
  function saveVolume(volume) {
    localStorage.setItem("videoVolume", volume);
  }

  // Function to restore the volume from localStorage
  function restoreVolume() {
    const savedVolume = localStorage.getItem("videoVolume");
    if (savedVolume !== null) {
      videos.forEach(video => {
        video.volume = parseFloat(savedVolume);
      });
    }
  }

  // Function to sync the volume across all video elements
  function syncVolume(video) {
    videos.forEach(otherVideo => {
      if (otherVideo !== video) {
        otherVideo.volume = video.volume;
      }
    });
    saveVolume(video.volume);
  }

  // Loop through all video elements and attach event listeners
  videos.forEach(video => {
    // Save the volume when the volume changes
    video.addEventListener("volumechange", function() {
      syncVolume(video);
    });
  });

  // Restore the volume on page load
  restoreVolume();
});
