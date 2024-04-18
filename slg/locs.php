<!DOCTYPE html>
<html lang='en'>
   <head>
      <title>Find Location</title>
      <meta charset='utf-8' />
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" rel="stylesheet" type="text/css">
     <script>
       mapboxgl.accessToken = 'sk.eyJ1IjoiZGV2eWFuc2hpMTUwOSIsImEi0iJjbHVwamJ1aGswaWVqMmpyOWZnMmQ3NjIzIn@.sTnYdu75_qfL1BHxyYIymA';

       function initMap() {
         const maps = new mapboxgl.Map({
           container: 'maps',
           style: 'mapbox://styles/mapbox/streets-v11',
           center: [72.913277, 20.391897],
           zoom: 16
         });

         var geocoder = new MapboxGeocoder({
           accessToken: mapboxgl.accessToken,
           mapboxgl: mapboxgl
         });

         maps.addControl(geocoder);
       }
       
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [2.3399, 48.8555],
        zoom: 12
    });

    const distanceContainer = document.getElementById('distance');

    // GeoJSON object to hold our measurement features
    const geojson = {
        'type': 'FeatureCollection',
        'features': []
    };

    // Used to draw a line between points
    const linestring = {
        'type': 'Feature',
        'geometry': {
            'type': 'LineString',
            'coordinates': []
        }
    };

    map.on('load', () => {
        map.addSource('geojson', {
            'type': 'geojson',
            'data': geojson
        });

        // Add styles to the map
        map.addLayer({
            id: 'measure-points',
            type: 'circle',
            source: 'geojson',
            paint: {
                'circle-radius': 5,
                'circle-color': '#000'
            },
            filter: ['in', '$type', 'Point']
        });
        map.addLayer({
            id: 'measure-lines',
            type: 'line',
            source: 'geojson',
            layout: {
                'line-cap': 'round',
                'line-join': 'round'
            },
            paint: {
                'line-color': '#000',
                'line-width': 2.5
            },
            filter: ['in', '$type', 'LineString']
        });

        map.on('click', (e) => {
            const features = map.queryRenderedFeatures(e.point, {
                layers: ['measure-points']
            });

            // Remove the linestring from the group
            // so we can redraw it based on the points collection.
            if (geojson.features.length > 1) geojson.features.pop();

            // Clear the distance container to populate it with a new value.
            distanceContainer.innerHTML = '';

            // If a feature was clicked, remove it from the map.
            if (features.length) {
                const id = features[0].properties.id;
                geojson.features = geojson.features.filter(
                    (point) => point.properties.id !== id
                );
            } else {
                const point = {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [e.lngLat.lng, e.lngLat.lat]
                    },
                    'properties': {
                        'id': String(new Date().getTime())
                    }
                };

                geojson.features.push(point);
            }

            if (geojson.features.length > 1) {
                linestring.geometry.coordinates = geojson.features.map(
                    (point) => point.geometry.coordinates
                );

                geojson.features.push(linestring);

                // Populate the distanceContainer with total distance
                const value = document.createElement('pre');
                const distance = turf.length(linestring);
                value.textContent = `Total distance: ${distance.toLocaleString()}km`;
                distanceContainer.appendChild(value);
            }

            map.getSource('geojson').setData(geojson);
        });
    });

    map.on('mousemove', (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: ['measure-points']
        });
        // Change the cursor to a pointer when hovering over a point on the map.
        // Otherwise cursor is a crosshair.
        map.getCanvas().style.cursor = features.length
            ? 'pointer'
            : 'crosshair';
    });

     </script>
      <link rel="shortcut icon" href="map.pnga" type="image/x-icon">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      
      <style type="text/css"> 
            body 
            { margin: 0; padding: 0; }
            #map 
            { position: absolute; top: 0; bottom: 0; width: 100%; }

         a:hover{
         cursor: pointer;
         text-decoration: unset;
         }

         .heading_anchor{
            background: #8142b1 !important; 
            color: #fff !important;
         }

         .define_height{
             height: 450px;
         }
         .distance-container {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 1;
    }

    .distance-container > * {
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 11px;
        line-height: 18px;
        display: block;
        margin: 0;
        padding: 5px 10px;
        border-radius: 3px;
    }


      </style>
   </head>
   <body onload="initMap()">
      <div class='navbar navbar-default navbar-static-top heading_anchor'>
      
         <div class='container-fluid'>
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class='navbar-brand heading_anchor' href='#'>Search on Map</a>
            </div>
            <div class="navbar-collapse collapse">
               <ul class="nav navbar-nav navbar-right">
                  <li class='active'>
                     <a href=""  class="heading_anchor">Search path between two locations...</a>
                  </li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
      </div>
      <div class='container-fluid'>
         <div class='row'>
            <div class='col-md-4'>
               <p>Welcome to SEARCH ON MAP Panel, Just Enter your origin point and your Destination where you want to  go.</p>
               <div class='well define_height'>
                  <form id="distance_form">
                     <div class="form-group">
                        <label>Enter Origin</label>
                        <input class="form-control" id="from_places" placeholder="Enter Origin"/>
                        <inputid="origin" name="origin" required="" type="hidden"/>
                        <a onclick="getCurrentPosition()">Set Current Location</a>
                     </div>
                     <div class="form-group">
                        <label>Enter Destination</label>
                        <input class="form-control" id="to_places" placeholder="Enter Destination"/>
                        <input id="destination" name="destination" required="" type="hidden"/>
                     </div>
                     <div id="distance" class="distance-container"></div>
                     <input class="btn btn-primary" type="submit" value="Find" style="background: #8142b1; width: 100%; border: 0px;" />
                  </form>
                  <div class="row" style="padding-top: 20px;">
                     <div class="container">
                        <p id="in_mile"></p>
                        <p id="in_kilo"></p>
                        <p id="duration_text"></p>
                     </div>
                  </div>
               </div>
            </div>
            <div class='col-md-8'>
               <noscript>
                  <div class='alert alert-info'>
                     <h4>Your JavaScript is disabled</h4>
                     <p>Please enable JavaScript to view the map.</p>
                  </div>
               </noscript>
               <div id="map" style="height: 500px; width: 100%" ></div>
            </div>
         </div>
      </div>
      <script src="maps1.js"></script>
   </body>
</html>