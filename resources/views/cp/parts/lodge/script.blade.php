<script>
    let selectors = {
        'add-schema-org-opening-hours': '#add-input-opening-hours-schema',
        'container-for-opening-hours-schema': '#container-for-opening-hours-schema',
        'delete-input-opening-hours-schema': '.delete-input-opening-hours-schema',
        'station-distance': '#js-lodge-station-distance',
        'show-station-distance': '#js-show-station-distance',
        'latitude': '#lodge-latitude',
        'longitude': '#lodge-longitude',
        'distance': '#lodge-distance',
        'district': '#js-button-district',
        'district-view': '#js-district-view',
        'button-municipality': '#js-button-municipality',
        'municipality-view': '#js-municipality-view',
        'announce': '#lodge-announce',
        'description-generate': '#js-description-generate',
        'description': '#lodge-description',
        'generate-text': '.js-generate-text'
    };
    $(selectors['add-schema-org-opening-hours']).click(function (e) {
        e.preventDefault();
        let input = $(this).data('html');
        let container = $(selectors['container-for-opening-hours-schema']);
        if (container.find('.form-group').length < 7) {
            container.append($(input));
        }
    });
    $(document).on('click', selectors['delete-input-opening-hours-schema'], function (e) {
        e.preventDefault();
        $(this).closest('.form-group').remove();
    });
    $(selectors['station-distance']).on('click', function (event) {
        event.preventDefault();
        let latitude = $(selectors['latitude']).val();
        let longitude = $(selectors['longitude']).val();
        let distance = $(selectors['distance']).val();
        if (latitude != '' && longitude != '') {
            let url = '/cp/api/station-by-coordinates/lat/' + latitude + '/lon/' + longitude + '/dist/' + distance;
            $.get(url, function (html) {
                $(selectors['show-station-distance']).html(html);
            });
        }
    });
    $(selectors['district']).on('click', function (event) {
        event.preventDefault();
        let latitude = $(selectors['latitude']).val();
        let longitude = $(selectors['longitude']).val();
        if (latitude != '' && longitude != '') {
            let url = '/cp/api/administrative-district/lat/' + latitude + '/lon/' + longitude;
            $.get(url, function (html) {
                $(selectors['district-view']).html(html);
            });
        }
    });
    $(selectors['description-generate']).on('click', function (e) {
        e.preventDefault();
        $.get(this.href, function (response) {
            if (response.success) {
                $(selectors['description']).data('editor').setData(response.text)
            }
        });
    });
    $(selectors['button-municipality']).on('click', function (event) {
        event.preventDefault();
        let latitude = $(selectors['latitude']).val();
        let longitude = $(selectors['longitude']).val();
        if (latitude != '' && longitude != '') {
            let url = '/cp/api/municipality/lat/' + latitude + '/lon/' + longitude;
            $.get(url, function (html) {
                $(selectors['municipality-view']).html(html);
            });
        }
    });
    $(selectors['generate-text']).click(function (e) {
        let self = $(this);
        e.preventDefault();
        axios.get(self.data('url')).then(function (response) {
            let content = response.data;
            if (content.success) {
                $.gritter.add({title: 'Success'});
                $(self.data('target')).data('editor').setData(content.text);
            } else {
                $.gritter.add({title: 'Fail'});
            }
        });
    });
    (function () {
        // image
        let selectors = {
            'images.store': '#js-input-lodge-images',
            'tab-image': 'a[href="#tab-image"]',
            'image-destroy': '.js-image-destroy',
            'image-container': '#image-container',
            'image-main': '.js-image-main',
        };

        function renderImages() {
            let container = $(selectors['image-container']);
            axios.get(container.data('url')).then(function (response) {
                container.html(response.data);
            });
        }

        $(document).on('click', selectors['image-destroy'], function (e) {
            e.preventDefault();
            axios.delete(this.href).then(function (response) {
                if (response.data.success) {
                    renderImages();
                }
            });
        });
        $(document).on('change', selectors['image-main'], function (e) {
            axios.post($(this).data('url')).then(function (response) {
                if (response.data.success) {
                    renderImages();
                }
            });
        });
        document.querySelector('#js-input-lodge-images').addEventListener('change', function () {
            let formData = new FormData();
            for (let i = 0; i < this.files.length; i++) {
                formData.append('images[]', this.files.item(i))
            }
            axios.post(this.form.action, formData)
                .then(function (response) {
                    if (response.data.success) {
                        $.gritter.add('Success');
                        renderImages();
                    }
                });
        });
        $(selectors['tab-image']).on('shown.bs.tab', function (e) {
            renderImages();
        });
    })();
</script>
