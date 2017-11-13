<!DOCTYPE html>
<html>
<head>
<title>Price estimation</title>

  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

	<style>
	.center {
    margin: auto;
    width: 60%;
    padding: 10px;
}
	</style>
</head>
<body>

  <!-- Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">AirBbB Optimizer</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Maps
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="google_advanced_map_pr.php">Private rooms listing prices</a>
          <a class="dropdown-item" href="google_advanced_map_sr.php">Shared rooms listing prices</a>
          <a class="dropdown-item" href="google_advanced_map_eh.php">Entire home listing prices</a>
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="price_estimation.php">Price Estimator</a>
      </li>
	  
      <li class="nav-item">
        <a class="nav-link" href="bookings_optimization.php">Bookings optimizer</a>
      </li>
    </ul>

  </div>
</nav>
 <!-- End menu -->
<div class="center">
<h1>Enter longitude and latitude</h1>
<p>in order to get the ideal price per night for your property.</p>
</div>

<?php

# Connect to MySQL database
$conn = new PDO('mysql:host=localhost;dbname=airbnb_opt','root','');
# Build SQL SELECT statement including x and y columns


$ls_price =0;
$wk_price =0;

if (isset($_GET['latitude'],$_GET['longitude'],$_GET['room_type'])){
	
$latitude=$_GET['latitude'];
$longitude=$_GET['longitude'];
$room_type=$_GET['room_type'];

// Get neighbourhood name
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if($status=="OK") {
        //Get address from json data
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("neighborhood", $cn)) {
                $neighborhood= $data->results[0]->address_components[$j]->long_name;
            }
        }
     } else{
      // echo 'Location Not Found';
     }
    
	 
	 //Some neighborhood names are shortened on the database. Here fixing the name I'm getting from Google geojson to macth the database's 
	 if ($neighborhood == 'Eureka Valley') {
		$neighborhood = 'The Castro';
	 } elseif ($neighborhood == 'Richmond District') {
		 $neighborhood = 'Richmond Distri';
	 	 } elseif ($neighborhood == 'Fisherman\'s Wharf') {
		 $neighborhood = 'Fisherman\'s Wha';
	 } elseif ($neighborhood == 'Western Addition') {
		 $neighborhood = 'Western Additio';
	 } elseif ($neighborhood == 'Mission District') {
		 $neighborhood = 'Mission Distric';
	 } elseif ($neighborhood == 'Financial District') {
		 $neighborhood = 'Financial';
	 }
	 

}

?>

<div class="center">

<form action= '' method='GET'>  
  Latitude:<br>
  <input type="text" name="latitude" id="id-latitude" required>
  <br>
  Longitude:<br>
  <input type="text" name="longitude" id="id-longitude" required>
  <br>
   Room type:<br>
  <select name="room_type" required>
  <option value="Private room">Private room</option>
  <option value="Entire home/apt">Entire home/apt</option>
  <option value="Shared room">Shared room</option>
</select>
  <br> <br>
  <input class="btn btn-warning" type="submit" value="Estimate"> <a href="bookings_optimization.php"><input type="button" class="btn btn-info" value="Clear"></a>
</form> 
<br>
</div>
<?php
# Try query or error

if (isset($latitude, $longitude,$room_type)){

// On this query I'm getting the average listing price per neighborhood, also considering the type of room. 	
$sql = "SELECT AVG(round(price)) as newPrice,`neighbourhood`,latitude,longitude, room_type,id FROM listings WHERE room_type= '$room_type' AND `neighbourhood` = '$neighborhood' GROUP BY `neighbourhood`";

$rs = $conn->query($sql);

# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
	$ls_price = $row['newPrice'];
}

// Here I get the average weekly price the host could earn based on the listing price multiplied by seven. On this formula no discount is given.  
//$wk_price = ($ls_price * 7);

//$wk_price = (($ls_price * 7) -(($ls_price *7) * 0.15));
$ls_price = $ls_price;

echo 'What is the ideal price per night that will give you maximum revenue?';
echo '<br>';
echo 'The average listing price for your area is: $';
echo '<br>';
echo  round($ls_price);
echo '<br>';
echo 'If you increase your property\'s price greater than average the bookings will drop.';
echo '<br>';
echo 'Revenue for 1 booking a week at a 15% above than average rate would be: ';
echo '<br>';
echo $gta = round(((($ls_price) * 0.15)  + $ls_price));

echo '<br>';
echo 'If you decrease your property\'s price lower than average the bookings will increase.';
echo '<br>';
echo 'Revenue for 2 booking a week at a 15% above than average rate would be: ';
echo '<br>';
echo $lta = round((($ls_price -($ls_price * 0.15)) * 2));
echo '<br>';
echo 'The ideal price per night is: ';

if ($gta > $lta) {
	echo '<b>'.$gta.'</b>';
} else {
	echo '<b>$'.($lta/2).'</b>';
}

}

?>


<script type="text/javascript" src="js/price_est.js"></script>

 <!-- jQuery link -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 
 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</body>



</html>