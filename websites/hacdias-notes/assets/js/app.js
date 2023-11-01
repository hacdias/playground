for (const link of document.links) {
  if (link.hostname !== window.location.hostname) {
    link.target = '_blank'
  }
}

twemoji.parse(document.body, {
  base: 'https://cdn.hacdias.com/emojis/13.0.0/',
  folder: 'svg',
  ext: '.svg'
})
