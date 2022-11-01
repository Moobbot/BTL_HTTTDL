<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bài tập lớn nhóm 3</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="assets/css/alter.css">
    <link rel="stylesheet" href="assets/css/template.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header id="header" class="header">
        <div class="header-container container">
            <div class="header-inner">
                <nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt=""
                                    class="img-fluid"></a>
                        </div>
                        <ul class="nav navbar-nav">
                            <li><a href="#search-map">Tìm đường</a></li>
                            <li><a href="#info-school">Thông tin trường đại học</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <div class="main-content">
        <div class="main-content-container">
            <div class="main-content-inner">
                <div id="search-map">
                    <div class="search-map-container container">
                        <div class="search-map-title">
                            <h2>Bản đồ khu vực Đống Đa</h2>
                        </div>
                        <div class="row search-map-inner">
                            <div class="search-map-left col-lg-8">
                                <div class="search-map-left-inner">
                                    <div id="map" class="map"></div>
                                </div>
                            </div>
                            <div class="search-map-right col-lg-4">
                                <div class="search-map-right-inner">
                                    <div class="option-wrap">
                                        <div class="option-content">
                                            <div class="option-inner">
                                                <label for="uni">Chọn trường đại học muốn đến:</label>
                                                <select name="uni" id="uni" onchange="uniChanged(this)">
                                                    <?php
                                                    // connect to postgresql
                                                    include('index_db.php');
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="search-btn">
                                            <button id="btnSolve">Tìm đường</button>
                                            <button id="btnReset">Xóa đường</button>
                                        </div>
                                        <div id="info-school">
                                            <div class="info-school-inner">
                                                <div class="info-school-title">
                                                    <h2>Thông tin</h2>
                                                </div>
                                                <div class="info-school-content">
                                                    <span>Thông tin trường Đại Học được chọn xuất hiện ở đây.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-manual">
                                        <ul>
                                            <li>Bước 1: Chọn trường đại học mong muốn</li>
                                            <li>Bước 2: Chọn điểm xuất phát trên bản đồ</li>
                                            <li>Bước 3: Nhấn nút tìm kiếm</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Trước khi chạy đổi đuôi các file txt sang js -->
<!-- <script src="assets/js/jquery-3.6.1.js"></script>
<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="assets/js/javascript.js"></script> -->
<script>
var dongda_street, result;
$('#document').ready(function() {
    var format = 'image/png';
    var map;
    // Giới hạn khu vực
    var minX = 105.79759979248;
    var minY = 20.9971103668213;
    var maxX = 105.842880249023;
    var maxY = 21.032262802124;
    // Căn hình giữa màn
    var cenX = (minX + maxX) / 2;
    var cenY = (minY + maxY) / 2;
    var mapLat = cenY;
    var mapLng = cenX;
    // var mapDefaultZoom = 14.5;
    //Điểm bắt đầu
    var startPoint = new ol.Feature();
    //Điểm kết thúc
    var destPoint = new ol.Feature();
    // Vùng bao
    var bounds = [minX, minY, maxX, maxY];

    layerBG = new ol.layer.Tile({
        source: new ol.source.OSM({}),
    });

    //Các đường đi của quận Đống Đa
    dongda_street = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://localhost:8080/geoserver/btl/wms',
            params: {
                FORMAT: format,
                VERSION: '1.1.1',
                STYLES: 'custom_road',
                LAYERS: 'dongda_street',
            },
        }),
    });

    //Các trường đại học, cao đẳng quận Đống Đa
    var dongda_univercity = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://localhost:8080/geoserver/btl/wms',
            params: {
                FORMAT: format,
                VERSION: '1.1.1',
                STYLES: 'custom_polygon',
                LAYERS: 'dongda_univercity',
            },
        }),
    });

    //Các trường đại học, cao đẳng quận Đống Đa -Tên
    var name = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://localhost:8080/geoserver/btl/wms',
            params: {
                FORMAT: format,
                VERSION: '1.1.1',
                STYLES: 'name',
                LAYERS: 'dongda_univercity',
                label: '${name}',
            },
        }),
    });

    //Vùng bao quận Đống Đa
    var dongda_boundary = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://localhost:8080/geoserver/btl/wms',
            params: {
                FORMAT: format,
                VERSION: '1.1.1',
                STYLES: 'custom_opacity',
                LAYERS: 'dongda_boundary',
            },
        }),
    });

    //
    var projection = new ol.proj.Projection({
        code: 'EPSG:4326',
        units: 'degrees',
        axisOrientation: 'neu',
    });

    //
    var view = new ol.View({
        center: ol.proj.fromLonLat([mapLng, mapLat]),
        // zoom: mapDefaultZoom,
        minZoom: 14,
        projection: projection,
    });

    //Map hiển thị
    map = new ol.Map({
        target: 'map',
        layers: [layerBG, dongda_boundary, dongda_street, dongda_univercity, name],
        view: view,
    });

    // map.getView().fitExtent(bounds, map.getSize());
    map.getView().fit(bounds, map.getSize());
    var vectorLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [startPoint, destPoint],
        }),
    });
    map.addLayer(vectorLayer);
    map.on('singleclick', function(evt) {
        if (startPoint.getGeometry() == null) {
            // First click.
            startPoint.setGeometry(new ol.geom.Point(evt.coordinate));
        }
    });
    $('#btnSolve').click(function() {
        var startCoord = startPoint.getGeometry().getCoordinates();
        // var destCoord = destPoint.getGeometry().getCoordinates();
        // get input val -> dest[0] & dest[1]
        var dest = $('#uni').val().split('-')[0];
        var dest = dest.split(' ');

        var params = {
            LAYERS: 'route',
            FORMAT: 'image/png',
            STYLES: 'custom_route',
        };
        var viewparams = [
            'x1:' + startCoord[0],
            'y1:' + startCoord[1],
            'x2:' + dest[0],
            'y2:' + dest[1],
        ];
        params.viewparams = viewparams.join(';');

        result = new ol.layer.Image({
            source: new ol.source.ImageWMS({
                url: 'http://localhost:8080/geoserver/btl/wms',
                params: params,
            }),
        });

        map.addLayer(result);
    });
    $('#btnReset').click(function() {
        startPoint.setGeometry(null);
        destPoint.setGeometry(null);
        // Remove the result layer.
        map.removeLayer(result);
    });
});

var gid;

function uniChanged(obj) {
    var value = obj.value;
    if (value != '') {
        value = value.split('-');
        var gid = value[1];
        $.ajax({
            type: 'POST',
            url: 'pgsqlAPI.php',
            data: {
                gid: gid,
            },
            success: function(result, status, erro) {
                // alert(result);
                $('.info-school-content').html(result);
            },
            error: function(req, status, error) {
                alert(req + ' ' + status + ' ' + error);
            },
        });
    } else $('#test').text('chưa chọn');
}
</script>

</html>