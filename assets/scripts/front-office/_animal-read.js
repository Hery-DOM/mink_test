document.addEventListener("DOMContentLoaded",() => {
    (() => {
      const carousel = $(".owl-carousel");

      if(!carousel) return null;

      carousel.owlCarousel({
          loop: true,
          items: 1,
          nav: true
      });

    })();
});