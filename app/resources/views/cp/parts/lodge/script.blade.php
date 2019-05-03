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
        'announce-generate': '#js-announce-generate',
        'announce': '#lodge-announce',
        'description-generate': '#js-description-generate',
        'description': '#lodge-description',
        'lodge-preview-image': '#js-lodge-preview-image',
        'lodge-image-upload': '#js-lodge-image-upload',
        'image-button-modal': '#js-image-button-modal',
        'image-destroy': '.js-image-destroy',
        'input-lodge-images': '#js-input-lodge-images'
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
    $(selectors['announce-generate']).on('click', function (e) {
        e.preventDefault();
        $.get(this.href, function (response) {
            if (response.success) {
                $(selectors['announce']).data('editor').setData(response.text)
            }
        });
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
    $(selectors['lodge-image-upload']).on('show.bs.modal', function () {
        $(selectors['lodge-preview-image']).html('');
        renderModalBody();
    });
    $(document).on('click', selectors['image-destroy'], function (e) {
        e.preventDefault();
        axios.delete(this.href).then(function () {
            renderModalBody();
        });
    });
    $(selectors['input-lodge-images']).on('change', function () {
        let formData = new FormData();
        for (let i = 0; i < this.files.length; i++) {
            formData.append('images[]', this.files.item(i))
        }
        axios.post(this.form.action, formData)
            .then(function () {
                renderModalBody();
            });
    });

    function renderModalBody() {
        $.get($(selectors['image-button-modal']).data('url-images'), function (html) {
            $(selectors['lodge-preview-image']).html(html);
        });
    }
</script>