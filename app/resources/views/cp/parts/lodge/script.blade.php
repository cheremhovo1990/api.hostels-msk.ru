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
</script>