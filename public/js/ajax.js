function likeClick(event) {
    event.preventDefault()

    // this fait référence au lien sur lequel on clique (link)
    const url = this.href
    const spanCount = this.querySelector("span.js-likes")
    const icone = this.querySelector("i")
    let likeLabel = this.querySelector('span.js-label')

    fetch(url, {method: "GET"}).then(response => response.json()).then(function(response) {
        spanCount.textContent = response.likes
        if (icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far')
            likeLabel.textContent = response.label
        } else {
            icone.classList.replace('far', 'fas')
            likeLabel.textContent = response.label
        }
    })
}

document.querySelectorAll(".js-like").forEach((link) => {
    link.addEventListener("click", likeClick)
})
