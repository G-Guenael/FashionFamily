// console.log("JS chargé !");

const content = document.getElementById("content");

async function loadPage(page) {
  try {
    content.innerHTML = "<p>Chargement...</p>";


    const response = await fetch(`pages/${page}.html`);
    const data = await response.text();

    content.innerHTML = data;
    if (page === "dashboard") {
      initDashboard();
    }
  } catch (error) {
    content.innerHTML = "<h1>Erreur de chargement</h1>";
  }
}

document.querySelectorAll(".sidebar a").forEach((link) => {
  link.addEventListener("click", () => {
    // Remove active class from all items
    document.querySelectorAll(".sidebar nav ul li").forEach((li) => {
      li.classList.remove("active");
    });

    // Add active class to clicked item
    link.closest("li").classList.add("active");

    const page = link.dataset.page;
    loadPage(page);
  });
});

loadPage("dashboard");

// Set dashboard as active by default
document.querySelector('.sidebar a[data-page="dashboard"]').closest("li").classList.add("active");

// --------------------------Graphique--------------------------

// Injecter valeurs
function initDashboard() {
  const data = {
    sales: 4.235,
    orders: 734,
    revenue: 12450,
    customers: 180,    
  };

  const salesEl = document.getElementById("sales");

  if (salesEl) {
    salesEl.textContent = `${data.sales} €`;
  };

  const customersEl = document.getElementById("customers");

  if (customersEl) {
    customersEl.textContent = `${data.customers}`;
  };

  const ordersEl = document.getElementById("orders");

  if (ordersEl) {
    ordersEl.textContent = `${data.orders}`;
  }
}


