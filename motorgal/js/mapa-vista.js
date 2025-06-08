document.addEventListener("DOMContentLoaded", function () {
    if (typeof L === "undefined") {
        console.error("Leaflet no está cargado correctamente.");
        return;
    }

    const map = L.map('map').setView([42.8805, -8.5457], 8); // Vista por defecto (Santiago)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Referencia a los campos ocultos
    const latInput = document.getElementById('latitud');
    const lngInput = document.getElementById('longitud');

    // Mostrar marcador solo si hay coordenadas válidas
    const savedLat = parseFloat(latInput.value);
    const savedLng = parseFloat(lngInput.value);

    if (!isNaN(savedLat) && !isNaN(savedLng)) {
        const marker = L.marker([savedLat, savedLng]).addTo(map);
        map.setView([savedLat, savedLng], 12);
    } else {
        console.warn("No se han proporcionado coordenadas válidas.");
    }
});
