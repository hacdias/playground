for (const link of document.links) {
  if (link.hostname !== window.location.hostname) {
    link.target = '_blank'
  }
}
