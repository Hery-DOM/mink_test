document.addEventListener("DOMContentLoaded",() => {

    if(!document.querySelector(".selectType")){
        return null;
    }

    (() => {
        $('.js-select-M').select2();
    })();


    (() => {
        const selectType = $("select.selectType");
        const selectBreed = $("select.selectBreed");

        function updateOptions(){

            if(selectType.val().length === 0){
                return;
            }

            $("select.selectBreed option").each((key,option) => {
                if(!selectType.val().includes(option.dataset.type)){
                    option.setAttribute("disabled","disabled");
                }else{
                    option.removeAttribute("disabled");
                }
            })
        }


        updateOptions();

        selectType.on("change",() => {

            selectBreed.val(null).trigger("change");


            updateOptions();



        })
    })();
});