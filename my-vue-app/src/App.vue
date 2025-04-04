<style>
body{
	background-color: #001117;
}
p{
	display: inline;
	color: #FFF;
}
input{
	margin: 2px 7px 2px 7px;
}

button{
	margin: 2px;
	border-radius: 1%;
	border-color: white;
	background-color: #001117;
	color: white;
}

#inputs{
	position: fixed;
	top: 20px;
	left: 0px;
	padding: 10px;
	margin: 15px;
	border-radius: 1%;
	border: 5px solid white;
	width: 300px;
}
#outputs{
	position: fixed;
	top: 20px;
	right: 0px;
	padding: 10px;
	margin: 15px;
	border-radius: 1%;
	border: 5px solid white;
	width: 350px;

}
canvas{
	background-color: #001117;
}
</style>
<template>
	<div id="inputs">
		<p>Pretestības momenta un pieļaujamās slodzes kalkulators</p> <br>
		<p>Garums</p><input id="length" placeholder="6m" value=6> <br>
		<p>Platums</p><input id="width" placeholder="0.1m" value=0.1> <br>
		<p>Augstums</p><input id="height" placeholder="0.3m" value=0.3> <br>
		<p>Stiprība</p><input id="stiffness" placeholder="ulala" value=20000> <br>
		<button id="calc" @click="calculate()">Aprēķināt W un q</button>
	</div>
	<div id="outputs">
		<p id="results">Pretestības moments: ? <br>Pieļaujamā slodze: ?</p>
	</div>
</template>

<script setup>
import * as THREE from 'three';

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer();

renderer.setSize( 1200, 1200);
document.body.appendChild(renderer.domElement);

var geometry = new THREE.BoxGeometry( 0.1, 0.3, 6 );
const material = new THREE.MeshBasicMaterial( { color: 0xA47449 } );
const cube = new THREE.Mesh( geometry, material );
scene.add( cube );

camera.position.z = 5;
cube.rotation.x += 0.5;
cube.rotation.y += 0.5;	

function animate(){
	geometry = new THREE.BoxGeometry(parseFloat(document.getElementById("width").value), parseFloat(document.getElementById("height").value), parseFloat(document.getElementById("length").value))
	cube.geometry = geometry;
	renderer.render( scene, camera );

}
renderer.setAnimationLoop( animate );
async function calculate(){
	var L = document.getElementById("length").value;
	var B = document.getElementById("width").value;
	var H = document.getElementById("height").value;
	var f = document.getElementById("stiffness").value;
	
        var requestData = new FormData();
	requestData.append("L", L);
	requestData.append("B", B);
	requestData.append("H", H);
	requestData.append("f", f);

        var request = await fetch("/api/calculate.php", {
		body: requestData,
                method: "POST",
	});

	if(await !request.ok){
		return;
	}
	
	var response = JSON.parse(await request.text());
	
	var results = document.getElementById("results");
	results.innerHTML = "Pretestības moments: " + response.W + "<br>Pieļaujamā slodze: " + response.q;
	
	
}
</script>
