document.addEventListener("DOMContentLoaded",() => {
    (() => {
        const forms = document.querySelectorAll("form");

        forms.forEach((f) => {
            f.addEventListener("submit",() => {
                const btns = f.querySelectorAll("button")
                btns.forEach((btn) => {
                   btn.disabled = true;
                   btn.innerText = "Traitement en cours..."
                });
            })
        })
    })();
})