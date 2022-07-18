<!--begin::Scrolltop-->
<script src="/common/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<script>
    let editorsArr = [];
    if(document.getElementsByClassName("custom_ck_editor")){
       var head = document.getElementsByTagName('body')[0];

        var js = document.createElement("script");

        // js.type = "text/javascript";
        // js.src = "/common/plugins/custom/ckeditor/ckeditor-classic.bundle.js";
        // head.appendChild(js);
            let editorElements = document.getElementsByClassName('custom_ck_editor');

            for (let index = 0; index < editorElements.length; index++) {

                let nameOfElement = editorElements[index].getAttribute('name');
                const element = editorElements[index];

                ClassicEditor.create(element)
                    .then(newEditor => {
                        editorsArr[nameOfElement] = newEditor;
                    }).catch(error => {
                        console.error(error);
                    });
                //console.log(index,nameOfElement);

            }
}
</script>
