import { Coordenada } from './Coord.js';
import { Lugar } from './Lugar.js';
import { map } from './start-mapamundi.js';

const formulario = document.getElementById('form-buscador');
const formConfirmarRuta = document.getElementById('form-confirmar-ruta');
let listaTours = [];

const placeName = document.getElementById('place-name');


const polyline = L.polyline([], {
    color: '#2563eb',
    weight: 3,
    opacity: 0.8
}).addTo(map);

function customIcon(posicion){
    return L.divIcon({
        className: 'number-icon',
        html: `<div>${posicion}</div>`,
        iconSize: [25, 25],
        iconAnchor: [12, 12]
    });
}

async function createMarker(lat, long) {
    const newCoord = new Coordenada(lat, long);
    if (!newCoord.isValid()) return;

    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${long}`, {
        headers: { 'Accept-Language': 'es' }
    });
    const data = await response.json();

    const newPlace = new Lugar(
        data.place_id || Date.now(),
        data.name || data.display_name,
        data.address?.road || data.display_name || "Dirección desconocida",
        lat, long,
        data.importance || 0,
        data.address?.city || data.address?.town || "Desconocida",
        data.osm_type,
        data.osm_id
    );

    listaTours.push(newPlace);

    localStorage.setItem('temporal-itinerary', JSON.stringify(listaTours));

    polyline.addLatLng([lat, long]);
    L.marker([lat, long], { icon: customIcon(listaTours.length) }).addTo(map).bindPopup(newPlace.display_name);
    actualizarTablaVistaPrevia();
}

function actualizarTablaVistaPrevia() {
    const cuerpo = document.getElementById('cuerpo-tabla');
    if (!cuerpo) return;
    cuerpo.innerHTML = listaTours.map((lugar, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${lugar.name}</td>
        </tr>
    `).join('');
}

if (formConfirmarRuta) {
    formConfirmarRuta.addEventListener('submit', function(e) {
        const datos = localStorage.getItem('temporal-itinerary');
        const inputHidden = document.getElementById('temporal-itinerary');

        if (!datos || JSON.parse(datos).length === 0) {
            e.preventDefault();
            alert("No hay puntos seleccionados.");
            return;
        }

        inputHidden.value = datos;
    });
}

async function getCoordsByName(namePlace){
    try{
        console.log(namePlace);
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(namePlace)}`);

        console.log(response);
        const data = await response.json();


        if(data.length > 0){
            const firstResult = data[0];
            const lat = firstResult.lat;
            const lon = firstResult.lon;
            map.flyTo([lat, lon], 15);
            createMarker(lat, lon);
        }else{
            console.warn("No se encontraron coordenadas para esa dirección.");
        }

    }
    catch(error){
        console.error("Error en la geocodificacion", error)
    }

}

formulario.addEventListener('submit', function(event){
    event.preventDefault();
    name = placeName.value;
    getCoordsByName(name);

});

map.on('click', (e) => createMarker(e.latlng.lat, e.latlng.lng));

window.limpiarMapa = function() {
    if (confirm("¿Borrar todo?")) {
        listaTours = [];
        localStorage.removeItem('temporal-itinerary');
        location.reload();
    }
}
