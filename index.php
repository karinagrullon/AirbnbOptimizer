<!doctype html>
<html lang="en">
  <head>
    <title>AirBbB Optimizer</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <style>
  body {
    background-image: url("images/sf.jpg");
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
 
 
 <!-- Cards -->
 <br>
  <br> 

<div class="card text-white bg-warning mb-3" style="max-width: 20rem;">
  <div class="card-header">Maps</div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text">Get an overview of AirBnB listing prices according to:</p>
	 <a href="google_advanced_map_pr.php" class="card-link">Private rooms</a>
	 <a href="google_advanced_map_sr.php" class="card-link">Shared rooms</a>
	 <a href="google_advanced_map_eh.php" class="card-link">Entire home</a>
  </div>
  
</div>
<div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
  <div class="card-header">Price Estimator</div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text">Estimate your weekly average income on Airbnb.</p>
	 <a href="price_estimation.php" class="card-link">Here</a>
  </div>
</div>
<div class="card text-white bg-success mb-3" style="max-width: 20rem;">
  <div class="card-header">Bookings optimizer</div>
  <div class="card-body">
    <h4 class="card-title"></h4>
    <p class="card-text">Get the ideal price per night that will yield maximum revenue.</p>
	 <a href="bookings_optimization.php" class="card-link">Here</a>
  </div>
 
 
 <!-- End cards -->
 


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>