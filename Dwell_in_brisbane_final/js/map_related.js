// increment and decrement counter when favs added.
let count = 0;
const button = document.getElementById("increment");
const button2 = document.getElementById("decrement");
const textHolder = document.getElementById("count");
textHolder.innerHTML = count;

// Map Page related 
// get and insert busstop data into an array;
var busstops = [];

function iterateBusStops(results) {

    var recordTemplate = $(".record-template");

    $.each(results.result.records, function(recordID, recordValue) {

        var recordLocation = recordValue["STREET_NAME"];
        var recordDesc = recordValue["DESCRIPTION"];
        var recordLatitude = recordValue["LATITUDE"];
        var recordLongitude = recordValue["LONGITUDE"];
        var recordSuburb = recordValue["SUBURB"];
        var record_id = recordValue["_id"];

        if (recordLocation && recordDesc && recordLatitude && recordLongitude && recordSuburb && recordID) {

            var recordIDInt = parseInt(record_id);

            if (recordIDInt != 189 && recordIDInt != 190) {
                var clonedRecordTemplate = recordTemplate.clone();
                clonedRecordTemplate.attr("id", "record-" + recordID).removeClass("record-template");
                clonedRecordTemplate.appendTo("#records");

                var temp_array = [];
                var recordLongitudeInt = parseFloat(recordLongitude);
                var recordLatitudeInt = parseFloat(recordLatitude);

                temp_array.push(recordLatitudeInt);
                temp_array.push(recordLongitudeInt);
                temp_array.push(recordLocation);
                
                busstops.push(temp_array);
            }
            
        }

    });
}

// get and insert park data into an array;
var parks = [];

function iterateParks(results) {

    console.log(results);

    var recordTemplate = $(".record-template");

    $.each(results.result.records, function(recordID, recordValue) {

        var parkName = recordValue["PARK_NAME"];
        var parkLatitude = recordValue["LAT"];
        var parkLongitude = recordValue["LONG"];
        var park_id = recordValue["_id"];

        if (parkName && parkLatitude && parkLongitude && recordID) {

            var parkIDInt = parseInt(park_id);

            if (parkIDInt) {
                var clonedRecordTemplate = recordTemplate.clone();
                clonedRecordTemplate.attr("id", "record-" + recordID).removeClass("record-template");
                clonedRecordTemplate.appendTo("#records");

                var temp_array = [];
                var recordLongitudeInt = parseFloat(parkLongitude);
                var recordLatitudeInt = parseFloat(parkLatitude);

                temp_array.push(recordLatitudeInt);
                temp_array.push(recordLongitudeInt);
                temp_array.push(parkName);
                
                parks.push(temp_array);
            }
            
        }

    });
}

// get and insert artworks data into an array;
var artworks = [];

function iterateArtworks(results) {

    var recordTemplate = $(".record-template");

    $.each(results.result.records, function(recordID, recordValue) {

        var itemTitle = recordValue["Item_title"];
        var itemArtist = recordValue["Artist"];
        var itemLatitude = recordValue["Latitude"];
        var itemLongitude = recordValue["Longitude"];
        var record_id = recordValue["_id"];

        if (itemTitle && itemArtist && itemLatitude && itemLongitude && recordID) {

            var recordIDInt = parseInt(record_id);

            if (recordIDInt) {
                var clonedRecordTemplate = recordTemplate.clone();
                clonedRecordTemplate.attr("id", "record-" + recordID).removeClass("record-template");
                clonedRecordTemplate.appendTo("#records");

                var temp_array = [];
                var recordLongitudeInt = parseFloat(itemLongitude);
                var recordLatitudeInt = parseFloat(itemLatitude);

                temp_array.push(recordLatitudeInt);
                temp_array.push(recordLongitudeInt);
                temp_array.push(itemTitle);
                
                artworks.push(temp_array);
            } 
        }

    });
}


/**
 * Ability to add and show Multiple layers of markers
 * Ability to remove all layers
 * Centering on a specific layer.
 */

// config map
let config = {
    minZoom: 5,
    maxZoom: 18,
};
// magnification with which the map will start
const zoom = 13;
// center the map to this poitn
const lat = -27.470125;
const lng = 153.021072;

// const recreationcenters = [
//     [-27.461713, 153.025034, 'Jetts Lutwyche'],
//     [-27.463577, 153.016196, 'Kangaroo Point Cliffs Park'],
//     [-27.466013, 153.028488, 'BOUNCEinc Tingalpa'],
//     [-27.460971, 153.019864, 'SANDBAG Inc'],
//     [-27.470504, 153.036575, 'Multicultural Community Centre'],
//     [-27.468753, 153.008966, 'Clem Jones Centre'],
//     [-27.462854, 153.021730, 'YMCA Fitness'],
//     [-27.470294, 153.024026, 'Brisbane Grammar School Indoor Sports Centre'],
//     [-27.464776, 153.017096, 'Cultivate Calm Yoga'],
//     [-27.463672, 153.012935, 'Brisbane Headache and Migraine Clinic'],
//     [-27.461541, 153.032928, 'BodyLife Studio'],
//     [-27.464224, 153.012291, 'Fitstop Stafford'],
//     [-27.465328, 153.018813, 'Fit 4 Life Health Clubs'],
//     [-27.466451, 153.036339, 'Wivenhoe dam'],
//     [-27.462340, 153.025742, 'BodySmart Health - Paddington'],
//     [-27.468353, 153.028037, 'Youth Justice Service Centre'],
//     [-27.466660, 153.007615, 'KAILO Wellness Medispa'],
//     [-27.470504, 153.025141, 'Fabulous Pilates and Yoga'],
//     [-27.459979, 153.006420, 'QCCC Brookfield'],
//     [-27.466008, 153.025302, 'Colmslie Recreation Reserve'],
//     [-27.468502, 153.044550, 'Dutton Park Recreation Hub'],
//     [-27.461896, 153.043005, 'Riverlife Adventure Centre'],
//     [-27.458716, 153.039250, 'Lumber Punks Axe Throwing Brisbane'],
//     [-27.463438, 153.005497, 'Colleges Crossing Recreation Reserve'],
//     [-27.464523, 153.042297, '48 Hour Brisbane']
// ];

// const schools = [
//     [-27.467916, 153.021237, 'Yugumbir State School'],
//     [-27.467631, 153.027158, 'Mabel Park State School'],
//     [-27.465899, 153.020551, 'Collingwood Park State School'],
//     [-27.466622, 153.016882, 'Acacia Ridge State School'],
//     [-27.464874, 153.023769, 'Aspley Special School'],
//     [-27.468430, 153.026150, 'Blackstone State School'],
//     [-27.465043, 153.014179, 'Tingalpa State School'],
//     [-27.471132, 153.027802, 'Kedron State High School'],
//     [-27.461503, 153.011026, 'Blair State School'],
//     [-27.467935, 153.034967, 'Redland Bay State School'],
//     [-27.471341, 153.016368, 'Laceys Creek State School'],
//     [-27.46150, 153.023340, 'Strathpine State Infants School'],
//     [-27.461287, 153.027315, 'Cedar College'],
//     [-27.472370, 153.025195, 'Brisbane Grammar School'],
//     [-27.458699, 153.029272,'Bald Hills State School']
//     [-27.457101, 153.025828,'Bardon State School'],
//     [-27.458886, 153.029143,'Berrinba East State School'],
//     [-27.477624, 153.020904,'Boondall State School'],
//     [-27.469508, 153.023793, 'Bracken Ridge State School'],
//     [-27.463330, 153.007893, 'Hendra State School'],
//     [-27.464491, 153.030783, 'Morayfield East State School'],
//     [-27.468126, 153.036618, 'Sandgate State School'],
//     [-27.460704, 153.013621, 'Wynnum West State School'],
//     [-27.469953, 153.029325, 'Mount Gravatt State High School'],
//     [-27.463863, 153.026321, 'Caboolture Special School'],
//     [-27.470637, 153.007422, 'Our Lady Help of Christians School'],
//     [-27.460647, 153.028788, 'Sandgate Special School'],
//     [-27.468791, 153.028917, 'Lindum State School'],
//     [-27.465233, 153.017525, 'Woody Point Special School']
// ];

// calling map
const map = L.map('map', config).setView([lat, lng], zoom);

// Used to load and display tile layers on the map
// Most tile servers require attribution, which you can set under `Layer`
L.tileLayer('https://api.mapbox.com/styles/v1/kurrodu/cjx2vplwm05qd1crze3fuan8d/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoia3Vycm9kdSIsImEiOiJja3R3bHh4MDcya3hrMnlwbnU2MmtqdDd0In0.y9XiuOAaoVi-LnvLxS3TdA', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);



// Ability to add a marker on a map by clicking - Starts here
// Inspired from example - 
//Source: https://github.com/tomik23/leaflet-examples/tree/master/18.add-move-and-delete-marker

map.on('click', addMarker);

function addMarker(e) {
    // Add marker to map at the clicked location
    const markerPlace = document.querySelector('.marker-position');
    markerPlace.textContent = `new marker: ${e.latlng.lat}, ${e.latlng.lng}`;

    const marker = new L.marker(e.latlng, {
            icon: iconHeart,
            draggable: true,
        })
        .addTo(map)
        .bindPopup(buttonRemove);

    // event to be able to remove a marker
    marker.on('popupopen', removeMarker);

    // // event to be able to drag a marker
    marker.on('dragend', dragMaker);

    //increase fav counter
    textHolder.innerHTML = ++count;
}

// Ability to add a marker on a map by clicking - Ends here

const buttonRemove =
    '<button type="button" class="remove"> Delete Favorite 💔</button>';

const markerPlace = document.querySelector('.marker-position');

// Function to remove marker 
function removeMarker() {
    const marker = this;
    const btn = document.querySelector('.remove');
    btn.addEventListener('click', function() {
        markerPlace.textContent = 'That location was purged';
        map.removeLayer(marker);
        textHolder.innerHTML = --count;
    });

    //decrease fav counter


}
// Some code inspiration from : https://github.com/tomik23/leaflet-examples/tree/master/04.many-markers
// Function to add ablilty to drag a marker
function dragMaker() {
    markerPlace.textContent = `change position: ${this.getLatLng().lat}, ${this.getLatLng().lng
    }`;
}

// Extended `LayerGroup` that makes it easy
// to do the same for all layers of its members
const pA = new L.FeatureGroup();
const pB = new L.FeatureGroup();
const pC = new L.FeatureGroup();
const allMarkers = new L.FeatureGroup();

// Custom icons for Bus, Recreation center and school - Starts here
iconBus = L.divIcon({
    className: 'custom-div-icon',
    html: "<div style='background-color:#82BB12;' class='marker-pin'></div><i class='material-icons'>directions_bus</i>",
    iconSize: [30, 42],
    iconAnchor: [15, 42]
});

iconRecreation = L.divIcon({
    className: 'custom-div-icon',
    html: "<div style='background-color:#0F86BD;' class='marker-pin'></div><i class='material-icons'>sports_soccer</i>",
    iconSize: [30, 42],
    iconAnchor: [15, 42]
});

iconSchool = L.divIcon({
    className: 'custom-div-icon',
    html: "<div style='background-color:#E3553B;' class='marker-pin'></div><i class='material-icons'>school</i>",
    iconSize: [30, 42],
    iconAnchor: [15, 42]
});

iconHeart = L.divIcon({
    className: 'custom-div-icon',
    html: "<div style='background-color:#E3553B;' class='marker-pin'></div><i class='material-icons'>favorite</i>",
    iconSize: [30, 42],
    iconAnchor: [15, 42]
});


// Custom icons for Bus, Recreation center and school - Ends here


setTimeout(function() {

    // adding markers to the layer busstops
    for (let i = 0; i < busstops.length; i++) {
        marker = L.marker([busstops[i][0], busstops[i][1]], {
            icon: iconBus
        });
        pA.addLayer(marker.bindPopup(busstops[i][2]));
    }

    // adding markers to the layer parks
    for (let i = 0; i < parks.length; i++) {
        marker = L.marker([parks[i][0], parks[i][1]], {
            icon: iconRecreation
        });
        pB.addLayer(marker.bindPopup(parks[i][2]));
    }

    // adding markers to the layer artworks
    for (let i = 0; i < artworks.length; i++) {
        marker = L.marker([artworks[i][0], artworks[i][1]], {
            icon: iconSchool
        });
        pC.addLayer(marker.bindPopup(artworks[i][2]));
    }
}, 3000);


$(document).ready(function() {
    var busData = {
        resource_id: "0c4fda19-f96a-4174-a821-be6dad2e45cf",
        limit: 2000
    }

    $.ajax({
        url: "https://www.data.brisbane.qld.gov.au/data/api/3/action/datastore_search",
        data: busData,
        dataType: "jsonp", // We use "jsonp" to ensure AJAX works correctly locally (otherwise it'll be blocked due to cross-site scripting).
        cache: true,
        success: function(results) {
            iterateBusStops(results);
        }
    });

    var parkData = {
        resource_id: "2c8d124c-81c6-409d-bffb-5761d10299fe",
        limit: 500
    }

    $.ajax({
        url: "https://www.data.brisbane.qld.gov.au/data/api/3/action/datastore_search",
        data: parkData,
        dataType: "jsonp", 
        cache: true,
        success: function(results) {
            iterateParks(results);
        }
    });

    var artData = {
        resource_id: "3c972b8e-9340-4b6d-8c7b-2ed988aa3343",
        limit: 500
    }

    $.ajax({
        url: "https://www.data.brisbane.qld.gov.au/data/api/3/action/datastore_search",
        data: artData,
        dataType: "jsonp", 
        cache: true,
        success: function(results) {
            iterateArtworks(results);
        }
    });

});



// object with layers
const overlayMaps = {
    'Bus Stops': pA,
    'Parks': pB,
    'Artworks': pC,
    'Remove all layers': allMarkers,
};

// The layers control gives users the ability to switch
// between different base layers and switch overlays on/off
L.control
    .layers(null, overlayMaps, {
        collapsed: false,
    })
    .addTo(map);

// Show scale on left bottom corner https://leafletjs.com/reference-1.7.1.html#control-scale 
L.control
    .scale({
        imperial: false,
    })
    .addTo(map);



// show current location on map - starts here

var user_location = [];
console.log(user_location);

map
    .locate({
        // https://leafletjs.com/reference-1.7.1.html#locate-options-option
        setView: true,
        enableHighAccuracy: true,
    })
    // if location found show marker and circle
    .on('locationfound', (e) => {
        console.log(e);
        user_location.push(e.latitude);
        user_location.push(e.longitude);
        // marker
        const marker = L.marker([e.latitude, e.longitude]).bindPopup(
            'Your are here :)'
        );
        // circle
        const circle = L.circle([e.latitude, e.longitude], e.accuracy / 2, {
            weight: 2,
            color: 'red',
            fillColor: 'red',
            fillOpacity: 0.1,
        });
        // add marker
        map.addLayer(marker);
        // add circle
        map.addLayer(circle);
    })
    // if error show alert
    .on('locationerror', (e) => {
        console.log(e);
        alert('Location access denied.');
    });


// show current location on map - Ends here



// centering a group of markers
map.on('layeradd layerremove', function () {
    // Create new empty bounds
    var bounds = new L.LatLngBounds();
    // Iterate the map's layers
    map.eachLayer(function (layer) {
        // Check if layer is a featuregrouple
        if (layer instanceof L.FeatureGroup) {
            // Extend bounds with group's bounds
            bounds.extend(layer.getBounds());
        }
    });

    // Set last checkbox in control to false
    const lastCheckboxs = document.querySelectorAll(
        '.leaflet-control-layers-selector'
    );
    lastCheckboxs[lastCheckboxs.length - 1].checked = false;

    // Check if bounds are valid (could be empty)
    if (bounds.isValid()) {
        // Valid, fit bounds
        // map.flyToBounds(bounds); 
        // No, set view to current user location with nearby pins visible
        map.setView(user_location, 15);
    } else {
        // Invalid, fit world
        // map.fitWorld();
    }
});

// Remove all layer from map when click
// on 'Remove all layer' checkbox
overlayMaps['Remove all layers'].on('add', function (e) {
    const allOverlay = Object.keys(overlayMaps).reduce((obj, key) => {
        if (key !== 'Remove all layers') {
            obj[key] = overlayMaps[key];
        }
        return obj;
    }, {});

    setTimeout(function () {
        for (let overlay in allOverlay) {
            map.removeLayer(overlayMaps[overlay]);
        }
    }, 0);
});