<?php
		readfile("incdir/charset.php");
		
		session_start();
		
		$_SESSION["Act"] = 0;
		$_SESSION["Sid"] = -1;
	
		if ($_SESSION["returnid"] == "100") {
			$retid = 100;
		}
	
		if ($_SESSION["returnid"] == "101") {
			$retid = 101;
		}
		
		
		session_unset();
		session_destroy();
		
		session_start();
		
		if ($retid == 100) {
			$_SESSION["returnmsg"] = "Usuário e senha não conferem."; 
		}
		
		if ($retid == 101) {
			$_SESSION["returnmsg"] = "Sessão encerrada."; 
		}
		
		header("Location:../logpag.php");

?>