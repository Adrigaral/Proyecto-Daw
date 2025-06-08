document.addEventListener("DOMContentLoaded", () => {
    if (typeof L === "undefined") {
        console.error("Leaflet no está cargado correctamente.");
        return;
    }

    const latInput = document.getElementById("latitud");
    const lngInput = document.getElementById("longitud");

    const savedLat = parseFloat(latInput.value);
    const savedLng = parseFloat(lngInput.value);
    const hasSavedCoords = !isNaN(savedLat) && !isNaN(savedLng);

    const map = L.map("map").setView(
        hasSavedCoords ? [savedLat, savedLng] : [42.8805, -8.5457],
        hasSavedCoords ? 12 : 8
    );

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    let marker = null;
    if (hasSavedCoords) {
        marker = L.marker([savedLat, savedLng], { draggable: true }).addTo(map);
        setDragHandler(marker);
    }

    const bounds = {
        minLat: 41.8,
        maxLat: 43.8,
        minLng: -9.4,
        maxLng: -6.5,
    };

    map.on("click", (e) => {
        const { lat, lng } = e.latlng;

        if (lat >= bounds.minLat && lat <= bounds.maxLat && lng >= bounds.minLng && lng <= bounds.maxLng) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                setDragHandler(marker);
            }
            updateInputs(lat, lng);
        } else {
            alert("Por favor, selecciona una ubicación dentro de Galicia.");
        }
    });

    function updateInputs(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
    }

    function setDragHandler(mk) {
        mk.on("dragend", () => {
            const { lat, lng } = mk.getLatLng();
            updateInputs(lat, lng);
        });
    }
});