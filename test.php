<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.mySlides {display:none;}
</style>
<body>

<h2 class="w3-center">Manual Slideshow</h2>

<div class="w3-content w3-display-container">
  <img class="mySlides" src="img_snowtops.jpg" style="width:100%">
  <img class="mySlides" src="img_lights.jpg" style="width:100%">
  <img class="mySlides" src="img_mountains.jpg" style="width:100%">
  <img class="mySlides" src="img_forest.jpg" style="width:100%">

  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>

**SCRIPT CODES**
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>

</body>
</html>


**//CSS CODES**
/* Slideshow container */
.slideshow-container {
  height:500px;
  position: relative;
  margin: auto;
  with:800px;
}

/* Hide the images by default */
.mySlides {
    display: none;
}


/* Next & previous buttons */
.prev, .next {
    background-color:gold;
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 20px;
  color: black;
  font-weight: bold;
  font-size: 24px;
  transition: 0.6s ease;
  border-radius: 7 7px 7px 7;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
  color:white;
}

/* Caption text */
.text {
  color:lime;
  font-size: 22px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color:lime;
  font-size: 22px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #000000;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.2s ease;
}

.active, .dot:hover {
  background-color: #ff0101;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 0.2s;
  animation-name: fade;
  animation-duration: 6.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}