
<script>
async function makeRequest(requestData, url, method){
    var request = await fetch(url, {
        body: requestData,
        method: method
    });
    return await request;
}
function login(){
    var name = document.getElementById("loginName").value;
    var pass = document.getElementById("loginPass").value;
    var requestData = new FormData();
    requestData.append("name", name);
    requestData.append("pass", pass);
    response = makeRequest(requestData, "/api/login.php", "POST");
}
function register(){
    var name = document.getElementById("registerName").value;
    var pass = document.getElementById("registerPass").value;
    var requestData = new FormData();
    requestData.append("name", name);
    requestData.append("pass", pass);
    response = makeRequest(requestData, "/api/register.php", "POST");
}
</script>
<template>
 <body>
  <div id="authbox">
   <div id="regBox">
     <h3> Register </h3>
     <input id="registerName" placeholder="Username"/>
     <input id="registerPass" placeholder="Password"/>
     <button onclick="register()">
   </div>
   <hr/>
   <div id="logbox">
     <h3> Login </h3>
     <input id="loginName" placeholder="Username"/>
     <input id="loginPass" placeholder="Password"/>
     <button onclick="login()">
   </div>
  </div>
 </body>
</template>
<style>
  #authbox{
    display: flex;
  }
  #regBox{
    display: block;
  }
  #logBox{
    display: block;
  }
</style>
