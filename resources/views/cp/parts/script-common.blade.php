<script>
    (function () {
        let selectors = {
            'editors': '.ckeditor-editor'
        };
        let editorsElement = document.querySelectorAll(selectors.editors);
        editorsElement.forEach(function (editor) {
            $(editor).data('editor', ClassicEditor
                .create(editor)
                .then(function (instance) {
                    $(editor).data('editor', instance);
                })
                .catch(error => {
                    console.error(error);
                }));

        });
        $('.js-phone-mask').inputmask("+7(999)999-99-99");
    })();
</script>
