<?php

$DB_serveur = 'localhost';
$DB_utilisateur = 'root';
$DB_motdepasse = '';
$DB_base = 'sg3';

$default_char_rank = "Admin";//Admin / GameMaster / Player / Bot / Banned
$default_char_level = 45; //0-45
$default_char_exp = 102400; //0-102400
$default_char_liscence = 4; //0-4
$default_char_tricks = "5|4|5|5|4|3|3|3|3|5|0|3|1"; //max "5|4|5|5|4|3|3|3|3|5|0|3|1"
$default_char_gpotatos = 999999999;// 0-999 999 999
$default_char_rupees = 999999999;// 0-999 999 999
$default_char_coins = 999999999;// 0-999 999 999
$default_char_questpoints = 999999999;// 0-999 999 999

$default_char_age = 20;
$default_char_bio = "BIO";
$default_char_zoneid = 0;
$default_char_zoneinfo = "ZONE INFO";


//NE PLUS MODIFIER DE PARAMETRES APRES CETTE LIGNE


$pdo = new PDO('mysql:host='.$DB_serveur.';dbname='.$DB_base,$DB_utilisateur,$DB_motdepasse,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

function checkPostEntry($entry)
{
	if(isset($_POST[$entry]))
	{
		if($_POST[$entry] != "" && $_POST[$entry] != NULL)
			return true;
	}
	return false;	
}

if(!checkPostEntry("login") || !checkPostEntry("iglogin") || !checkPostEntry("pass") || !checkPostEntry("email"))
	{
		//Manque d'informations ou infos vides.
		goto fin;
	}

if($_POST["pass"] != $_POST["pass2"])
	{
		//les mots de passe ne correspondent pas
		header("location:../register.php?err=p");
		exit;
	}
	
	$login = htmlspecialchars($_POST["login"]);
	$iglogin = htmlspecialchars($_POST["iglogin"]);
	$motdepasse = htmlspecialchars($_POST["pass"]);
	$email = htmlspecialchars($_POST["email"]);
	
	$motdepasse = md5($motdepasse);
	
	$sql = "INSERT INTO sg_account (`user`, `password`, `username`, `email`, `first_login`, `char_rank`, `char_type`, `char_level`, `char_exp`, `char_liscence`, `char_tricks`, `char_gpotatos`, `char_rupees`, `char_coins`, `char_questpoints`, `char_clanid`, `char_clanname`, `char_age`, `char_bio`, `char_zoneid`, `char_zoneinfo`) VALUES ('$login', '$motdepasse', '$iglogin', '$email', 'authkey', '$default_char_rank', '0', $default_char_level, $default_char_exp, $default_char_liscence, '$default_char_tricks', $default_char_gpotatos, $default_char_rupees, $default_char_coins, $default_char_questpoints, NULL, NULL, $default_char_age, '$default_char_bio', $default_char_zoneid, '$default_char_zoneinfo');
	";
	
	
	$nb = $pdo->exec($sql);
	
	if($nb==1)
		echo("ok");//Que faire si l'inscription a réussi ?
	else
		echo("problème lors de l'inscription");//Que faire si elle a échoué ?
	
	exit;
	fin:
	
	if(isset($_GET["err"]))
		if(strcmp($_GET["err"],"p")==0)
			echo '<p color="red"> Les mots de passe ne correspondent pas </p><p></p>';
?>

<!doctype HTML>
<html>
<head>
	<style type="text/css">
	/* CSS Document */

* {
  margin: 0;
  padding: 0;
}

body {
	background-color: white;
	color: #435160;
	font-family: "Open Sans", sans-serif;
	background-image: url(Bg.jpg);
}

h2 {
	color: #6D7781;
	font-family: Coalition;
	font-size: 15px;
	font-weight: bold;
	font-size: 40px;
	text-align: center;
	margin-bottom: 20px;
}

a {
  color: #435160;
  text-decoration: none;
}

.login {
  width: 350px;
  position: absolute;
  top: 10%;
  left: 50%;
  margin-left: -175px;
}

input[type="text"], input[type="password"] {
  width: 350px;
  padding: 20px 0px;
  background: transparent;
  border: 0;
  border-bottom: 1px solid #435160;
  outline: none;
  color: #6D7781;
  font-size: 16px;
}
input[type=checkbox] {
  display: none;
}

label {
  display: block;
  position: absolute;
  margin-right: 10px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: transparent;
  content: "";
  transition: all 0.3s ease-in-out;
  cursor: pointer;
  border: 3px solid #435160;
}

#agree:checked ~ label[for=agree] {
  background: #435160;
}

input[type="submit"] {
  background: #1FCE6D;
  border: 0;
  width: 350px;
  height: 40px;
  border-radius: 3px;
  color: #fff;
  font-size: 12px;
  cursor: pointer;
  transition: background 0.3s ease-in-out;
}
input[type="submit"]:hover {
  background: #16aa56;
  animation-name: shake;
}

.forgot {
  margin-top: 30px;
  display: block;
  font-size: 11px;
  text-align: center;
  font-weight: bold;
}
.forgot:hover {
  margin-top: 30px;
  display: block;
  font-size: 11px;
  text-align: center;
  font-weight: bold;
  color: #6D7781;
}

.agree {
  padding: 30px 0px;
  font-size: 12px;
  text-indent: 25px;
  line-height: 15px;
}

::-webkit-input-placeholder {
  color: #435160;
  font-size: 12px;
}

.animated {
  animation-fill-mode: both;
  animation-duration: 1s;
}

@keyframes shake {
  0%, 100% {
    transform: translateX(0);
  }
  10%, 30%, 50%, 70%, 90% {
    transform: translateX(-10px);
  }
  20%, 40%, 60%, 80% {
    transform: translateX(10px);
  }
}
	</style>
</head>
<body>
<form action="register.php" method="post">
<div class="login">
<h2>inscription</h2>
<input name="login" placeholder="nom d'utilisateur" type="text">
<input name="iglogin" placeholder="pseudo ingame" type="text">
<input id="pw" name="pass" placeholder="mot de passe" type="password">
<input id="pw" name="pass2" placeholder="répeter mot de passe" type="password">
<input name="email" type="text" placeholder="addresse mail">
<div class="agree" name="agree" type="checkbox">
  <input id="agree" name="agree" type="checkbox">
</div>
<input class="animated" type="submit" value="Inscription">
</div>
</form>
</body>
</html>