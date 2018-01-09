"use strict";

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
			html: '\\/\\'
		}
	});
	L.NewPolygonControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startPolygon,
			kind: 'полигон',
			html: '▰'
		}
	});
	L.NewMarkerControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startMarker,
			kind: 'маркер',
			html: '🖈'
		}
	});
	L.NewCircleControl = L.EditControl.extend({
		options: {
			position: 'topright',
			callback: map.editTools.startCircle,
			kind: 'круг',
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
			callback: frmData.setVisible,
			kind: 'Главное меню',
			html: '^'
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Главное меню';
			link.innerHTML = this.options.html;
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						this.options.callback(true);
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
			html: '='
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Слои на карте';
			link.innerHTML = this.options.html;
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
			html: '+'
		},
		onAdd: function (map) {
			var container = L.DomUtil.create('div', 'leaflet-control leaflet-bar');
			var link = L.DomUtil.create('a', '', container);
			link.href = '#';
			link.title = 'Режим рисования';
			link.innerHTML = this.options.html;
			L.DomEvent.on(link, 'click', L.DomEvent.stop)
					  .on(link, 'click', function () {
						isPaintMode = !isPaintMode;
						this.options.callback(map, [mc, lc, pc, cc], isPaintMode);
					  }, this);
		
			return container;
		}
	});
	if (getPolicy(["cO","cL"])) map.addControl(new L.NewPaintControl);
	
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