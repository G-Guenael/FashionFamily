import { createHeader, initHeader } from "../../components/header/header.js";

window.addEventListener("DOMContentLoaded", () => {
  const headerPlaceholder = document.getElementById("header");
  const isLoggedIn = headerPlaceholder?.dataset.loggedIn === '1';
  const header = createHeader(isLoggedIn);

  if (headerPlaceholder) {
    headerPlaceholder.replaceWith(header);
  } else {
    document.body.prepend(header);
  }

  initHeader(header);
});
