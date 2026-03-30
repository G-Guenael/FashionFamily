const content = document.getElementById("content");

async function loadPage(page){
    try {
        content.innerHTML = "<p>Chargement...</p>";

        const response = await fetch(`pages/${page}.html`);
        const data = await response.text();

        content.innerHTML = data;
    } catch (error) {
        content.innerHTML = "<h1>Erreur de chargement</h1>"
    }
}

document.querySelectorAll(".sidebar a").forEach(link => {
    link.addEventListener("click", ()=> {
        const page = link.dataset.page
        loadPage(page)
    })
})

loadPage("dashboard")