import { Coordenada } from './Coord.js';
import { Lugar } from './Lugar.js';
import { map } from './start-mapamundi.js'; 

const placeName = document.getElementById('place-name');
const formulario = document.querySelector('.buscador');
const formConfirmarRuta = document.getElementById('form-confirmar-ruta');
let listaTours = [];

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

// Lógica de geocodificación y marcadores (Se mantiene igual)
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
    
    // ¡PASO NECESARIO!: Actualizar el almacén cada vez que añadimos un punto
    localStorage.setItem('itinerario_temporal', JSON.stringify(listaTours));
    
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

// PERSISTENCIA: La única responsabilidad de este botón es guardar en LocalStorage
if (formConfirmarRuta) {
    formConfirmarRuta.addEventListener('submit', function(e) {
        const datos = localStorage.getItem('itinerario_temporal');
        const inputHidden = document.getElementById('itinerario-temporal');
        
        if (!datos || JSON.parse(datos).length === 0) {
            e.preventDefault();
            alert("No hay puntos seleccionados.");
            return;
        }

        // ¡PASO CRÍTICO!: Inyectar el JSON en el input que leerá Laravel
        inputHidden.value = datos; 
    });
}

map.on('click', (e) => createMarker(e.latlng.lat, e.latlng.lng));

window.limpiarMapa = function() {
    if (confirm("¿Borrar todo?")) {
        listaTours = [];
        localStorage.removeItem('itinerario_temporal');
        location.reload();
    }
}