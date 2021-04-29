<?php

include("incdir/conn.php");

session_start();

$conn = new mysqli(servername, username, password, dbname);

mysqli_set_charset($conn, "LATIN1");
mysqli_query($conn, "SET NAMES 'LATIN1'");
mysqli_query($conn, "SET character_set_connection=LATIN1'");
mysqli_query($conn, "SET character_set_client=LATIN1'");
mysqli_query($conn, "SET character_set_results=LATIN1'");

	$sql =  "SELECT sid FROM lista WHERE matricula='$_SESSION[Ident]'";
	$resultado = mysqli_query($conn, $sql);
	$dados = mysqli_fetch_array($resultado);

if (($_SESSION["Sid"] != $dados["sid"]) or ($_SESSION["Act"] == 0)) {
	header("Location:incdir/logout.php");
} 

	$sql =  "SELECT sid FROM lista WHERE matricula='$_SESSION[Ident]'";
	$resultado = mysqli_query($conn, $sql);
	$dados = mysqli_fetch_array($resultado);

if ((isset($_POST["assunto"])) and (isset($_POST["mensgm"])) and ($_SESSION["Sid"] == $dados["sid"])) {

	if ((htmlentities($_POST["assunto"]) != "" ) and (htmlentities($_POST["mensgm"])!="" )){
		
		//inicio 
		
		$sql =  "SELECT nome, email, matricula, sid FROM lista WHERE matricula='$_SESSION[Ident]'";
		$resultado = mysqli_query($conn, $sql);
		$dados = mysqli_fetch_array($resultado);
		$nome = $dados["nome"];
		$email = $dados["email"];

			$headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: " . $email . "\r\n"; // remetente
			$headers .= "Return-Path: " . $email . "\r\n"; // return-path
	
			$msgemail = "Nova mensagem interna do cliente " . $nome;
			$msgemail .= "\r\n Assunto: " . htmlentities($_POST["assunto"]);
			$msgemail .= "\r\nMensagem: " . htmlentities($_POST["mensgm"]) ."\r\n";
			$msgemail .= "\r\n ------ FIM ------";
	
			$envio = mail("tarcomurilo@gmail.com", "TM Ambiental - Mensagem de " . $nome, $msgemail, $headers);
 
		if($envio) {
			$retmsg = "Sua mensagem foi enviada."; }
			else {
				$retmsg = "Sua mensagem não foi enviada. Entre em contato com tarcomurilo@gmail.com";
					$_SESSION["Act"] = 2;
				}
			
		//fim
		
	$_SESSION["Act"] = 2;
	} else {
	
		$retmsg = "Você precisa inserir o assunto e a mensagem.";
		$_SESSION["Act"] = 2;
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
			<?php readfile("faixasupc.php" )?>
			</div>
		
		<div id="caixafundo3" >
		<div id="secaocont4">
		
	<?php
			if ($_SESSION["Sid"] == $dados["sid"]) {

			
				if ($_SESSION["Act"] < 10) {
					
					echo "<div id=\"nmltext\">Você está na área exclusiva para clientes da TM Consultoria Ambiental.<br>";
					echo "Nesta página você pode entrar em contato direto conosco de forma mais simples e rápida.<br>";
					echo "Após o envio da mensagem, responderemos até às 12 h do dia seguinte, exceto domingos e feriados.<br>";
					echo "Fique a vontade para conversar conosco.<br></div>";
						
					if ($_SESSION["Act"] == 2){
					
						echo "<div id=\"bldtext2\">" .  $retmsg ."</div>";
						$_SESSION["Act"] = 1;
					}
						
					if ($_SESSION["Act"] == 1){
						
						echo "<form action=\"contint.php\" method=\"POST\"><table id=\"table1\" style=\"width:400px; height:300px\" rules=\"all\">
						<tr><td style=\"width:100px; height:35px;\" rules=\"all\"><div id=\"nmltext\">Assunto: </div></td><td>&nbsp;<input type=\"text\" name=\"assunto\" style=\"width:285px;\"></td></tr>
						<tr><td style=\"width:100px\" rules=\"all\"><div id=\"nmltext\">Mensagem: </div></td><td>&nbsp;<textarea name=\"mensgm\" rows=\"16\" cols=\"38\"></textarea></td></tr>
						</table>&nbsp;&nbsp;<input type=\"submit\" value=\"Enviar\" style=\"width:150px\"></form>";
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