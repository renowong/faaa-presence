<?php
//session_start();
//session_destroy();
include_once('config.php');

if($_GET['logout']==1){setcookie("user","",time()-1);}

if($_COOKIE['user']>0){header("Location: presence.php");}

?>
<html>
	<head>
		<style type="text/css">@import url("css/main.css");</style>
		<!-- jquery -->
		<script type="application/x-javascript" src="js/jquery-1.7.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			//alert(document.cookie);
			//document.cookie = "user=";
			//document.cookie = "nom=";
			//document.cookie = "prenom=";
			//document.cookie = "login=";
			//document.cookie = "svc=";
		});
		
		function auth(){
			var login = $("#login").val();
			var password = $("#password").val();
			$.post("auth.php", {login:login,password:password},
			function(response) {
			readresponse(response);
			//alert(response);
			},'xml');
		}
		
		function reset() {
			$("#login").val("");
			$("#password").val("");	
		}
		
		function readresponse(xml){
			$(xml).find("response").each(function(){
			    var access = $(this).find("access").text();
			    var id = $(this).find("userid").text();
			    var login = $(this).find("login").text();
			    var nom = $(this).find("nom").text();
			    var prenom = $(this).find("prenom").text();
			    var svc = $(this).find("svc").text();
			    //alert(svc);
			    if(access=="OK"){
				//alert("access ok");
				var today = new Date();
				today.setTime( today.getTime() );
				expires = 1000 * 60 * 60 * 12;
				var expires_date = new Date( today.getTime() + (expires) );
				
				document.cookie = "user="+id+";expires=" + expires_date.toGMTString();
				//alert(today.toGMTString());
				//alert("user="+id+";expires=" + expires_date.toGMTString());
				document.cookie = "nom="+nom;
				document.cookie = "prenom="+prenom;
				document.cookie = "login="+login;
				document.cookie = "svc="+svc;
				window.location = "presence.php";
			    }else{
				alert(access);
			    }
			});
		}
		
		function checkenter(e){
			var unicode=e.keyCode? e.keyCode : e.charCode
			if(unicode=="13"){
			    auth();
			}
		}
		</script>
	</head>
	<body onload="document.getElementById('login').focus();">
		<div name="message" id="message" ></div>
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		<div name="divlogin" id="divlogin">
			<table name="tbllogin" id="tbllogin" class="tblform">
				<thead>
					<tr>
						<th colspan="2">Pr&eacute;sence</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Utilisateur</td><td class="inputbox"><input type="text" name="login" id="login" value="" maxlength="10" size="20" onkeydown="checkenter(event);"/></td>
					</tr>
					<tr>
						<td>Mot de passe</td><td class="inputbox" ><input type="password" name="password" id="password"value="" maxlength="10" size="20" onkeydown="checkenter(event);"/></td>
					</tr>
					<tr>
						<td colspan="2" class="inputbox"><input type="button" name="reset" id="reset" value="Annuler" onclick="reset()" /><input type="button" name="submit" id="submit" value="Entrer" onclick="auth()" /></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
<html>
