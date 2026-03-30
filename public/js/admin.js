const content = document.getElementById("content");
const baseUrl = document.getElementById("header").dataset.baseUrl;

async function loadPage(page) {
  try {
    content.innerHTML = "<p>Chargement...</p>";

    const response = await fetch(`${baseUrl}/admin/${page}`);
    if (!response.ok) throw new Error(response.status);

    content.innerHTML = await response.text();
  } catch (error) {
    content.innerHTML = "<p>Erreur de chargement.</p>";
  }
}

document.querySelectorAll(".sidebar a").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    loadPage(link.dataset.page);
  });
});

loadPage("dashboard");
