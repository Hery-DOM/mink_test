document.addEventListener("DOMContentLoaded",() => {
    (() => {
      const formToConfirm = document.querySelectorAll(".js-form-confirm");

      formToConfirm.forEach((f) => {
          f.addEventListener("submit",(e) => {
              e.preventDefault();
              if(confirm("Voulez-vous vraiment exécuter cette tâche ?")){
                  f.submit();
              }
          })
      })
    })();
});