document.addEventListener('DOMContentLoad', () => {
  const preferDark = JSON.parse(window.localStorage.getItem('dark'))
  const browserDark = window.matchMedia('(prefers-color-scheme: dark)').matches && preferDark !== null

  if (browserDark || preferDark === true) {
    document.body.classList.add('dark')
  }
})
