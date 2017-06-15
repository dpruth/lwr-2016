var map, agraphicsLayer, symbol;
function addPointtoMap(x, y) {
    require(["esri/geometry/Point", "esri/graphic", "dojo/domReady!"], function (Point, Graphic) {
        var pt = new Point(x, y);
        map.centerAt(pt);
        agraphicsLayer.add(new Graphic(pt, symbol));
    });
}

    // Set up map in custom-project-locations to accept Points with addPointtoMap function
    var mapDiv = document.getElementById("mapDiv");
    if (mapDiv) {
        // Detect IE
        var isIE = window.navigator.userAgent.indexOf("MSIE");
        if (!isIE || isIE === -1 || !!navigator.userAgent.match(/Trident\/7\./)) {
            /* $.getScript("https://js.arcgis.com/3.16/")
                    //.done
										(function (script, textStatus) {
                        if (typeof data == 'undefined') {
							$('#project-locations').height('150px');
							mapDiv.innerHTML = '<div><h4 align="center">There are currently no project locations.</h4></div>';
							return false;
						} */
						require([
                            "esri/map",
                            "esri/InfoTemplate",
                            "esri/symbols/PictureMarkerSymbol",
                            "esri/geometry/Point",
                            "esri/graphic",
                            "esri/Color",
                            "esri/layers/GraphicsLayer",
                            "esri/dijit/PopupTemplate",
                            "esri/dijit/InfoWindow",
														"esri/dijit/Search",
                            "esri/geometry/Extent",
                            "dojo/domReady!"
                        ], function (
                                Map, InfoTemplate, PictureMarkerSymbol, Point, Graphic, Color, GraphicsLayer, PopupTemplate, InfoWindow, Search, Extent
                                ) {
                            map = new Map("mapDiv", {
                                center: [-56.049, 32.485],
                                zoom: 5,
                                basemap: "topo",
                                logo: false
                            });
                            var infoTemplate = new InfoTemplate('${title}', "${description}");
                            var template = new PopupTemplate({
                                title: "{title}",
                                description: "{description}",
                                fieldInfos: [{
                                        fieldName: "objectId",
                                        label: "objectId"
                                    },
                                    {
                                        fieldName: "title",
                                        label: "title"
                                    },
                                    {
                                        fieldName: "description",
                                        label: "description"
                                    }]
                            });
                            map.on("load", function () {
                                map.disableScrollWheelZoom();
                            });

                            agraphicsLayer = new GraphicsLayer({
                                "infoTemplate": infoTemplate
                            });
                            agraphicsLayer.setInfoTemplate(template);

                            map.addLayer(agraphicsLayer);
                            var xmin = 0,
                                    xmax = 0,
                                    ymin = 0,
                                    ymax = 0;
                            data.features.forEach(function (feature) {
                                var pt = new Point(feature.geometry.coordinates, map.spatialReference);
                                if (xmin == 0 || pt.x < xmin) {
                                    xmin = pt.x;
                                }

                                if (xmax == 0 || pt.x > xmax) {
                                    xmax = pt.x
                                }

                                if (ymin == 0 || pt.y < ymin) {
                                    ymin = pt.y;
                                }
                                if (ymax == 0 || pt.y > ymax) {
                                    ymax = pt.y;
                                }
                                map.centerAt(pt);
                                symbol = new PictureMarkerSymbol(feature.symbol, 26, 26);
                                symbol.setColor(new Color("#00ADA1"));
                                // symbol.setUrl(feature.symbol);
																// symbol.setHeight(26);
																// symbol.setWidth(26);																
                                agraphicsLayer.add(new Graphic(pt, symbol, feature, infoTemplate));
                            });
																												
                            var theExtent = new Extent({
                                "xmin": xmin + 1,
                                "ymin": ymin + 1,
                                "xmax": xmax + 1,
                                "ymax": ymax + 1,
                                "spatialReference": {"wkid": 4326}
                            });
                            if (data.features.length == 1) {
                                map.setExtent(theExtent);
                                map.centerAndZoom(data.features[0].geometry.coordinates, 11);
                            } else {
                                map.setExtent(theExtent.expand(1.2));
                            }

                        });	
					// });
        }
        else {
			$('#project-locations').height('150px');
            mapDiv.innerHTML = '<div><h4 align="center">Sorry, your browser version does not support this section.</h4></div>';
        }
    }
