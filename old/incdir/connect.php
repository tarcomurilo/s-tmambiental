<?php
	include("conn.php");
	session_start();
	
		function userVld($user) {
		$padrao = "/^([a-zA-Z0-9]\_-]){5,}$/";
		
		if (preg_match($padrao, $user)){
			return true;
		} else {
			return false;
		}
	}
	
	$matrient = htmlentities($_POST["matricula"]);
	$senhaent = htmlentities($_POST["senha"]);
	
	if (isset($matrient)) {
		if (userVld($matrient) == false){
		header("Location:logout.php");

		}}
		
		if (isset($senhaent)) {
		if (userVld($senhaent) == false){
		header("Location:logout.php");

		}}
	
	
if ((isset($matrient)) and (isset($senhaent))) { 
	
	$conn = new mysqli(servername, username, password, dbname);
	
	$_SESSION["Rnd"] = Rand(128, 65536); 
	$_SESSION["Act"] = 0;
	$_SESSION["Ident"] = $matrient;
	$_SESSION["Sid"] = $_SESSION["Rnd"] * 50;
	$_SESSION["Usrtyp"] = "";
		
	$sql =  "SELECT sid FROM lista WHERE matricula='$_SESSION[Ident]'";
	$resultado = mysqli_query($conn, $sql);
	$dados = mysqli_fetch_array($resultado);
	
	if ($dados["sid"] <> $_SESSION["Sid"] ) {

			$sql =  "SELECT matricula, senha, cpfcnpj, usrtyp FROM lista WHERE matricula='$_SESSION[Ident]'";
			$resultado = mysqli_query($conn, $sql);
			$dados = mysqli_fetch_array($resultado);
			$matricula = $dados["matricula"];			
			$senha = $dados["senha"];
			$md5s = md5(substr($dados["cpfcnpj"], 1,5));
			
			if (($matricula == $_SESSION["Ident"]) and ($senha == md5($senhaent.$md5s))) {

				$sql =  "UPDATE lista SET sid=$_SESSION[Sid] WHERE matricula='$_SESSION[Ident]'";
				mysqli_query($conn, $sql);
				$senha = 0;
				$_SESSION["Act"] = 1;
				$_SESSION["Usrtyp"] = $dados["usrtyp"];
				
				header("Location:../perfil.php");
				
			} else {
				$sql =  "UPDATE lista SET sid=0 WHERE matricula='$_SESSION[Ident]'";
				mysqli_query($conn, $sql);
				header("Location:logout.php");
				$_SESSION["returnid"] = "100";
			} 
			
	} else {
		
			$sql =  "UPDATE lista SET sid=0 WHERE matricula='$_SESSION[Ident]'";
			mysqli_query($conn, $sql);	
			header("Location:logout.php");
			$_SESSION["returnid"] = "101";
	}
	
} else {

	header("Location:logout.php");
}
	
?>