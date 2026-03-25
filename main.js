import { createHeader, initHeader } from "./components/header/header.js";
import { createNewsLetter } from "./components/newsletter.js/newsLetter.js";
import { createFooter } from "./components/footer/footer.js";

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


window.addEventListener("DOMContentLoaded", () => {
  const newsPlaceHolder = document.getElementById("newsletter");
  const newsLetter = createNewsLetter();

  const main = document.querySelector("main"); // récupère le <main>

  if (newsPlaceHolder) {
    newsPlaceHolder.replaceWith(newsLetter); // si placeholder existe
  } else if (main) {
    main.appendChild(newsLetter); // <-- clé : ajoute **à la fin du main**
  } else {
    document.body.appendChild(newsLetter); // fallback si pas de main
  }
});

window.addEventListener("DOMContentLoaded", ()=>{
  const footerPlaceHolder = document.getElementById("footer")
  const footer = createFooter()

  if (footerPlaceHolder) {
    footerPlaceHolder.replaceWith(footer);
  } else {
    document.body.prepend(footer);
  }
})