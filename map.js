﻿"use strict";

function mapInit(map){
	L.EditControl = L.Control.extend({
		options: {
			position: 'topright',
			callback: null,
			kind: '',
			html: ''
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Создать объект ' + this.options.kind;
			link.innerHTML = this.options.html;
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						currentEditingType = this.options.type;
						window.LAYER = this.options.callback.call(map.editTools);
					  }, this);
			
			return container;
		}
	});
	
	L.NewLineControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startPolyline,
			kind: 'линия',
			type: 'Polyline',
			html: '\\/\\'
		}
	});
	L.NewPolygonControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startPolygon,
			kind: 'полигон',
			type: 'Polygon',
			html: '▰'
		}
	});
	L.NewMarkerControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startMarker,
			kind: 'маркер',
			type: 'Marker',
			html: '🖈'
		}
	});
	L.NewCircleControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startCircle,
			kind: 'круг',
			type: 'Circle',
			html: '⬤'
		}
	});

	var mc = new L.NewMarkerControl();
	var lc = new L.NewLineControl();
	var pc = new L.NewPolygonControl();
	var cc = new L.NewCircleControl();

	L.NewMenuControl = L.Control.extend({
		options: {
			position: 'topright',
			callback: null,
			kind: 'Главное меню',
			imgsrc: 'images/logo.png'
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Главное меню';
			var img = cDom("IMG");
			img.src = this.options.imgsrc;
			img.style.width = "28px";
			link.appendChild(img);
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						frmMainSetVisibleTrue();
					  }, this);
		
			return container;
		}
	});
	map.addControl(new L.NewMenuControl);

	L.NewPainLayersControl = L.Control.extend({
		options: {
			position: 'topright',
			callback: frmPaintLayers.setVisible,
			kind: 'Слои на карте',
			imgsrc: 'images/layers.png'
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Слои на карте';
			var img = cDom("IMG");
			img.src = this.options.imgsrc;
			img.style.width = "20px";
			link.appendChild(img);
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						this.options.callback(true);
					  }, this);
		
			return container;
		}
	});
	map.addControl(new L.NewPainLayersControl);
	
	L.NewPaintControl = L.Control.extend({
		options: {
			position: 'topright',
			callback: enableControls,
			kind: 'рисование',
			imgsrc: 'images/paint.png'
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Режим редактирования';
			var img = cDom("IMG");
			img.src = this.options.imgsrc;
			img.style.width = "20px";
			link.appendChild(img);
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						isPaintMode = !isPaintMode;
						this.options.callback(map, [mc, lc, pc, cc], isPaintMode);
						if (!isPaintMode && currentEditing) currentEditing.disableEdit();

					  }, this);
		
			return container;
		}
	});
	/*if (getPolicy(["cO","cL"]))*/ map.addControl(new L.NewPaintControl);
	
	return	[
	]
}

function enableControls(map, controls, enable){
	if (controls && controls.length){
		controls.forEach(function(ctrl){
			if (enable) {
				map.addControl(ctrl)
			} else {
				ctrl.remove()
			}
		})
	}
}

var area1 = [{"lat":55.822915,"lng":37.669107},{"lat":55.829582,"lng":37.650997999999994},{"lat":55.834749,"lng":37.656318999999996},{"lat":55.839721000000004,"lng":37.662755},{"lat":55.84174900000001,"lng":37.665329},{"lat":55.84609400000001,"lng":37.670906},{"lat":55.842231000000005,"lng":37.678115000000005},{"lat":55.843776000000005,"lng":37.68189100000001},{"lat":55.84561000000001,"lng":37.68583900000001},{"lat":55.84715500000001,"lng":37.68841300000001},{"lat":55.84802400000001,"lng":37.69004200000001},{"lat":55.84879500000001,"lng":37.68884100000001},{"lat":55.84922800000001,"lng":37.68892500000001},{"lat":55.849421000000014,"lng":37.68798300000001},{"lat":55.85246200000002,"lng":37.69158700000001},{"lat":55.85255700000002,"lng":37.693216000000014},{"lat":55.85435800000002,"lng":37.68686500000001},{"lat":55.85537100000002,"lng":37.68746400000001},{"lat":55.85541800000002,"lng":37.688921000000015},{"lat":55.85589900000002,"lng":37.68934800000002},{"lat":55.85546600000002,"lng":37.69175100000002},{"lat":55.85450100000002,"lng":37.69338000000002},{"lat":55.85324600000002,"lng":37.69432200000002},{"lat":55.85218600000002,"lng":37.69415100000002},{"lat":55.851511000000016,"lng":37.69475000000002},{"lat":55.85006300000001,"lng":37.69449400000002},{"lat":55.84851800000001,"lng":37.69509300000002},{"lat":55.84818100000001,"lng":37.69689400000002},{"lat":55.84876000000001,"lng":37.70032700000002},{"lat":55.850256000000016,"lng":37.702299000000025},{"lat":55.85460100000002,"lng":37.702642000000026},{"lat":55.85691700000002,"lng":37.698781000000025},{"lat":55.85802500000002,"lng":37.700925000000026},{"lat":55.85865200000002,"lng":37.700498000000024},{"lat":55.86072600000002,"lng":37.70453000000003},{"lat":55.86086900000002,"lng":37.700326000000025},{"lat":55.85913300000002,"lng":37.69629400000002},{"lat":55.85947000000002,"lng":37.69552300000002},{"lat":55.861352000000025,"lng":37.698441000000024},{"lat":55.86168900000003,"lng":37.699555000000025},{"lat":55.861352000000025,"lng":37.700326000000025},{"lat":55.863378000000026,"lng":37.70435800000003},{"lat":55.863859000000026,"lng":37.70624600000003},{"lat":55.86545100000003,"lng":37.70761900000003},{"lat":55.86984100000003,"lng":37.71508500000003},{"lat":55.87301200000003,"lng":37.71894600000003},{"lat":55.87368700000003,"lng":37.71980400000003},{"lat":55.87310800000003,"lng":37.720833000000034},{"lat":55.87383100000003,"lng":37.721604000000035},{"lat":55.87291700000003,"lng":37.723920000000035},{"lat":55.87364000000003,"lng":37.72615100000004},{"lat":55.87368700000003,"lng":37.72752400000004},{"lat":55.87421600000003,"lng":37.72889700000004},{"lat":55.87469700000003,"lng":37.73035400000004},{"lat":55.874986000000035,"lng":37.73181100000004},{"lat":55.875467000000036,"lng":37.73121200000004},{"lat":55.87681700000004,"lng":37.731726000000045},{"lat":55.87797300000004,"lng":37.732927000000046},{"lat":55.87797300000004,"lng":37.73447100000005},{"lat":55.87946700000004,"lng":37.73601500000005},{"lat":55.88048000000004,"lng":37.73841800000005},{"lat":55.88100900000004,"lng":37.74760100000005},{"lat":55.88192300000004,"lng":37.767857000000056},{"lat":55.882741000000046,"lng":37.76794100000006},{"lat":55.883222000000046,"lng":37.77137400000006},{"lat":55.88553700000005,"lng":37.77111800000006},{"lat":55.88568000000005,"lng":37.76794400000006},{"lat":55.88746400000005,"lng":37.766228000000055},{"lat":55.888766000000054,"lng":37.77034700000006},{"lat":55.890164000000055,"lng":37.76957600000006},{"lat":55.890164000000055,"lng":37.76820300000006},{"lat":55.89161000000006,"lng":37.767689000000054},{"lat":55.89291200000006,"lng":37.76631600000005},{"lat":55.89223700000006,"lng":37.76176900000005},{"lat":55.89329700000006,"lng":37.76091100000005},{"lat":55.89281600000006,"lng":37.75541800000005},{"lat":55.89262500000006,"lng":37.75198500000005},{"lat":55.89440900000006,"lng":37.751814000000046},{"lat":55.89556500000006,"lng":37.751814000000046},{"lat":55.896577000000065,"lng":37.75250000000005},{"lat":55.89850400000007,"lng":37.75421600000005},{"lat":55.90154000000007,"lng":37.75824800000005},{"lat":55.90327300000007,"lng":37.76065100000005},{"lat":55.90510500000007,"lng":37.763225000000055},{"lat":55.90626100000007,"lng":37.765113000000056},{"lat":55.90741700000007,"lng":37.76863000000006},{"lat":55.907802000000075,"lng":37.76983100000006},{"lat":55.907062000000074,"lng":37.77352000000006},{"lat":55.90556800000007,"lng":37.778067000000064},{"lat":55.90494400000007,"lng":37.779868000000064},{"lat":55.90475300000007,"lng":37.78398700000007},{"lat":55.90509000000007,"lng":37.78724800000007},{"lat":55.90460900000007,"lng":37.78956400000007},{"lat":55.90176500000007,"lng":37.79119300000007},{"lat":55.900128000000066,"lng":37.79402400000007},{"lat":55.90099400000007,"lng":37.79513800000007},{"lat":55.90176500000007,"lng":37.79642400000007},{"lat":55.90176500000007,"lng":37.801402000000074},{"lat":55.90379000000007,"lng":37.80131800000007},{"lat":55.904608000000074,"lng":37.803977000000074},{"lat":55.90431900000007,"lng":37.80903900000008},{"lat":55.907211000000075,"lng":37.80929500000008},{"lat":55.91072800000008,"lng":37.80963800000008},{"lat":55.91072800000008,"lng":37.81315500000008},{"lat":55.91236500000008,"lng":37.81735900000008},{"lat":55.91120900000008,"lng":37.81778600000008},{"lat":55.909763000000076,"lng":37.817957000000085},{"lat":55.907788000000075,"lng":37.817873000000084},{"lat":55.906536000000074,"lng":37.81770200000008},{"lat":55.90596000000007,"lng":37.826113000000085},{"lat":55.90687400000007,"lng":37.826456000000086},{"lat":55.90682700000007,"lng":37.83529500000009},{"lat":55.91039200000007,"lng":37.834353000000085},{"lat":55.911356000000076,"lng":37.835124000000086},{"lat":55.910056000000075,"lng":37.836925000000086},{"lat":55.907647000000075,"lng":37.838211000000086},{"lat":55.902441000000074,"lng":37.84207200000009},{"lat":55.90075600000007,"lng":37.85108300000009},{"lat":55.90254000000007,"lng":37.85271200000009},{"lat":55.89940600000007,"lng":37.86944800000009},{"lat":55.89873100000007,"lng":37.87167900000009},{"lat":55.89916400000007,"lng":37.872278000000094},{"lat":55.89752700000007,"lng":37.8830920000001},{"lat":55.90528800000007,"lng":37.8880700000001},{"lat":55.90451700000007,"lng":37.8906440000001},{"lat":55.90345700000007,"lng":37.8923600000001},{"lat":55.901240000000065,"lng":37.8907310000001},{"lat":55.90138300000007,"lng":37.8894450000001},{"lat":55.896321000000064,"lng":37.8867860000001},{"lat":55.89588800000006,"lng":37.8945100000001},{"lat":55.89507000000006,"lng":37.894766000000104},{"lat":55.89352800000006,"lng":37.898027000000106},{"lat":55.89150300000006,"lng":37.90171600000011},{"lat":55.88942900000006,"lng":37.90677800000011},{"lat":55.89048900000006,"lng":37.90806400000011},{"lat":55.89188700000006,"lng":37.91098200000011},{"lat":55.89299500000006,"lng":37.91295400000011},{"lat":55.89458500000006,"lng":37.913812000000114},{"lat":55.895887000000066,"lng":37.916299000000116},{"lat":55.89661000000007,"lng":37.917585000000116},{"lat":55.89810400000007,"lng":37.916128000000114},{"lat":55.89978900000007,"lng":37.91149400000011},{"lat":55.90200600000007,"lng":37.91226500000011},{"lat":55.90373900000007,"lng":37.91260800000011},{"lat":55.90503900000007,"lng":37.91337900000011},{"lat":55.906581000000074,"lng":37.91192200000011},{"lat":55.90426800000007,"lng":37.90900400000011},{"lat":55.90263100000007,"lng":37.90454100000011},{"lat":55.90595700000007,"lng":37.897934000000106},{"lat":55.90566800000007,"lng":37.897248000000104},{"lat":55.90084800000007,"lng":37.8971640000001},{"lat":55.900801000000065,"lng":37.8949330000001},{"lat":55.90832000000007,"lng":37.8949330000001},{"lat":55.90913800000007,"lng":37.8968210000001},{"lat":55.90995600000007,"lng":37.896992000000104},{"lat":55.90971500000007,"lng":37.898621000000105},{"lat":55.90721100000007,"lng":37.89956300000011},{"lat":55.90764400000007,"lng":37.90788700000011},{"lat":55.90716300000007,"lng":37.90917300000011},{"lat":55.90740400000007,"lng":37.91123200000011},{"lat":55.90649000000007,"lng":37.91492100000011},{"lat":55.90841700000007,"lng":37.917923000000116},{"lat":55.90933100000007,"lng":37.91963900000012},{"lat":55.910535000000074,"lng":37.91972300000012},{"lat":55.909764000000074,"lng":37.92178200000012},{"lat":55.90831800000007,"lng":37.924356000000124},{"lat":55.90730600000007,"lng":37.926072000000126},{"lat":55.90533100000007,"lng":37.93182100000013},{"lat":55.90489800000007,"lng":37.93353700000013},{"lat":55.90330800000007,"lng":37.93311000000013},{"lat":55.902248000000064,"lng":37.94066300000013},{"lat":55.89824700000006,"lng":37.93980500000013},{"lat":55.89680100000006,"lng":37.94134900000013},{"lat":55.89704200000006,"lng":37.94581200000013},{"lat":55.89699500000006,"lng":37.94804300000013},{"lat":55.89964600000006,"lng":37.949500000000135},{"lat":55.89868200000006,"lng":37.957481000000136},{"lat":55.893040000000056,"lng":37.954822000000135},{"lat":55.89352100000006,"lng":37.949844000000134},{"lat":55.892750000000056,"lng":37.94761300000013},{"lat":55.89506500000006,"lng":37.94349400000013},{"lat":55.89448900000006,"lng":37.94255200000013},{"lat":55.89289900000006,"lng":37.941179000000126},{"lat":55.890344000000056,"lng":37.940493000000124},{"lat":55.89159800000006,"lng":37.943667000000126},{"lat":55.89198300000006,"lng":37.94615400000013},{"lat":55.88995800000006,"lng":37.94812600000013},{"lat":55.889140000000054,"lng":37.94649700000013},{"lat":55.88779000000005,"lng":37.94607000000013},{"lat":55.88721400000005,"lng":37.94812900000013},{"lat":55.88601000000005,"lng":37.94718700000013},{"lat":55.88607400000005,"lng":37.946352000000125},{"lat":55.88662200000005,"lng":37.945860000000124},{"lat":55.88651600000005,"lng":37.94470400000012},{"lat":55.88624100000005,"lng":37.94406300000012},{"lat":55.88615700000005,"lng":37.94239200000012},{"lat":55.88755500000005,"lng":37.94145000000012},{"lat":55.88819900000005,"lng":37.94249000000012},{"lat":55.88903700000005,"lng":37.94233000000012},{"lat":55.889554000000054,"lng":37.94166600000012},{"lat":55.88871000000005,"lng":37.93948000000012},{"lat":55.889528000000055,"lng":37.936219000000115},{"lat":55.891070000000056,"lng":37.93519000000011},{"lat":55.891070000000056,"lng":37.93227200000011},{"lat":55.89415600000006,"lng":37.93158600000011},{"lat":55.89446800000006,"lng":37.93467500000011},{"lat":55.89748200000006,"lng":37.93441900000011},{"lat":55.89704900000006,"lng":37.93115800000011},{"lat":55.89372300000006,"lng":37.92927000000011},{"lat":55.89145800000006,"lng":37.92746900000011},{"lat":55.888613000000056,"lng":37.92558100000011},{"lat":55.886154000000055,"lng":37.923522000000105},{"lat":55.88557800000005,"lng":37.9215500000001},{"lat":55.88398800000005,"lng":37.9196620000001},{"lat":55.88284000000005,"lng":37.9231910000001},{"lat":55.88144200000005,"lng":37.9227640000001},{"lat":55.88081500000005,"lng":37.9210480000001},{"lat":55.88197100000005,"lng":37.917531000000096},{"lat":55.88009200000005,"lng":37.914872000000095},{"lat":55.878936000000046,"lng":37.9183890000001},{"lat":55.878213000000045,"lng":37.9187320000001},{"lat":55.87792400000004,"lng":37.9201890000001},{"lat":55.880141000000044,"lng":37.9218180000001},{"lat":55.88004600000004,"lng":37.9226760000001},{"lat":55.87585000000004,"lng":37.9224200000001},{"lat":55.875945000000044,"lng":37.9209630000001},{"lat":55.87551200000004,"lng":37.9200210000001},{"lat":55.87445200000004,"lng":37.9208790000001},{"lat":55.87392300000004,"lng":37.920365000000096},{"lat":55.87329600000004,"lng":37.918049000000096},{"lat":55.87218800000004,"lng":37.9183920000001},{"lat":55.872045000000035,"lng":37.9220810000001},{"lat":55.87045300000003,"lng":37.921567000000096},{"lat":55.86982600000003,"lng":37.920796000000095},{"lat":55.86842800000003,"lng":37.920712000000094},{"lat":55.86823500000003,"lng":37.923115000000095},{"lat":55.867560000000026,"lng":37.925003000000096},{"lat":55.86958600000003,"lng":37.9256020000001},{"lat":55.87127400000003,"lng":37.9260290000001},{"lat":55.87460300000003,"lng":37.9308350000001},{"lat":55.87431400000003,"lng":37.9316930000001},{"lat":55.87489300000003,"lng":37.932207000000105},{"lat":55.87378500000003,"lng":37.934095000000106},{"lat":55.872725000000024,"lng":37.93495300000011},{"lat":55.87166500000002,"lng":37.93641000000011},{"lat":55.86920600000002,"lng":37.93855400000011},{"lat":55.86934900000002,"lng":37.94078500000011},{"lat":55.86838400000002,"lng":37.941212000000114},{"lat":55.86857700000002,"lng":37.943615000000115},{"lat":55.871664000000024,"lng":37.94241400000011},{"lat":55.872097000000025,"lng":37.93941200000011},{"lat":55.87378500000003,"lng":37.93812600000011},{"lat":55.87499100000003,"lng":37.93778300000011},{"lat":55.87518400000003,"lng":37.93906900000011},{"lat":55.87465500000003,"lng":37.93966800000011},{"lat":55.875282000000034,"lng":37.94258600000011},{"lat":55.87610000000004,"lng":37.94267000000011},{"lat":55.87624300000004,"lng":37.94001100000011},{"lat":55.87739900000004,"lng":37.93863800000011},{"lat":55.87783200000004,"lng":37.94043900000011},{"lat":55.87764100000004,"lng":37.943441000000114},{"lat":55.87740000000004,"lng":37.947130000000115},{"lat":55.876002000000035,"lng":37.95090600000012},{"lat":55.87566500000003,"lng":37.95296500000012},{"lat":55.87407300000003,"lng":37.95210700000012},{"lat":55.87180500000003,"lng":37.95142100000012},{"lat":55.86953700000003,"lng":37.950392000000114},{"lat":55.86804100000003,"lng":37.950476000000116},{"lat":55.867175000000024,"lng":37.95150500000012},{"lat":55.86519700000002,"lng":37.95339300000012},{"lat":55.86239800000002,"lng":37.95227900000012},{"lat":55.86003400000002,"lng":37.950048000000116},{"lat":55.86103500000002,"lng":37.947260000000114},{"lat":55.85952700000002,"lng":37.94309800000011},{"lat":55.85873100000002,"lng":37.943697000000114},{"lat":55.85588300000002,"lng":37.945498000000114},{"lat":55.85192700000002,"lng":37.949274000000116},{"lat":55.848936000000016,"lng":37.948332000000114},{"lat":55.845703000000015,"lng":37.94644400000011},{"lat":55.844496000000014,"lng":37.94155300000011},{"lat":55.845604000000016,"lng":37.93717700000011},{"lat":55.844833000000015,"lng":37.93057000000011},{"lat":55.843578000000015,"lng":37.93031400000011},{"lat":55.83821800000001,"lng":37.91761400000011},{"lat":55.83082800000001,"lng":37.915985000000106},{"lat":55.82908900000001,"lng":37.9049990000001},{"lat":55.82812400000001,"lng":37.8992500000001},{"lat":55.82715900000001,"lng":37.8977930000001},{"lat":55.825469000000005,"lng":37.8865500000001},{"lat":55.819382000000004,"lng":37.8904110000001},{"lat":55.819477000000006,"lng":37.8887820000001},{"lat":55.82063600000001,"lng":37.8879240000001},{"lat":55.820105000000005,"lng":37.884663000000096},{"lat":55.82474200000001,"lng":37.881402000000094},{"lat":55.82319700000001,"lng":37.87299100000009},{"lat":55.822860000000006,"lng":37.86990200000009},{"lat":55.822233000000004,"lng":37.86664100000009},{"lat":55.820883,"lng":37.86046200000008},{"lat":55.819628,"lng":37.85531300000008},{"lat":55.818855,"lng":37.85256700000008},{"lat":55.817986,"lng":37.849993000000076},{"lat":55.816632999999996,"lng":37.84690400000007},{"lat":55.815425999999995,"lng":37.84355800000007},{"lat":55.815425999999995,"lng":37.84132700000007},{"lat":55.816753999999996,"lng":37.83922500000007},{"lat":55.821464999999996,"lng":37.83763800000007},{"lat":55.82615,"lng":37.83480700000007},{"lat":55.830256,"lng":37.82974500000007},{"lat":55.830399,"lng":37.825626000000064},{"lat":55.829724,"lng":37.80794500000006},{"lat":55.827937,"lng":37.80828800000006},{"lat":55.826297,"lng":37.80597200000006},{"lat":55.824605999999996,"lng":37.80279800000006},{"lat":55.823398999999995,"lng":37.80271400000006},{"lat":55.82286799999999,"lng":37.79851000000006},{"lat":55.82228899999999,"lng":37.79722400000006},{"lat":55.82243199999999,"lng":37.786668000000056},{"lat":55.825523999999994,"lng":37.78563900000005},{"lat":55.826392999999996,"lng":37.77482500000005},{"lat":55.826249999999995,"lng":37.77242200000005},{"lat":55.828905999999996,"lng":37.77207900000005},{"lat":55.829823,"lng":37.768390000000046},{"lat":55.830692,"lng":37.764442000000045},{"lat":55.830403,"lng":37.762039000000044},{"lat":55.831126,"lng":37.75890700000004},{"lat":55.829919,"lng":37.75646200000004},{"lat":55.828953999999996,"lng":37.75491800000004},{"lat":55.82663599999999,"lng":37.750284000000036},{"lat":55.82557599999999,"lng":37.74822500000003},{"lat":55.82417499999999,"lng":37.748396000000035},{"lat":55.82243599999999,"lng":37.749510000000036},{"lat":55.82064899999999,"lng":37.74968100000004},{"lat":55.81619199999999,"lng":37.739897000000035},{"lat":55.81758099999999,"lng":37.73526300000003},{"lat":55.81944099999999,"lng":37.73097200000003},{"lat":55.81857199999999,"lng":37.72900000000003},{"lat":55.82040599999999,"lng":37.724796000000026},{"lat":55.81968899999999,"lng":37.722278000000024},{"lat":55.82157899999999,"lng":37.71924500000002},{"lat":55.822942999999995,"lng":37.720730000000025},{"lat":55.824608,"lng":37.71666700000002},{"lat":55.822506,"lng":37.71260400000002},{"lat":55.822036999999995,"lng":37.71083100000002},{"lat":55.82142199999999,"lng":37.71217500000002},{"lat":55.82070999999999,"lng":37.71111700000002},{"lat":55.82034999999999,"lng":37.70900100000002},{"lat":55.82039699999999,"lng":37.70562500000002},{"lat":55.820978999999994,"lng":37.70488300000002},{"lat":55.822433,"lng":37.70493900000002},{"lat":55.82102999999999,"lng":37.700189000000016},{"lat":55.81904899999999,"lng":37.694752000000015},{"lat":55.81633999999999,"lng":37.68387600000001},{"lat":55.81937599999999,"lng":37.67620200000001}];
var area2 = [{"lat":55.889838,"lng":37.962411},{"lat":55.891211,"lng":37.965500000000006},{"lat":55.891475,"lng":37.96743000000001},{"lat":55.892873,"lng":37.96863100000001},{"lat":55.891619,"lng":37.97137700000001},{"lat":55.890004,"lng":37.97275000000001},{"lat":55.888389,"lng":37.97167800000001},{"lat":55.889593,"lng":37.96835500000001},{"lat":55.889568999999995,"lng":37.96725000000001},{"lat":55.888918999999994,"lng":37.966660000000005},{"lat":55.888558999999994,"lng":37.96428},{"lat":55.889123999999995,"lng":37.962704}];
var area3 = [{"lat":55.88827,"lng":37.972024},{"lat":55.888728,"lng":37.974041},{"lat":55.888728,"lng":37.976916},{"lat":55.888728,"lng":37.978933000000005},{"lat":55.887884,"lng":37.98026300000001},{"lat":55.887426,"lng":37.98206400000001},{"lat":55.884797999999996,"lng":37.98167900000001},{"lat":55.884387999999994,"lng":37.98232000000001},{"lat":55.88409899999999,"lng":37.98420800000001},{"lat":55.88380999999999,"lng":37.98480700000001},{"lat":55.88337699999999,"lng":37.98407900000001},{"lat":55.88366599999999,"lng":37.98330800000001},{"lat":55.88180899999999,"lng":37.980520000000006},{"lat":55.88168899999999,"lng":37.978849000000004},{"lat":55.88231599999999,"lng":37.977476},{"lat":55.88351199999999,"lng":37.977673},{"lat":55.88417799999999,"lng":37.977271},{"lat":55.88508399999999,"lng":37.978027000000004},{"lat":55.88613599999999,"lng":37.976381}];
var area4 = [{"lat":55.883398,"lng":37.952111},{"lat":55.884433,"lng":37.954556000000004},{"lat":55.884987,"lng":37.955113000000004},{"lat":55.884915,"lng":37.95592800000001},{"lat":55.882698,"lng":37.96068900000001},{"lat":55.881612999999994,"lng":37.96180300000001},{"lat":55.88079499999999,"lng":37.96150300000001},{"lat":55.88151799999999,"lng":37.95734100000001},{"lat":55.88108499999999,"lng":37.956399000000005},{"lat":55.88101299999999,"lng":37.952924},{"lat":55.88229599999999,"lng":37.952829},{"lat":55.88271199999999,"lng":37.952047}];
var area5 = [{"lat":55.889693,"lng":37.990649},{"lat":55.890464,"lng":37.991678},{"lat":55.891235,"lng":37.990522},{"lat":55.89256,"lng":37.989965},{"lat":55.892776000000005,"lng":37.988721999999996},{"lat":55.89393200000001,"lng":37.98820799999999},{"lat":55.89479800000001,"lng":37.989580999999994},{"lat":55.89532700000001,"lng":37.991251999999996},{"lat":55.89549500000001,"lng":37.992667},{"lat":55.89694100000001,"lng":37.993308},{"lat":55.897638000000015,"lng":37.994509},{"lat":55.896746000000014,"lng":37.996996},{"lat":55.896217000000014,"lng":37.997938000000005},{"lat":55.896675000000016,"lng":38.00171400000001},{"lat":55.89681800000002,"lng":38.00377300000001},{"lat":55.895685000000014,"lng":38.00656100000001},{"lat":55.89467300000001,"lng":38.00819000000001},{"lat":55.89433600000001,"lng":38.009777000000014},{"lat":55.89371200000001,"lng":38.011493000000016},{"lat":55.892652000000005,"lng":38.01222100000002},{"lat":55.892002000000005,"lng":38.01282000000002},{"lat":55.891569000000004,"lng":38.01260700000002},{"lat":55.891401,"lng":38.01363600000002},{"lat":55.890197,"lng":38.01312200000002},{"lat":55.888028,"lng":38.010849000000015},{"lat":55.88569,"lng":38.00844600000001},{"lat":55.874401999999996,"lng":37.99626100000001},{"lat":55.875173,"lng":37.99171400000001},{"lat":55.881178,"lng":37.99385800000001},{"lat":55.882286,"lng":37.98772300000001},{"lat":55.882719,"lng":37.98733800000001},{"lat":55.884154,"lng":37.99019100000001},{"lat":55.885231000000005,"lng":37.99054500000001},{"lat":55.886494000000006,"lng":37.98965100000001},{"lat":55.88685900000001,"lng":37.98830300000001},{"lat":55.88692000000001,"lng":37.98767300000001},{"lat":55.88837400000001,"lng":37.98890200000001}];
