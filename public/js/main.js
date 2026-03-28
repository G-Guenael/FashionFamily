import { createHeader, initHeader } from "../components/header/header.js";
import { createNewsLetter } from "../components/newsletter.js/newsLetter.js";
import { createFooter } from "../components/footer/footer.js";

window.addEventListener("DOMContentLoaded", () => {
  // HEADER
  const headerPlaceholder = document.getElementById("header");
  const isLoggedIn = headerPlaceholder?.dataset.loggedIn === "1"; // lit data-logged-in (camelCase auto par le navigateur)
  const header = createHeader(isLoggedIn);

  if (headerPlaceholder) {
    headerPlaceholder.replaceWith(header);
  } else {
    document.body.prepend(header);
  }

  initHeader(header);

  // NEWSLETTER (optionnelle)
  const newsPlaceHolder = document.getElementById("newsletter");
  if (newsPlaceHolder) {
    const newsLetter = createNewsLetter();
    newsPlaceHolder.replaceWith(newsLetter);
  }

  // FOOTER (optionnel)
  const footerPlaceHolder = document.getElementById("footer");
  if (footerPlaceHolder) {
    const footer = createFooter();
    footerPlaceHolder.replaceWith(footer);
  }
});
