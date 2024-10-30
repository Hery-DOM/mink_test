document.addEventListener("DOMContentLoaded",() => {
    (() => {

      if(document.querySelectorAll(".owl-carousel").length === 0) return null;

      const carousel = $(".owl-carousel");

      carousel.owlCarousel({
          loop: true,
          items: 1,
          nav: true
      });

    })();
});