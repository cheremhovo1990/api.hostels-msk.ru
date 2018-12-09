<script>
    (function () {
        let selectors = {
            'editors': '.ckeditor-editor'
        };
        let editors = document.querySelectorAll(selectors.editors);
        editors.forEach(function (editor) {
            ClassicEditor
                .create(editor)
                .catch(error => {
                    console.error(error);
                });
        })
    })();
    $(function () {
        $(this).on('click', '.delete-input-opening-hours-schema', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });
        $('#add-input-opening-hours-schema').click(function (e) {
            e.preventDefault();
            let input = $(this).data('html');
            if ($('#container-for-opening-hours-schema .form-group').length < 7) {
                $('#container-for-opening-hours-schema').append($(input));
            }
        });
        $('#js-image-add-all').click(function (e) {
            e.preventDefault();
            $('.js-add-image').each(function (index, element) {
                $(element).trigger('click');
            });
        });
        $('.js-add-image').on('click', function (e) {
            e.preventDefault();
            let img = document.querySelector($(this).data('target'));
            var xhr = new XMLHttpRequest();
            xhr.open("GET", img.src);
            xhr.responseType = "blob";
            xhr.onload = function () {
                blob = xhr.response;
                let formData = new FormData();
                formData.append('image', blob);
                axios.post($('#js-image-url').data('url'), formData);
            };
            xhr.send();
        });
        $(this).on('click', '.js-image-destroy', function (e) {
            e.preventDefault();
            axios.delete(this.href).then(function () {
                renderModalBody();
            });
        });
        $('#js-input-lodge-images').on('change', function () {
            let formData = new FormData();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('images[]', this.files.item(i))
            }
            axios.post(this.form.action, formData)
                .then(function () {
                    renderModalBody();
                });
        });
        $('#lodge-image-upload').on('show.bs.modal', function () {
            $('#lodge-preview-image').html('');
            renderModalBody();
        });
        $('#js-lodge-station-distance').on('click', function (event) {
            event.preventDefault();
            let latitude = $('#lodge-latitude').val();
            let longitude = $('#lodge-longitude').val();
            let distance = $('#lodge-distance').val();
            if (latitude != '' && longitude != '') {
                let url = '/cp/api/station-by-coordinates/lat/' + latitude + '/lon/' + longitude + '/dist/' + distance;
                $.get(url, function (html) {
                    $('#js-show-station-distance').html(html);
                });
            }
        });
        $('#js-button-district').on('click', function (event) {
            event.preventDefault();
            let latitude = $('#lodge-latitude').val();
            let longitude = $('#lodge-longitude').val();
            if (latitude != '' && longitude != '') {
                let url = '/cp/api/administrative-district/lat/' + latitude + '/lon/' + longitude;
                $.get(url, function (html) {
                    $('#js-district-view').html(html);
                });
            }
        });
        $('#js-button-municipality').on('click', function (event) {
            event.preventDefault();
            let latitude = $('#lodge-latitude').val();
            let longitude = $('#lodge-longitude').val();
            if (latitude != '' && longitude != '') {
                let url = '/cp/api/municipality/lat/' + latitude + '/lon/' + longitude;
                $.get(url, function (html) {
                    $('#js-municipality-view').html(html);
                });
            }
        });

        function renderModalBody() {
            $.get($('#js-image-button-modal').data('url-images'), function (html) {
                $('#lodge-preview-image').html(html);
            });
        }
    });
    ymaps.ready(function () {
        function Map() {
            this.mapDetail = null;
            this.mapLodge = null;
            this.lodge();
            this.detail();
        }

        Map.prototype.detail = function () {
            let id = 'detail-map';
            let coordinates = $('#' + id).data('coordinates');
            this.mapDetail = new ymaps.Map(id, {
                'center': coordinates,
                'zoom': 15,
                'controls': [],
            });
            let placemark = new ymaps.Placemark(coordinates);
            this.mapDetail.geoObjects.add(placemark);
        };
        Map.prototype.lodge = function () {
            self = this;
            $('.js-coordinates-copy').on('click', function () {
                let coordinates = $('#detail-map').data('coordinates');
                $('#lodge-latitude').val(coordinates[0]);
                $('#lodge-longitude').val(coordinates[1]);
                self.createMap('lodge-map', coordinates);
            });
        };
        Map.prototype.createMap = function (id, coordinates) {
            if (this.mapLodge != null) {
                this.mapLodge.destroy();
            }
            $('#' + id).css({'height': '200px'});
            this.mapLodge = new ymaps.Map(id, {
                'center': coordinates,
                'zoom': 15,
                'controls': [],
            });
            let placemark = new ymaps.Placemark(coordinates);
            this.mapLodge.geoObjects.add(placemark);
        };
        let map = new Map();
    });
    $('.js-phone-mask').inputmask("+7(999)999-99-99");
</script>