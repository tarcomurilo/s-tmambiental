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
			$_SESSION["returnmsg"] = "Usu�rio e senha n�o conferem."; 
		}
		
		if ($retid == 101) {
			$_SESSION["returnmsg"] = "Sess�o encerrada."; 
		}
		
		header("Location:../logpag.php");

?>