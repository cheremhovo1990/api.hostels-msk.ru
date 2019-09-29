<script>
    (function () {
        let selectors = {
            'image-add-all': '#js-image-add-all',
            'add-image': '.js-add-image',
            'image-container': '#js-image-container',
            'copy': '.js-copy'
        };
        $(selectors['image-add-all']).click(function (e) {
            e.preventDefault();
            $(selectors['add-image']).each(function (index, element) {
                $(element).trigger('click');
            });
        });
        $(selectors['add-image']).on('click', function (e) {
            e.preventDefault();
            let img = document.querySelector($(this).data('target'));
            var xhr = new XMLHttpRequest();
            xhr.open("GET", img.src);
            xhr.responseType = "blob";
            xhr.onload = function () {
                blob = xhr.response;
                let formData = new FormData();
                formData.append('image', blob);
                axios.post($(selectors['image-container']).data('url'), formData, function (response) {
                    if (response.data.success) {
                        $.gritter.add('Success');
                    }
                });
            };
            xhr.send();
        });
        $(selectors['copy']).on('click', function (e) {
            let self = $(this);
            e.preventDefault();
            $(self.data('target')).val(self.data('content'));
        });
    })();
    ymaps.ready(function () {
        function Map() {
            this.selectors = {
                'lodge-latitude': '#lodge-latitude',
                'lodge-longitude': '#lodge-longitude',
            };
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
            if (($(this.selectors['lodge-latitude']).val() != '') && ($(this.selectors['lodge-longitude']).val() != '')) {
                let coordinates = [
                    $(this.selectors['lodge-latitude']).val(),
                    $(this.selectors['lodge-longitude']).val()
                ];
                self.createMap('lodge-map', coordinates);
            }
            $('.js-coordinates-copy').on('click', function (e) {
                e.preventDefault();
                let coordinates = $('#detail-map').data('coordinates');
                $(self.selectors['lodge-latitude']).val(coordinates[0]);
                $(self.selectors['lodge-longitude']).val(coordinates[1]);
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
</script>
