import { createHeader, initHeader } from "../../components/header/header.js";

window.addEventListener("DOMContentLoaded", () => {
  const headerPlaceholder = document.getElementById("header");
  const header = createHeader();

  if (headerPlaceholder) {
    headerPlaceholder.replaceWith(header);
  } else {
    document.body.prepend(header);
  }

  initHeader(header);
});
