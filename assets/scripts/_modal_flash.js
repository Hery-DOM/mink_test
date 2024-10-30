document.addEventListener("DOMContentLoaded",() => {
    (() => {
      const  modalFlash = document.querySelector(".js-flash-modal");

      if(!modalFlash) return null;

      let closeModal = (modal) => {
          modal.style.opacity = "0";

          setTimeout(() => {
              modal.style.display = "none";
          },500);
      }


      modalFlash.addEventListener("click",(e) => {
          if(e.composedPath()[0] === modalFlash){
              closeModal(modalFlash);
          }
      });

      modalFlash.querySelector(".js-flash-close").addEventListener("click",() => {
          closeModal(modalFlash);
      })



    })();
});