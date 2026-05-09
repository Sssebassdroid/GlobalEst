export class Coordenada {
    constructor(lat, long) {
        this.lat = parseFloat(lat);
        this.long = parseFloat(long);

        if (isNaN(this.lat) || isNaN(this.long)) {
            throw new Error("Los valores de latitud y longitud deben ser números.");
        }
    }

   get getLat() { return this.lat; }

    
   get getLong() { return this.long; } // Corregido lng

    toArray() {
        return [this.lat, this.long];
    }

    toObject() {
        return { lat: this.lat, long: this.long };
    }

    isValid() {
        return this.lat >= -90 && this.lat <= 90 && this.long >= -180 && this.long <= 180;
    }
}