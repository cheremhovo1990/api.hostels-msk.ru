<script>
    $(function () {
        let selectors = {
            'editors': '.ckeditor-editor'
        };
        let editors = document.querySelectorAll(selectors.editors);
        editors.forEach(function (editor) {
            ClassicEditor
                .create(editor)
                .then(function (instance) {
                    $(editor).data('editor', instance);
                })
                .catch(error => {
                    console.error(error);
                });

        });
        $('.js-phone-mask').inputmask("+7(999)999-99-99");
    });
</script>