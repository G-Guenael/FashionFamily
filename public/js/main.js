import { createHeader, initHeader } from "../components/header/header.js";
import { createNewsLetter } from "../components/newsletter.js/newsLetter.js";
import { createFooter } from "../components/footer/footer.js";

window.addEventListener("DOMContentLoaded", () => {
  // HEADER
  const headerPlaceholder = document.getElementById("header");
  const isLoggedIn = headerPlaceholder?.dataset.loggedIn === "1";
  const baseUrl = headerPlaceholder?.dataset.baseUrl ?? "";
  const header = createHeader(isLoggedIn, baseUrl);

  if (headerPlaceholder) {
    headerPlaceholder.replaceWith(header);
  } else {
    document.body.prepend(header);
  }

  initHeader(header);
});
