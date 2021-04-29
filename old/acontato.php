<?php

include("incdir/conn.php");

session_start();

$conn = new mysqli(servername, username, password, dbname);

mysqli_set_charset($conn, "LATIN1");
mysqli_query($conn, "SET NAMES 'LATIN1'");
mysqli_query($conn, "SET character_set_connection=LATIN1'");
mysqli_query($conn, "SET character_set_client=LATIN1'");
mysqli_query($conn, "SET character_set_results=LATIN1'");

	$sql =  "SELECT sid, usrtyp FROM lista WHERE matricula='$_SESSION[Ident]'";
	$resultado = mysqli_query($conn, $sql);
	$dados = mysqli_fetch_array($resultado);

if (($_SESSION["Sid"] != $dados["sid"]) or ($_SESSION["Act"] == 0) or  ($_SESSION["Usrtyp"] <> "g5d8b2f8")) {
	header("Location:incdir/logout.php");
} 

if ((isset($_POST["assunto"])) and (isset($_POST["mensgm"])) and ($_SESSION["Sid"] == $dados["sid"])) {
	
	if ((htmlentities($_POST["assunto"]) != "" ) and (htmlentities($_POST["mensgm"])!="" )){
		
		
		
		$retmsg = "Sua mensagem foi enviada.";
		
	
	} else {
	
		$retmsg = "Você precisa inserir o assunto e a mensagem.";
		
	}
	
	//enviar mensagem
	$_SESSION["Act"] = 2;	
	
} else {

		$_SESSION["Act"] = 1;
		$retmsg ="";

}



readfile("incdir/charset.php");

?> 



<html>
	<head>

		<title>Área do Cliente - TM Consultoria Ambiental</title>
		<link rel="stylesheet" type="text/css" href="estilo/estilo1.css">
	</head>
	<body>

		<div id="boxfundo" ></div>
		<div id="faixacentral">
		
			<div id="secaosup">
			<?php readfile("faixasupa.php" )?>
			</div>
		
		<div id="caixafundo3" >
		<div id="secaocont4">
		
	<?php
			if ($_SESSION["Sid"] == $dados["sid"]) {
				
				
			
				if ($_SESSION["Act"] < 10) {
					
					echo "<div id=\"nmltext\">Você está na área exclusiva para administradores da TM Consultoria Ambiental.<br>";
					echo "Nesta página você pode entrar em com todos os clientes de forma rápida.<br>";
					echo "Envio de mensagens de texto para vários clientes e mensagens direto no site.<br>";
					echo "</div>";
						
					if ($_SESSION["Act"] == 1){
						
						echo "<form action=\"contint.php\" method=\"POST\"><table id=\"table1\" style=\"width:400px; height:300px\" rules=\"all\">
						<tr><td style=\"width:100px; height:35px;\" rules=\"all\"><div id=\"nmltext\">Assunto: </div></td><td>&nbsp;<input type=\"text\" name=\"assunto\" style=\"width:285px;\"></td></tr>
						<tr><td style=\"width:100px\" rules=\"all\"><div id=\"nmltext\">Mensagem: </div></td><td>&nbsp;<textarea name=\"mensgm\" rows=\"16\" cols=\"38\"></textarea></td></tr>
						</table>&nbsp;&nbsp;<input type=\"submit\" value=\"Enviar\" style=\"width:150px\"></form>";
					}	
					
					if ($_SESSION["Act"] == 2){
						
						echo "<div id=\"bldtext2\">" .  $retmsg ."</div><form action=\"contint.php\" method=\"POST\"><table id=\"table1\" style=\"width:400px; height:300px\" rules=\"all\">
						<tr><td style=\"width:100px; height:35px;\" rules=\"all\"><div id=\"nmltext\">Assunto: </div></td><td>&nbsp;<input type=\"text\" name=\"assunto\" style=\"width:285px;\"></td></tr>
						<tr><td style=\"width:100px\" rules=\"all\"><div id=\"nmltext\">Mensagem: </div></td><td>&nbsp;<textarea name=\"mensgm\" rows=\"16\" cols=\"38\"></textarea></td></tr>
						</table>&nbsp;&nbsp;<input type=\"submit\" value=\"Enviar\" style=\"width:150px\"></form>";
						$_SESSION["Act"] = 1;
					}	
						
						
				}

				
			}	
		
	?>


	
<?php 

mysqli_close($conn); 
?>
</div></div>
</div>
	</body>

</html>