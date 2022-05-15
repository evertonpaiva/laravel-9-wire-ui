document.addEventListener('livewire:load', () => {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault()

            const hash = this.getAttribute('href')
            document.querySelector(hash)?.scrollIntoView({
                behavior: 'smooth'
            })

            history.pushState(null, null, hash)
        })
    })

    const hash = window.location.hash
    if (hash) {
        document.querySelector(hash)?.scrollIntoView({
            behavior: 'smooth'
        })
    }
})
