export function createFooter() {
  const footer = document.createElement("footer");
  footer.classList.add("footer");

  const isInPageDir = location.pathname.includes("/page/");
  const base = isInPageDir ? "../" : "./";

  footer.innerHTML = `
  <div class="footer_container">

    <div class="footer_left">
      <div class="footer_logo">
        <img src="./img/logo_footer.png" alt="Logo Fashion Family">
        <h3>Fashion Family</h3>
      </div>

      <p>DevCut is a YouTube channel for practical project-based learning.</p>

      <div class="footer_icon">
        <a href="#" aria-label="GitHub"><img src="./img/Github.png" alt=""></a>
        <a href="#" aria-label="Instagram"><img src="./img/Insta.png" alt=""></a>
        <a href="#" aria-label="YouTube"><img src="./img/Youtube.png" alt=""></a>
      </div>
    </div>

    <div class="footer_middle">

      <nav aria-label="Support">
        <h3>Support</h3>
        <ul>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Terms of use</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </nav>
  
      <nav aria-label="Company">
        <h3>Compagny</h3>
        <ul>
          <li><a href="#">About us</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Careers</a></li>
        </ul>
      </nav>
  
      <nav aria-label="Shop">
        <h3>Shop</h3>
        <ul>
          <li><a href="#">My Account</a></li>
          <li><a href="#">Checkout</a></li>
          <li><a href="#">Cart</a></li>
        </ul>
      </nav>
  
    </div>
   <div class="footer_right">
      <h3>Accepted Payments</h3>
      <div class="footer_container_payment">
        <img src="./img/MasterCard.png" alt="Mastercard">
        <img src="./img/AMEX.png" alt="American Express">
        <img src="./img/Visa.png" alt="Visa">
      </div>
    </div>
    
    </div>
    
    `;

  return footer;
}
