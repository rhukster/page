import bodymovin from 'bodymovin/build/player/bodymovin.min'

function loadAnimation(elementId, filename) {
  bodymovin.loadAnimation({
    container: document.getElementById(elementId),
    renderer: 'svg',
    loop: true,
    autoplay: true,
    path: `/animations/${filename}`,
    rendererSettings: {
      clearCanvas: true,
      progressiveLoad: false,
      hideOnTransparent: true,
    },
  })
}

loadAnimation('trainer_animation', 'trainer.json')
loadAnimation('window_cleaner', 'window_cleaner.json')
loadAnimation('carpenter_animation', 'carpenter.json')
loadAnimation('people', 'dj.json')
