/* For sidebar remember previous state */
$.AdminLTESidebarTweak = {};

$.AdminLTESidebarTweak.options = {
    EnableRemember: true,
    NoTransitionAfterReload: true
    //Removes the transition after page reload.
};

$(function () {
    "use strict";

    $("body").on("collapsed.pushMenu", function () {
        if ($.AdminLTESidebarTweak.options.EnableRemember) {
            localStorage.setItem("toggleState", "closed");
        }
    });

    $("body").on("expanded.pushMenu", function () {
        if ($.AdminLTESidebarTweak.options.EnableRemember) {
            localStorage.setItem("toggleState", "opened");
        }
    });

    if ($.AdminLTESidebarTweak.options.EnableRemember) {
        var toggleState = localStorage.getItem("toggleState");
        if (toggleState == 'closed') {
            if ($.AdminLTESidebarTweak.options.NoTransitionAfterReload) {
                $("body").addClass('sidebar-collapse hold-transition').delay(100).queue(function () {
                    $(this).removeClass('hold-transition');
                });
            } else {
                $("body").addClass('sidebar-collapse');
            }
        }
    }
});

/* For select2 */
if($.fn.modal != undefined) {
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
}

function showMapResult(result, latitude_key, longitude_key) {
    var latitude = result.geometry.location.lat();
    var longitude = result.geometry.location.lng();
    $('[name='+latitude_key+']').val(latitude);
    $('[name='+longitude_key+']').val(longitude);
}

function getLatitudeLongitude(callback, address, latitude_key, longitude_key) {
    // If adress is not supplied, use default value 'Noida, Uttar Pradesh, India'
    address = address || 'Noida, Uttar Pradesh, India';
    // Initialize the Geocoder
    geocoder = new google.maps.Geocoder();
    if (geocoder) {
        geocoder.geocode({
            'address': address
        }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                callback(results[0], latitude_key, longitude_key);
            }
        });
    }
}

function initAutoCompleteAddressPicker(target) {
    var autocomplete = new google.maps.places.Autocomplete(target, {});
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        if(typeof place.geometry !== undefined)
        {
            if(place.geometry.location !== undefined) {
                var location = place.geometry.location.toJSON();
                $('[name="latitude"]').val(location.lat);
                $('[name="longitude"]').val(location.lng);
            }
        }
    });
}

/*****================== Address Picker With Google Map Start =============**/
var marker, geocoder;
function initAutocomplete(mapBoxID, searchBoxID, addrField, latField, lngField, defLat, defLng) {
    if(defLat === undefined)
    {
        defLat = 24.8026162;
    }

    if(defLng === undefined)
    {
        defLng = 46.60391000000004;
    }
    var defLatLng = new google.maps.LatLng(defLat, defLng);
    geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById(mapBoxID), {
        center: defLatLng,
        zoom: 13,
        mapTypeId: 'roadmap',
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById(searchBoxID);
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function (marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            marker = new google.maps.Marker({
                map: map,
                title: place.name,
                position: place.geometry.location,
                draggable: true,
            });
            // Create a marker for each place.
            markers.push(marker);
            updateMarkerPosition(marker.getPosition(), latField, lngField);
            geocodePosition(marker.getPosition(), addrField);

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }

            google.maps.event.addListener(marker, 'drag', function () {
                updateMarkerPosition(marker.getPosition(), latField, lngField);
            });

            google.maps.event.addListener(marker, 'dragend', function () {
                geocodePosition(marker.getPosition(), addrField);
                map.panTo(marker.getPosition());
            });

            google.maps.event.addListener(map, 'click', function (e) {
                updateMarkerPosition(e.latLng, latField, lngField);
                geocodePosition(marker.getPosition(), addrField);
                marker.setPosition(e.latLng);
                map.panTo(marker.getPosition());
            });
        });
        map.fitBounds(bounds);
    });

    
}

function geocodePosition(pos, addrField) {
    geocoder.geocode({
        latLng: pos
    }, function (responses) {
        if (responses && responses.length > 0) {
            updateMarkerAddress(responses[0].formatted_address, addrField);
        } else {
            updateMarkerAddress('', addrField);
        }
    });
}

function updateMarkerPosition(latLng, latField, lngField) {
    $(`[name=${latField}]`).val(latLng.lat());
    $(`[name=${lngField}]`).val(latLng.lng());
}

function updateMarkerAddress(str, addrField) {
    $(`[name=${addrField}]`).val(str);
}
/*****================== Address Picker With Google Map End =============**/

function active_current_url()
{
    var removeLastElement = false;
    var current_url = window.location.href;
    var pathname = current_url.split('/');
    if($(pathname).last()[0])
    {
        if($.isNumeric($(pathname).last()[0]))
        {
            removeLastElement = true;
        }
    }
    var segmentArr = [];
    if(pathname.length)
    {
        $.each(pathname, function(index, value) {
            if(!$.isNumeric(value)){
                segmentArr.push(value);
            }
        })
    }
    if(removeLastElement)
    {
        segmentArr.splice(-1,1);
    }
    current_url = segmentArr.join('/');
    var findAllLink = $('ul.sidebar-menu').find('a');
    if(findAllLink.length)
    {
        $.each(findAllLink, function(index, value){
            var href = $(this).attr('href');
            if(current_url == href)
            {
                $(this).parent('li').addClass('active');
            }
        });
        var $this = $('ul.sidebar-menu').find('li.active');
        $this.parentsUntil(".sidebar-menu").addClass('open active');
    }
}
active_current_url();

function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit, allowDismiss, timer = 1000) {
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    $.notifyClose();

    $.notify({
        message: text
    },
    {
        type: colorName,
        allow_dismiss: allowDismiss,
        newest_on_top: true,
        timer: timer,
        placement: {
            from: placementFrom,
            align: placementAlign
        },
        animate: {
            enter: animateEnter,
            exit: animateExit
        },
        template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}
