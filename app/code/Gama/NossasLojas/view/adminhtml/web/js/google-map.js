
require([
    'jquery',
    'mage/translate'
], function(
    $
) {
    var Map = {
        googleMap: null,
        geocoder: null,
        marker: null,
        infoWindow: null,
        active: false,
        opts: {
            center: {
                lat: 0.0,
                lng: 0.0
            },
            zoom: 2
        },

        init: function()
        {
            var self = this,
                mapContainer = document.getElementById('google-map-container'),
                lat = $('input#lat'),
                lng = $('input#lng'),
                zoom = $('input#zoom');

            if($(mapContainer).length > 0)
            {
                self.active = true;
                self.googleMap = new google.maps.Map(mapContainer, self.opts);
                self.geocoder = new google.maps.Geocoder();
                self.marker = new google.maps.Marker({
                    position: self.opts.center,
                    map: self.googleMap,
                    draggable: true
                });

                self._on({
                    obj: self.marker,
                    event: 'dragend',
                    callback: function()
                    {
                        var position = self.marker.getPosition();
                        lat.val(position.lat());
                        lng.val(position.lng());
                    }
                });

                self._on({
                    obj: self.googleMap,
                    event: 'zoom_changed',
                    callback: function()
                    {
                        var zoomVal = self.googleMap.getZoom();
                        zoom.val(zoomVal);
                        self.opts.zoom = zoomVal;
                    }
                });

                self._on({
                    obj: self.googleMap,
                    event: 'click',
                    callback: function(event)
                    {
                        var position = event.latLng;
                        lat.val(position.lat());
                        lng.val(position.lng());
                        self.marker.setPosition(position);
                    }
                });
            }
        },

        setFields: function(inputsOnly)
        {
            var self = this,
                lat = $('input#lat'),
                lng = $('input#lng'),
                zoom = $('input#zoom');

            inputsOnly = (typeof inputsOnly == 'undefined') ? false : inputsOnly;

            if(!inputsOnly && lat.val() != '')
            {
                self.opts.center.lat = parseFloat(lat.val());
            }
            else
            {
                lat.val(self.opts.center.lat);
            }

            if(!inputsOnly && lng.val() != '')
            {
                self.opts.center.lng = parseFloat(lng.val());
            }
            else
            {
                lng.val(self.opts.center.lng);
            }

            if(!inputsOnly && zoom.val() != '')
            {
                self.opts.zoom = parseInt(zoom.val());
            }
            else
            {
                zoom.val(self.opts.zoom);
            }
        },

        centerMap: function()
        {
            var self = this;

            var latLng = new google.maps.LatLng(self.opts.center.lat, self.opts.center.lng);

            self.googleMap.setCenter(latLng);
            self.googleMap.setZoom(self.opts.zoom);
            self.marker.setPosition(latLng);
        },

        searchPositionByAddress: function()
        {
            var self = this,
                address = '',
                field_addr = $('#address').val(),
                field_city = $('#city').val();

            if(field_addr.length > 0)
            {
                address += field_addr;
            }
            if(field_city.length > 0)
            {
                address += ' ' + field_city;
            }

            if(address.length > 0)
            {
                self.geocoder.geocode(
                    {
                        'address': address
                    },
                    function(results, status)
                    {
                        if(status == google.maps.GeocoderStatus.OK)
                        {
                            var location = results[0].geometry.location;
                            self.opts.center.lat = location.lat();
                            self.opts.center.lng = location.lng();
                            self.googleMap.fitBounds(results[0].geometry.viewport);
                            self.centerMap();
                            self.setFields(true);
                        }
                    }
                );
            }
        },

        _on: function(opts)
        {
            var self = this;

            google.maps.event.addListener(opts.obj, opts.event, function(e)
            {
                opts.callback.call(self, e);
            });
        }
    };

    $(document).ready(function()
    {
        $('#store_search_by_address').val($.mage.__('Find Address On Map'));

        Map.setFields();

        $(document).on('change', 'input#lat', function()
        {
            Map.opts.center.lat = parseFloat($(this).val());
            Map.centerMap();
        });

        $(document).on('change', 'input#lng', function()
        {
            Map.opts.center.lng = parseFloat($(this).val());
            Map.centerMap();
        });

        $(document).on('change', 'input#zoom', function()
        {
            Map.opts.zoom = parseFloat($(this).val());
            Map.centerMap();
        });

        $(document).on('click', '#store_search_by_address', function()
        {
            Map.searchPositionByAddress();
        });

        $(document).on('click', '#nossaslojas_stores_edit_tabs_map_info', function()
        {
            if(!Map.active)
            {
                Map.init();
            }
        })
    });
});
