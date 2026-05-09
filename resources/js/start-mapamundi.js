var map = L.map('mapamundi', {
    attributionControl: false 
}).setView([30, 0], 2);


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
