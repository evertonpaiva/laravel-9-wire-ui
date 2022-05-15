import ClipboardJS from 'clipboard/dist/clipboard'

document.querySelectorAll('pre').forEach(pre => {
  if ('nocopy' in pre.dataset) {
    return
  }

  const codeBlock = pre.querySelector('code')
  const btn = document.createElement('button')

  const codeId = `code${ Math.random().toString(36).slice(2) }`
  codeBlock.setAttribute('id', codeId)

  pre.setAttribute('style', 'position:relative;')

  btn.innerHTML = 'copy'
  btn.setAttribute('title', 'copy')
  btn.setAttribute('class', 'rounded overflow-visible absolute top-1 right-1 p-3 text-white px-1 py-1 font-mono text-sm text-gray-900 bg-teal-100 rounded-md')
  btn.setAttribute('data-copybutton', '')
  btn.dataset.clipboardTarget = `#${ codeBlock.id }`
  pre.appendChild(btn)
})

const clipboard = new ClipboardJS('[data-copybutton]')

clipboard.on('success', (element) => {
  element.clearSelection()

  const btn = element.trigger

  btn.innerHTML = 'copied!'

  setTimeout(() => {
    btn.innerHTML = 'copy'
  }, 1000)
})
