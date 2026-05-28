function renderItinerary(puntos) {
    const tabla = document.getElementById('cuerpo-tabla');
    const inputOculto = document.getElementById('itinerario-temporal'); // Asegúrate que el ID en Blade coincida

    // Dibujamos la tabla visual para el usuario
    if (tabla) {
        tabla.innerHTML = puntos.map((lugar, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${lugar.display_name}</td>
            </tr>
        `).join('');
    }

    // Inyectamos el JSON en el input oculto para que Laravel lo reciba por POST
    if (inputOculto) {
        inputOculto.value = JSON.stringify(puntos);
        console.log("Payload JSON listo para el servidor.");
    }
}
function checkAndClearStorage() {
    // Buscamos si existe el mensaje de éxito en el DOM
    // Ajusta el selector si tu alerta tiene otra clase (ej: .alert-success o #success-msg)
    const successMessage = document.querySelector('.alert-success') || 
                           document.body.innerText.includes('¡Tour creado exitosamente!');

    if (successMessage) {
        console.log("Detectado éxito en el servidor. Purgando LocalStorage...");
        localStorage.removeItem('itinerario_temporal');
        
        // Opcional: También puedes limpiar la variable en memoria si fuera necesario
        // listaTours = []; 
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // 1. Intentamos leer la memoria del navegador
    const data = localStorage.getItem('itinerario_temporal');
    const puntos = data ? JSON.parse(data) : [];

    // 2. Seguridad: Si el usuario intenta entrar a la fuerza sin puntos, lo expulsamos
    if (puntos.length === 0 && window.location.pathname.includes('create-tour')) {
        console.warn("Acceso ilegal a create-tour sin datos en LocalStorage.");
        window.location.href = '/places';
        return;
    }
    renderItinerary(puntos);
    checkAndClearStorage();

    
});