<script>
    let selection = {
        'latitude': '#lodge-latitude',
        'longitude': '#lodge-longitude'
    };
    ymaps.ready(function () {
        let latitude = parseFloat($(selection['latitude']).val());
        let longitude = parseFloat($(selection['longitude']).val());
        if (latitude == '' && longitude == '') {

        }
        let map = new ymaps.Map('map', {
            'center': [latitude, longitude],
            'zoom': 15,
        });
        var placemark = new ymaps.Placemark([latitude, longitude], {}, {draggable: true});
        placemark.events.add('dragend', function (e) {
            let coordinates = e.get('target').geometry.getCoordinates();
            $(selection['latitude']).val(coordinates[0]);
            $(selection['longitude']).val(coordinates[1]);
        });
        map.geoObjects.add(placemark);
    });

</script>