var road_split, result;
$('#document').ready(function () {
	var format = 'image/png';
	var map;
	// Giới hạn khu vực
	var minX = 105.671539306641;
	var minY = 20.8914451599121;
	var maxX = 105.982925415039;
	var maxY = 21.186128616333;
	// Căn hình giữa màn
	var cenX = (minX + maxX) / 2;
	var cenY = (minY + maxY) / 2;
	var mapLat = cenY;
	var mapLng = cenX;
	var mapDefaultZoom = 6;
	//Điểm bắt đầu
	var startPoint = new ol.Feature();
	//Điểm kết thúc
	var destPoint = new ol.Feature();
	// Vùng bao
	var bounds = [minX, minY, maxX, maxY];
	road_split = new ol.layer.Image({
		source: new ol.source.ImageWMS({
			url: 'http://localhost:8080/geoserver/geoserver_demo/wms',
			params: {
				FORMAT: format,
				VERSION: '1.1.1',
				STYLES: '',
				LAYERS: 'road_split',
			},
		}),
	});
	var projection = new ol.proj.Projection({
		code: 'EPSG:4326',
		units: 'degrees',
		axisOrientation: 'neu',
	});
	var view = new ol.View({
		projection: projection,
	});
	map = new ol.Map({
		target: 'map',
		layers: [road_split],
		view: view,
	});
	//map.getView().fitExtent(bounds, map.getSize());
	map.getView().fit(bounds, map.getSize());
	var vectorLayer = new ol.layer.Vector({
		source: new ol.source.Vector({
			features: [startPoint, destPoint],
		}),
	});
	map.addLayer(vectorLayer);
	map.on('singleclick', function (evt) {
		if (startPoint.getGeometry() == null) {
			// First click.
			startPoint.setGeometry(new ol.geom.Point(evt.coordinate));
			$('#txtPoint1').val(evt.coordinate);
		} else if (destPoint.getGeometry() == null) {
			// Second click.
			destPoint.setGeometry(new ol.geom.Point(evt.coordinate));
			$('#txtPoint2').val(evt.coordinate);
		}
	});
	$('#btnSolve').click(function () {
		var startCoord = startPoint.getGeometry().getCoordinates();
		var destCoord = destPoint.getGeometry().getCoordinates();
		var params = {
			LAYERS: 'route',
			FORMAT: 'image/png',
		};
		var viewparams = [
			'x1:' + startCoord[0],
			'y1:' + startCoord[1],
			+'x2:' + destCoord[0],
			'y2:' + destCoord[1],
		];
		params.viewparams = viewparams.join(';');
		result = new ol.layer.Image({
			source: new ol.source.ImageWMS({
				url: 'http://localhost:8080/geoserver/geoserver_demo/wms',
				params: params,
			}),
		});
		map.addLayer(result);
	});
	$('#btnReset').click(function () {
		startPoint.setGeometry(null);
		destPoint.setGeometry(null);
		// Remove the result layer.
		map.removeLayer(result);
	});
});
