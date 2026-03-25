export function createNewsLetter() {
  const section = document.createElement("section");
  section.classList.add("newsletter");

  section.innerHTML = `
    <div class="newsletter_container">
      <div class="newsletter_title">
        <h3>Join our Newsletter</h3>
        <p>We love to surprise our subscribers with occasional gifts.</p>
      </div>
      <div class="newsletter_input">
        <label for="email" class="visually-hidden">Email</label>
        <input id="email" type="email" placeholder="Votre email" required>
        <button>Subscribe</button>
      </div>
    </div>
  `;

  return section;
}