// Clase para la mejora 10
class LocationMap {
    constructor(mapId, coordinates) {
        this.mapId = mapId;
        this.coordinates = coordinates;
        this.map = null;
        this.vectorLayer = null;
    }

    initialize() {
        try {
            const mapElement = document.getElementById(this.mapId);
            if (!mapElement) {
                console.error(`Element with id ${this.mapId} not found`);
                return;
            }

            if (!this.isValidCoordinates()) {
                console.error('Invalid coordinates provided');
                return;
            }

            this.map = new ol.Map({
                target: this.mapId,
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: ol.proj.fromLonLat([this.coordinates.lon, this.coordinates.lat]),
                    zoom: 12
                })
            });

            this.addMarker();
            this.map.updateSize();

            setTimeout(() => {
                this.map.updateSize();
            }, 200);
        } catch (error) {
            console.error('Error initializing map:', error);
        }
    }

    isValidCoordinates() {
        return this.coordinates
            && typeof this.coordinates.lat === 'number'
            && typeof this.coordinates.lon === 'number'
            && !isNaN(this.coordinates.lat)
            && !isNaN(this.coordinates.lon)
            && this.coordinates.lat >= -90
            && this.coordinates.lat <= 90
            && this.coordinates.lon >= -180
            && this.coordinates.lon <= 180;
    }

    addMarker() {
        const marker = new ol.Feature({
            geometry: new ol.geom.Point(
                ol.proj.fromLonLat([this.coordinates.lon, this.coordinates.lat])
            )
        });

        const vectorSource = new ol.source.Vector({
            features: [marker]
        });

        const markerStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 8,
                fill: new ol.style.Fill({ color: '#ff0000' }),
                stroke: new ol.style.Stroke({
                    color: '#fff',
                    width: 2
                })
            })
        });

        this.vectorLayer = new ol.layer.Vector({
            source: vectorSource,
            style: markerStyle
        });

        this.map.addLayer(this.vectorLayer);
    }
}

function initializeMap(mapId, coordinates) {
    try {
        const locationMap = new LocationMap(mapId, coordinates);
        locationMap.initialize();
    } catch (error) {
        console.error("Error initializing map:", error);
    }
}