<?php
/*
 * Title:   MySQL Points to GeoJSON
 * Notes:   Query a MySQL table or view of points with x and y columns and return the results in GeoJSON format, suitable for use in OpenLayers, Leaflet, etc.
 * Author:  Bryan R. McBride, GISP
 * Contact: bryanmcbride.com
 * GitHub:  https://github.com/bmcbride/PHP-Database-GeoJSON
 */
# Connect to MySQL database
$conn = new PDO('mysql:host=localhost;dbname=airbnb_opt','root','');
# Build SQL SELECT statement including x and y columns
$sql = "SELECT AVG(round(price)) as newPrice,neighbourhood_cleansed,latitude,longitude, room_type,id,room_type FROM listings WHERE price >= 0 and price <= 1000 && room_type='Private room' GROUP BY neighbourhood_cleansed,room_type";
/*
* If bbox variable is set, only return records that are within the bounding box
* bbox should be a string in the form of 'southwest_lng,southwest_lat,northeast_lng,northeast_lat'
* Leaflet: map.getBounds().pad(0.05).toBBoxString()
*/
$weight = 0;
if (isset($_GET['bbox']) || isset($_POST['bbox'])) {
    $bbox = explode(',', $_GET['bbox']);
  //  $sql = $sql . ' WHERE x <= ' . $bbox[2] . ' AND x >= ' . $bbox[0] . ' AND y <= ' . $bbox[3] . ' AND y >= ' . $bbox[1];
}
# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}
# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	
	
	
	// Getting weight value for heatmap according to listing price
	if ($row['newPrice'] >= 77 && $row['newPrice'] <= 95) {
		$weight = 2;
	} elseif ($row['newPrice'] >= 96 && $row['newPrice'] <= 113) {
						$weight = 3;
	} elseif ($row['newPrice'] >= 114 && $row['newPrice'] <= 131) {
							$weight = 4;
	} elseif ($row['newPrice'] >= 132 && $row['newPrice'] <= 149) {
							$weight = 5;
	} elseif ($row['newPrice'] >= 150 && $row['newPrice'] <= 168) {
							$weight = 6;
	}
	
    $properties = $row;
    # Remove x and y fields from properties (optional)
    // unset($properties['x']);
    // unset($properties['y']);
    $feature = array(
        'type' => 'Feature',
		'properties' => array(
			'mag' => $weight,
            'room_type' => $row['room_type'],
        ),
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array(
                $row['longitude'],
                $row['latitude'],
            ),
        ),
		'id' => $row['id']
		
     //   'properties' => $properties
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}

// $brackets = array("[","]");
// $fp = fopen('data.json','w');
// //fwrite($fp, 'eqfeed_callback('.str_replace($brackets,"",json_encode($geojson, JSON_NUMERIC_CHECK)).')');
// fwrite($fp, 'eqfeed_callback('.json_encode($geojson, JSON_NUMERIC_CHECK).');');
// fclose($fp);

header('Content-type: application/json');
echo 'eqfeed_callback('.json_encode($geojson, JSON_NUMERIC_CHECK).')';
$conn = NULL;
?>