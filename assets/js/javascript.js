var dongda_street, result;
$('#document').ready(function () {
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

	//Các đường đi củas quận Đống Đa
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
	map.on('singleclick', function (evt) {
		if (startPoint.getGeometry() == null) {
			// First click.
			startPoint.setGeometry(new ol.geom.Point(evt.coordinate));
			// $('#txtPoint1').val(evt.coordinate);
		}
		//  else if (destPoint.getGeometry() == null) {
		// 	// Second click.
		// 	destPoint.setGeometry(new ol.geom.Point(evt.coordinate));
		// 	$('#txtPoint2').val(evt.coordinate);
		// }
	});
	$('#btnSolve').click(function () {
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
	$('#btnReset').click(function () {
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
			success: function (result, status, erro) {
				// alert(result);
				$('.info-school-content').html(result);
			},
			error: function (req, status, error) {
				alert(req + ' ' + status + ' ' + error);
			},
		});
	} else $('#test').text('chưa chọn');
}
