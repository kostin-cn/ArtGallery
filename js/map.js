/**
 * Created by Hexagen on 24.11.2016.
 */

let map;
// координаты карты
let coord = document.getElementById('coordinates');
let coord_lat = coord.dataset.lat;
let coord_lng = coord.dataset.lng;
let coord_title = coord.dataset.title;
let coord_zoom = parseInt(coord.dataset.zoom);
// let oz_sale = new google.maps.LatLng(58.841424,57.554011);
let oz_sale = new google.maps.LatLng(coord_lat,coord_lng);

const MY_MAPTYPE_ID = 'custom_style';

function initialize() {
    const featureOpts = [
        {
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        },
        {
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#616161"
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#f5f5f5"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#bdbdbd"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#eeeeee"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#757575"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e5e5e5"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#ffffff"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#757575"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#dadada"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#616161"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#e5e5e5"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#eeeeee"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#c9c9c9"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#9e9e9e"
                }
            ]
        }
    ];
    let mapOptions = {
        zoom: coord_zoom,
        center: oz_sale,
        scrollwheel: false,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
        },
        mapTypeId: MY_MAPTYPE_ID
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    let styledMapOptions = {
        name: coord_title
    };

    const contentString = '<h2 class="map-marker">'+coord_title+'<h2>';

    let infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    let icon = {
        path: "M25,1A22.6,22.6,0,0,0,2.5,23.6c0,12.2,20.9,33.8,21.8,34.7l.7.7.7-.7c.9-.9,21.8-22.5,21.8-34.7A22.6,22.6,0,0,0,25,1Zm-.1,11.1A11.4,11.4,0,1,1,13.6,23.5,11.4,11.4,0,0,1,24.9,12.1Z",
        fillColor: '#1a1e27',
        fillOpacity: .9,
        anchor: new google.maps.Point(23, 50),
        strokeWeight: 0,
        scale: 1
    };

    let marker = new google.maps.Marker({
        position: oz_sale,
        map: map,
        icon: icon,
        title: coord_title
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    let customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
    map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}
// initialize();