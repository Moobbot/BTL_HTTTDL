<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Openlayers test</title>
    <meta charset="utf-8">
    <title>OpenStreetMap &amp; OpenLayers - Marker Example</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
    <style>
        .map,
        .righ-panel {
            height: 500px;
            width: 40%;
            float: left;
        }

        .map {
            border: 1px solid #000;
        }
    </style>
    <script type="text/javascript">
        var split, result;
        $("#document").ready(function() {
            var startPoint = new ol.Feature();
            var destPoint = new ol.Feature();
            var format = 'image/png';
            var bounds = [105.671539306641, 20.8914451599121,
                105.982925415039, 21.186128616333
            ];
            split = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    url: 'http://localhost:8080/geoserver/btl/wms',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'split',
                    }
                })
            });
            var projection = new ol.proj.Projection({
                code: 'EPSG:4326',
                units: 'degrees',
                axisOrientation: 'neu'
            });
            var view = new ol.View({
                projection: projection
            });
            var map = new ol.Map({
                target: 'map',
                layers: [
                    split
                ],
                view: view
            });
            //map.getView().fitExtent(bounds, map.getSize());
            map.getView().fit(bounds, map.getSize());
            var vectorLayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [startPoint, destPoint]
                })
            });
            map.addLayer(vectorLayer);
            map.on('singleclick', function(evt) {
                if (startPoint.getGeometry() == null) {
                    // First click.
                    startPoint.setGeometry(new ol.geom.Point(evt.coordinate));
                    $("#txtPoint1").val(evt.coordinate);
                } else if (destPoint.getGeometry() == null) {
                    // Second click.
                    destPoint.setGeometry(new ol.geom.Point(evt.coordinate));
                    $("#txtPoint2").val(evt.coordinate);
                }
            });
            $("#btnSolve").click(function() {
                var startCoord = startPoint.getGeometry().getCoordinates();
                var destCoord = destPoint.getGeometry().getCoordinates();
                var params = {
                    LAYERS: 'route2',
                    FORMAT: 'image/png'
                };
                var viewparams = [
                    'x1:' + startCoord[0], 'y1:' + startCoord[1],
                    'x2:' + destCoord[0], 'y2:' + destCoord[1]
                ];
                params.viewparams = viewparams.join(';');
                result = new ol.layer.Image({
                    source: new ol.source.ImageWMS({
                        url: 'http://localhost:8080/geoserver/btl/wms',
                        params: params
                    })
                });
                map.addLayer(result);
            });
            $("#btnReset").click(function() {
                startPoint.setGeometry(null);
                destPoint.setGeometry(null);
                // Remove the result layer.
                map.removeLayer(result);
            });
        });
    </script>
</head>

<body>
    <div id="map" class="map"></div>
    <div class="righ-panel">
        <input type="text" id="txtPoint1" />
        <br />
        <input type="text" id="txtPoint2" />
        <br />
        <button id="btnSolve">Tìm đường</button>
        <button id="btnReset">Xóa đường</button>
    </div>
</body>

</html>