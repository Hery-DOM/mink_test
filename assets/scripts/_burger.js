document.addEventListener("DOMContentLoaded",() => {
    (() => {
      const burger = document.querySelector("#js-burger-btn");

      if(!burger) return null;

      burger.addEventListener("click",() => {
        const target = document.querySelector("#js-burger-menu");

        target.classList.toggle("open-mobile");
      });

    })();
});