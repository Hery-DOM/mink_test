document.addEventListener("DOMContentLoaded",() => {
    (() => {

        let form = document.querySelector('#js-pictures-add-form');
        let fileDropArea = form.querySelector('#file-label');
        let fileInput = form.querySelector('#files');
        let previewBox = form.querySelector('#js-pictures-drop-box');


        fileDropArea.addEventListener('dragover',(e) => {
            e.preventDefault();
        })

        fileDropArea.addEventListener('drop',(e) => {
            e.preventDefault();

            let files = e.dataTransfer.files;

            addFileTreatment(files);
        });

        fileInput.addEventListener('change',(e) => {
            e.preventDefault();

            let files = fileInput.files;

            addFileTreatment(files,true);
        });


        let addFileTreatment = (fileList,inputChange=false) => {

            let dataTransfer = new DataTransfer();

            /** Add files currently in input **/
            let oldList = fileInput.files;
            [...oldList].forEach((f) => {
                dataTransfer.items.add(f);
            });

            /** Add files from fileList **/
            if(!inputChange) {
                [...fileList].forEach((f) => {
                    dataTransfer.items.add(f);
                });
            }

            /** Add in input file **/
            fileInput.files = dataTransfer.files;

            /** Preview **/
            let html = "";
            let formats = ["image/png", "image/jpeg","image/jpg"];
            [...fileInput.files].forEach(( file, key) => {
                let urlTemp = URL.createObjectURL(file);


                /* Create HTML */
                if(formats.includes(file.type)){
                    html +=
                        '<div class="meli-width-20" style="min-width: 90px;" id="line-fromjs-'+key+'">' +
                            '<img src="'+urlTemp+'" alt="'+urlTemp+'" class="" >' +
                        '</div>' ;
                }else{
                    alert(`Pour information, les images au format autres que jpeg / png ne peuvent pas être chargées`);
                }


            })

            previewBox.innerHTML = "";
            previewBox.innerHTML = html;


        }

    })();
});