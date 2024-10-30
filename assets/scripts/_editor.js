import {ClassicEditor, Essentials, Bold, Italic, Paragraph, Font, Heading} from "ckeditor5";
document.addEventListener("DOMContentLoaded",() => {

    (() => {
        const textareas = document.querySelectorAll("textarea");

        textareas.forEach((t) => {
            ClassicEditor.create(t,{
                plugins: [Essentials, Heading, Bold, Italic, Paragraph, Font],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'heading','fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            })

        })

    })();
});
