export function createFooter() {
  const footer = document.createElement("footer");
  footer.classList.add("footer");

  const isInPageDir = location.pathname.includes("/page/");
  const base = isInPageDir ? "../" : "./";

  footer.innerHTML = `
  <div class="footer_container">
  <div class="footer_left">
    <div class="footer_logo">
      <img src="${base}img/Logomark.png" alt="Logo Fashion Family" />
      <h3>Fashion Family</h3>
    </div>
    <div class="footer_txt">
      <p>DevCut is a YouTube channel for practical project-based learning.</p>
    </div>

  </div>
</div>
    `;

  return footer;
}
