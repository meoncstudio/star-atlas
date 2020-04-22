
<?php

ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

require('function.php');


Head("Star Atlas | To see a world in a wild flower, and a starry sky in wonders yet to discover.");
Body_Pre();
?>

<div class="banner-index" id="banner" style="height: 500px;">
<div class="container">
<div class="row">
<div id="bgt" class="col m12 s12" style="padding-top: 120px;">
<div>
<div id="title" style="font-size: 40px; line-height: 100px;" class="flow-text">To see a world in a wild flower, and a starry sky in wonders yet to discover.</div>
<div id="info" style="font-size: 16px; line-height: 100px;" class="flow-text"><a class="waves-effect waves-dark hower btn-large purple darken-3 white-text flow-text z-depth-5 pulse" href="?t=user">Start</a></div>
</div>
</div>

</div>
</div>
</div>

<script>

var clientHeight = window.innerHeight;

bannerSize();

function bannerSize(){
var bannerH = clientHeight - 50;
document.getElementById("banner").style.height = bannerH + "px";
var leaveHeight = (bannerH - document.getElementById("title").offsetHeight) / 2 - 65 ;
document.getElementById("bgt").style.paddingTop = leaveHeight + "px";
}

window.onresize = function(){
bannerSize();
}

//alert(leaveHeight);

</script>


<div class="container">
<p class="right-align">Latest update：2017-8-28</p>
<div class="row">
<div class="col s12">

<div class="card-panel z-depth-2 valign-wrapper pink-text text-lighten-1">
<div class="col s12 m2" >
<img alt="Space" class="circle responsive-img" src="<?php echo SAurl ?>img/space.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
Newton’s Framework
</p>
<p class="flow-text">
Quantum Physics
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Hologram two dimensional theory
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Special Relativity
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper blue-text text-lighten-1">
<div class="col s12 m2" >
<img alt="Time" class="circle responsive-img" src="<?php echo SAurl ?>img/time.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
Spacetime
</p>
<p class="flow-text">
Entropy
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Big bang
</p>
<p class="flow-text">
Standard time
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Time travel
</p>
<p class="flow-text">
Magnus phenomenon
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper grey-text text-darken-1">
<div class="col s12 m2" >
<img alt="Quantum jump" class="circle responsive-img" src="<?php echo SAurl ?>img/quantumtransition.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
Double slit test
</p>
<p class="flow-text">
Schrodinger equation
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Ghost effect
</p>
<p class="flow-text">
Baer’s entanglement machine
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Teleportation through entanglement
</p>
<p class="flow-text">
Quantum computer
</p>
</div>
</div>


<div class="card-panel z-depth-2 valign-wrapper purple-text text-lighten-1">
<div class="col s12 m2" >
<img alt="Cosmos" class="circle responsive-img" src="<?php echo SAurl ?>img/universe.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
The solar system
</p>
<p class="flow-text">
Classification, Characteristics and Survival Condition of planets
</p>
<p class="flow-text">
Solar Eclipse and Lunar Eclipse
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Dark Matter and Dark Energy
</p>
<p class="flow-text">
The interpretation of Warm holes/White holes/Black holes
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Meteor shower
</p>
<p class="flow-text">
The controversy over the inner and outer nebulae of the Milkyway 
</p>
<p class="flow-text">
Multiverse
</p>
</div>
</div>

<div class="card-panel z-depth-2 valign-wrapper orange-text text-lighten-1">
<div class="col s12 m2" >
<img alt="Literature" class="circle responsive-img" src="<?php echo SAurl ?>img/literature.png" />
</div>
<div class="col s12 m3" >
<p class="flow-text">
The Development of Classical Physics Study
</p>
<p class="flow-text">
The revolution of modern learning and thinking
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
Religions and Science
</p>
<p class="flow-text">
The literary renovation of the four parts mentioned
</p>
</div>
<div class="col s12 m3" >
<p class="flow-text">
How WWI and WWII influenced science
</p>

</div>
</div>

</div>
</div>
</div>

<?

Body_Post();

?>