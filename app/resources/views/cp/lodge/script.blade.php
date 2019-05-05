<script>
    let selection = {
        'map': '#map',
        'latitude': '#lodge-latitude',
        'longitude': '#lodge-longitude',
        'search': '#js-search-map',
        'address': '#lodge-address',
        'address-error': '#js-lodge-address-error',
        'city': '#lodge-city'
    };
    ymaps.ready(function () {
        let latitude = parseFloat($(selection['latitude']).val());
        let longitude = parseFloat($(selection['longitude']).val());
        let zoom = 15;
        if (isNaN(latitude) || isNaN(longitude)) {
            latitude = 55.76;
            longitude = 37.64;
            zoom = 10;
        }
        let map = new ymaps.Map('map', {
            'center': [latitude, longitude],
            'zoom': zoom,
        });
        $(selection['map']).prop('map', map);
        var placemark = new ymaps.Placemark([latitude, longitude], {}, {draggable: true});
        placemark.events.add('dragend', function (e) {
            let coordinates = e.get('target').geometry.getCoordinates();
            $(selection['latitude']).val(coordinates[0]);
            $(selection['longitude']).val(coordinates[1]);
        });
        map.geoObjects.add(placemark);
        $(selection['map']).prop('placemark', placemark);
        map.events.add('click', function (e) {
            console.log(e);
            let coordinates = e.get('coords');

            $(selection['latitude']).val(coordinates[0]);
            $(selection['longitude']).val(coordinates[1]);
            let placemark = $(selection['map']).prop('placemark');
            placemark.geometry.setCoordinates(coordinates);
        })
    });
    $(selection['search']).on('click', function (e) {
        e.preventDefault();
        let address = $(selection['address']).val();
        if (address === '') {
            return;
        }
        let city_id = $(selection['city']).val();
        let city = $(selection['city'] + ' [value="' + city_id + '"]').html();
        let fullAddress = city + ', ' + address;
        ymaps.geocode(fullAddress).then(function (response) {
            if (response.geoObjects.getLength() > 1) {
                let coordinates = response.geoObjects.get(0).geometry.getCoordinates();
                let placemark = $(selection['map']).prop('placemark');
                let map = $(selection['map']).prop('map');
                placemark.geometry.setCoordinates(coordinates);
                map.setCenter(coordinates);
            } else {
                $(selection['address-error']).html('нет результата');
            }
        })
    });

</script>