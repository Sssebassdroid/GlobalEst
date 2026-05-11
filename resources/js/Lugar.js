import { Coordenada } from "./Coord";

export class Lugar extends Coordenada{
    constructor(id, name, display_name, lat, long, importance, city, osm_type, osm_id){
        super(lat,long)
        this.id = id;
        this.name = name;
        this.display_name = display_name;
        this.importance = importance;
        this.city = city;
        this.osm_id = osm_id;
        this.osm_type = osm_type;
    }
}