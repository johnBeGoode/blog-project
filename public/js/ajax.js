function likeClick(event) {
    event.preventDefault()

    // this fait référence au lien sur lequel on clique (link)
    const url = this.href
    console.log(url)
    const spanCount = this.querySelector("span.js-likes")
    const icone = this.querySelector("i")


    fetch(url, {method: "GET"}).then((response) => {
        // console.log(response)
        spanCount.textContent = response.data.likes
        if (icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far')
        } else {
            icone.classList.replace('far', 'fas')
        }
    })

}

document.querySelectorAll("js-like").forEach((link) => {
    link.addEventListener("click", likeClick)
})
