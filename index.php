<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bài tập lớn nhóm 3</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="assets/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
    <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
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
                            <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
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
                            <h2>Tìm kiếm</h2>
                        </div>
                        <div class="row search-map-inner">
                            <div class="search-map-left col-lg-8">
                                <div class="search-map-left-inner">
                                    <div id="map" class="map">


                                    </div>
                                </div>
                            </div>
                            <div class="search-map-right col-lg-4">
                                <div class="search-map-right-inner">
                                    <div class="option-wrap">
                                        <div class="righ-panel">
                                            <input type="text" id="txtPoint1" />
                                            <br />
                                            <input type="text" id="txtPoint2" />
                                            <br />
                                            <button id="btnSolve">Tìm đường</button>
                                            <button id="btnReset">Xóa đường</button>
                                        </div>
                                        <form action="/action_page.php" class="search-form">
                                            <div class="form-group">
                                                <label for="cars">Chọn trường đại học muốn đến:</label>
                                                <select name="cars" id="cars">
                                                    <option value="TLU">Đại học Thủy Lợi</option>
                                                    <option value="LDA">Đại học Công Đoàn</option>
                                                    <option value="VWA">Học viện Phụ nữ Việt Nam</option>
                                                    <option value="FBU">Học viện Ngân Hàng</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Submit">
                                            </div>
                                        </form>
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
                <div id="info-school">
                    <div class="info-school-container container">
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
            </div>
        </div>
    </div>
</body>
<script src="assets/js/jquery-3.6.1.js"></script>
<script src="assets/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="assets/js/javascript.js"></script>

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

</html>