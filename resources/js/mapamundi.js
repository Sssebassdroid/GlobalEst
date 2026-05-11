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

async function getCoordsByName(namePlace){
    try{
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(namePlace)}`);
        const data = await response.json();
        if(data.length > 0){   
            const firstResult = data[0];
            map.flyTo([firstResult.lat, firstResult.lon], 15); 
            createMarker(firstResult.lat, firstResult.lon);
        }
    } catch(error){
        console.error("Error en la geocodificacion", error);
    }
}

async function getDataFromCoords(coordenada) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${coordenada.getLat}&lon=${coordenada.getLong}`, {
            headers: { 'Accept-Language': 'es' }
        });
        return await response.json();
    } catch (error) {
        console.error("Error en geocodificación inversa:", error);
        return null;
    }
}

function createMarkerOnClick(){
   map.on('click', (e) => createMarker(e.latlng.lat, e.latlng.lng));
}

async function createMarker(lat, long) {
    const newCoord = new Coordenada(lat, long);
    if (!newCoord.isValid()) return;

    const data = await getDataFromCoords(newCoord);
    if (!data) return;

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
    polyline.addLatLng([lat, long]);
    L.marker([lat, long], { icon: customIcon(listaTours.length) }).addTo(map).bindPopup(newPlace.display_name);
    actualizarTablaRutas();
}

function actualizarTablaRutas() {
    const cuerpo = document.getElementById('cuerpo-tabla');
    if (!cuerpo) return;
    cuerpo.innerHTML = listaTours.map((lugar, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>${lugar.name}</td>
        </tr>
    `).join('');
}

// PERSISTENCIA: Al confirmar, guardamos en LocalStorage
if (formConfirmarRuta) {
    formConfirmarRuta.addEventListener('submit', function(e) {
        if (listaTours.length === 0) {
            e.preventDefault();
            alert("Selecciona al menos un lugar.");
            return;
        }
        const jsonStr = JSON.stringify(listaTours);
        localStorage.setItem('itinerario_temporal', jsonStr);
        // Sincronizamos con el input del form actual si existe
        const input = document.getElementById('itinerario-temporal');
        if (input) input.value = jsonStr;
    });
}

// CARGA Y RENDERIZADO: Al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const data = localStorage.getItem('itinerario_temporal');
    const puntos = data ? JSON.parse(data) : [];
    
    // Seguridad: Si intentamos entrar a crear tour sin puntos, abortamos
    if (puntos.length === 0 && window.location.pathname.includes('create-tour')) {
        window.location.href = '/places';
        return;
    }
    
    renderItinerary(puntos);
});

function renderItinerary(puntos) {
    const tabla = document.getElementById('cuerpo-tabla');
    const inputOculto = document.getElementById('itinerario_temporal'); // ID unificado con Blade

    if (tabla) {
        tabla.innerHTML = puntos.map((lugar, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${lugar.display_name}</td>
            </tr>
        `).join('');
    }

    if (inputOculto) {
        inputOculto.value = JSON.stringify(puntos);
    }
}

createMarkerOnClick();
if (formulario) {
    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        getCoordsByName(placeName.value);
    });
}

window.limpiarMapa = function() {
    if (confirm("¿Seguro que quieres borrar todos los puntos?")) {
        listaTours = []; // Vacía el array en memoria
        localStorage.removeItem('itinerario-temporal'); // Borra el disco duro del navegador
        
        // Limpia visualmente el mapa (Leaflet)
        polyline.setLatLngs([]);
        map.eachLayer((layer) => {
            if (layer instanceof L.Marker) map.removeLayer(layer);
        });
        
        actualizarTablaRutas(); // Refresca la tabla (quedará vacía)
        console.log("Estado de la aplicación reiniciado.");
    }
}