<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>The first webgis: View Layer From Geoserver On Background Map</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="mystyle.css">

</head>

<body onload="initialize_map();">
    <div class="option">
        <table>
            <tr>
                <td>
                    <div id="map"></div>
                </td>
                <td>
                    <a href="1_ViewBackgroundMap.php">View 1</a>
                </td>
                <td>
                    <a href="index.php">Home</a>
                </td>
            </tr>
        </table>
    </div>
    <script>
    var format = 'image/png';
    var map;
    // Layers -> Chọn Layers cần hiện(Đến trang Edit Layer) -> Bounding Boxes
    var minX = 16.805793762207;
    var minY = 47.7233352661133;
    var maxX = 22.5965824127197;
    var maxY = 49.6232109069824;
    //
    var cenX = (minX + maxX) / 2;
    var cenY = (minY + maxY) / 2;
    var mapLat = cenY;
    var mapLng = cenX;
    var mapDefaultZoom = 6;

    function initialize_map() {
        //*
        layerBG = new ol.layer.Tile({
            source: new ol.source.OSM({})
        });
        //*/
        var layerCMR_adm1 = new ol.layer.Image({
            source: new ol.source.ImageWMS({
                ratio: 1,
                url: 'http://localhost:8080/geoserver/geoserver_demo/wms?',
                params: {
                    'FORMAT': format,
                    'VERSION': '1.1.1',
                    STYLES: '',
                    LAYERS: 'gadm41_svk_2',
                }
            })
        });
        var viewMap = new ol.View({
            center: ol.proj.fromLonLat([mapLng, mapLat]),
            zoom: mapDefaultZoom
            //projection: projection
        });
        map = new ol.Map({
            target: "map",
            layers: [layerBG, layerCMR_adm1],
            //layers: [layerCMR_adm1],
            view: viewMap
        });
    };
    </script>
</body>

</html>