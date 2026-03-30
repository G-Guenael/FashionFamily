const content = document.getElementById("content");
const baseUrl = document.getElementById("header").dataset.baseUrl;

async function initCharts() {
  const response = await fetch(`${baseUrl}/admin/stats`);
  if (!response.ok) return;

  const { articles, users } = await response.json();

  new Chart(document.getElementById("chart-articles"), {
    type: "bar",
    data: {
      labels: articles.map((r) => r.month),
      datasets: [
        {
          label: "Articles ajoutés",
          data: articles.map((r) => Number(r.count)),
          backgroundColor: "#0e1422",
          borderRadius: 4,
        },
      ],
    },
    options: {
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
    },
  });

  new Chart(document.getElementById("chart-users"), {
    type: "bar",
    data: {
      labels: users.map((r) => r.month),
      datasets: [
        {
          label: "Utilisateurs inscrits",
          data: users.map((r) => Number(r.count)),
          backgroundColor: "#c0392b",
          borderRadius: 4,
        },
      ],
    },
    options: {
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
    },
  });
}

async function loadPage(page) {
  try {
    content.innerHTML = "<p>Chargement...</p>";

    const response = await fetch(`${baseUrl}/admin/${page}`);
    if (!response.ok) throw new Error(response.status);

    content.innerHTML = await response.text();

    if (page === "dashboard") initCharts();
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
