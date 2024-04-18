<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Destination</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.2.0/mapbox-gl.js"></script>
<style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>

</head>
<body>

<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
<div id="map"></div>

<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoiZGV2eWFuc2hpMTUwOSIsImEiOiJjbHVwaXQ3Nnowc3hsMmttbmJmMmRkeTR0In0.ZSedJu5kboCT9ZKL1EZnKQ';
    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [73.169857,20.534951],
        zoom: 13
    });

    map.addControl(
        new MapboxDirections({
            accessToken: mapboxgl.accessToken
        }),
        'top-left'
    );
</script>
<script src="C:\xampp\htdocs\slg\mapbox-gl-directions.js"></script>
</body>

</html>