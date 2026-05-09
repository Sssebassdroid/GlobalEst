import { Coordenada } from './Coord.js';
import { Lugar } from './Lugar.js';

var map = L.map('mapamundi', {
    
    attributionControl: false 

}).setView([30, 0], 2);


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);






const placeName = document.getElementById('place-name');
const formulario = document.querySelector('.buscador');
let listaTours = []



const polyline = L.polyline([], {
    color: '#2563eb', 
    weight: 3,
    opacity: 0.8
}).addTo(map);





function customIcon(posicion){
    const icon = L.divIcon({
        className: 'number-icon',
        html: `<div>${posicion}</div>`,
        iconSize: [25, 25],
        iconAnchor: [12, 12]
    });
    return icon;
}


async function getCoordsByName(namePlace){
    try{
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(namePlace)}`);

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


async function getDataFromCoords(coordenada) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${coordenada.getLat}&lon=${coordenada.getLong}`, {
            headers: {
                'Accept-Language': 'es' 
            }
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error en geocodificación inversa:", error);
        return null;
    }
}


function createMarkerOnClick(){
   map.on('click', function(e) {
        createMarker(e.latlng.lat, e.latlng.lng);
    });
}


// ... (resto de tu código anterior igual)

async function createMarker(lat, long) {
    const newCoord = new Coordenada(lat, long);
    if (!newCoord.isValid()) return null;

    const data = await getDataFromCoords(newCoord);
    if (!data) return;

    // Mapeo de datos asegurando tipos correctos para la clase Lugar
    const id = data.place_id || Date.now();
    const name = data.name || "Vía no registrada";
    // Usamos road o display_name como dirección amigable
    const display_name = data.address?.road || data.display_name || "Dirección desconocida";
    const importance = data.importance || 0;
    const city = data.address?.city || data.address?.town || data.address?.village || "Perugia";
    const osm_type = data.osm_type;
    const osm_id = data.osm_id;

    const newPlace = new Lugar(id, name, display_name, lat, long, importance, city, osm_type, osm_id);
    
    listaTours.push(newPlace);
    
    // UI: Marcador y Polilínea
    const icon = customIcon(listaTours.length);
    polyline.addLatLng([lat, long]);
    L.marker([lat, long], { icon: icon }).addTo(map).bindPopup(display_name);
    
    actualizarTablaRutas();
}

function actualizarTablaRutas() {
    const rutas = document.getElementById('cuerpo-tabla');
    if (!rutas) return;

    rutas.innerHTML = ''; 

    listaTours.forEach((lugar, index) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${index + 1}</td>
            <td>${lugar.name}</td>
        `;
        rutas.appendChild(fila);
    });
}

// Corregido: Referencia al array correcto 'listaTours'
const formConfirmarRuta = document.getElementById('form-confirmar-ruta');

if (formConfirmarRuta) {
    formConfirmarRuta.addEventListener('submit', function(e) {
        // 1. Verificamos que haya datos en nuestro array global 'listaTours'
        if (listaTours.length === 0) {
            e.preventDefault();
            alert("Debes seleccionar al menos un lugar para tu tour en Perugia.");
            return;
        }

        // 2. Localizamos el input oculto
        const puntosInput = document.getElementById('puntos-json');
        
        if (puntosInput) {
            // Marshalling: Convertimos el array de objetos Lugar a una cadena JSON
            puntosInput.value = JSON.stringify(listaTours);
            console.log("Itinerario serializado listo para enviar.");
        } else {
            console.error("Error técnico: No se encontró el elemento #puntos-json en el DOM.");
            e.preventDefault();
        }
        
        // El formulario se enviará de forma natural al controlador de Laravel
    });
}


createMarkerOnClick();

if (formulario) {
    formulario.addEventListener('submit', (e) => {
        e.preventDefault();
        getCoordsByName(placeName.value);
    });
}