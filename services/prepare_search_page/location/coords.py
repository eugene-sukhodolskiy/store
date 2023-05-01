import json

earth_km = 40075
coords_lng_km_table = {}

def init_coords_lng_km_table(table_json):
	print("Init coords lng-km table")
	with open(table_json, "r") as f:
		coords_lng_km_table = json.load(f)

	return coords_lng_km_table
	pass

def get_coords_square(start_lat, start_lng, radius_km):
	global coords_lng_km_table, earth_km

	lng_earth_km = coords_lng_km_table[round(abs(start_lat))] / 1000
	radius_lat = radius_km / earth_km * 360
	radius_lng = radius_km / lng_earth_km

	return [
		{
			"lat": start_lat - radius_lat / 2,
			"lng": start_lng - radius_lng / 2,
		},
		{
			"lat": start_lat + radius_lat / 2,
			"lng": start_lng + radius_lng / 2,
		}
	]
	pass

def convert_distance_to_angle(start_lat, distance_km):
	global coords_lng_km_table, earth_km
	
	lng_earth_km = coords_lng_km_table[round(abs(start_lat))] / 1000
	distance_lat = distance_km / earth_km * 360
	distance_lng = distance_km / lng_earth_km

	return {
		"lat": distance_lat,
		"lng": distance_lng
	}
	pass