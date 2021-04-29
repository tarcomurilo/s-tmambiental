<?php
include ("incdir/conn.php");
$conn = new mysqli(servername, username, password, dbname);
mysqli_set_charset($conn, "LATIN1");
mysqli_query($conn, "SET NAMES 'LATIN1'");
mysqli_query($conn, "SET character_set_connection=LATIN1'");
mysqli_query($conn, "SET character_set_client=LATIN1'");
mysqli_query($conn, "SET character_set_results=LATIN1'");

	readfile("incdir/charset.php");

	function emailVld($email) {
		
		$padrao = "/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+.([a-zA-Z]{2,4})$/";
		
		if (preg_match($padrao, $email)) { 
		return true;
		} else {
		return false;
		}
			
	}
	
	function userVld($user) {
		$padrao = "/^([a-zA-Z0-9]\_-]){5,}$/";
		
		if (preg_match($padrao, $user)){
			return true;
		} else {
			return false;
		}
	}
	
	
$vir = 0;

$erromsg = "Responderemos em menos de 24 horas.";

if ($_POST <> null){
	
	if (htmlentities($_POST["wf"])== "e") {
	if  ((htmlentities($_POST["enome"]) =="" ) or (htmlentities($_POST["eemail"]) =="" ) or (htmlentities($_POST["eassunto"]) =="" ) or (htmlentities($_POST["emensagem"]) =="" ) )   {

	$erromsg = "Por favor, preencha o formulário. <br>Telefone não é obrigatório.";

	} else {
		
	if (emailVld(htmlentities($_POST["eemail"])) == true) {	
	
	$headers = "MIME-Version: 1.1\r\n";
	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
	$headers .= "From: " . htmlentities($_POST["eemail"]) . "\r\n"; // remetente
	$headers .= "Return-Path: " . htmlentities($_POST["eemail"]) . "\r\n"; // return-path
	
	$msgemail = "Nova mensagem do site TM Consultoria Ambiental";
	$msgemail .= "\r\nNome: ". htmlentities($_POST["enome"]);
	$msgemail .= "\r\nTelefone: " . htmlentities($_POST["etelefone"]) .  "\r\n"."Mensagem: ". htmlentities($_POST["emensagem"]);
	
	$envio = mail("tarcomurilo@gmail.com", htmlentities($_POST["eassunto"]), $msgemail, $headers);
 
	if($envio) {
	$erromsg = "Mensagem enviada com sucesso."; }
		else {
			if (htmlentities($_POST["wf"]) == "e") {
			$erromsg = "Desculpe-nos, mas algo deu errado. Por favor, mande um e-mail para contato@tmambienta.com"; 
			} else {
				$erromsg = "Responderemos em menos de 24 horas.";
			}
			
		}
		
	} else { $erromsg = "Insira um e-mail valido."; } } }
	
} 

mysqli_close($conn); 
?>



<?php
header('Content-Type: text/html; charset=ISO-8859-15');
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/contatohtml.css">
		<meta name="keywords" content="consultoria, ambiental, engenheiro florestal, inventario florestal, meio ambiente, ambiente, bh, belo horizonte, mg, minas gerais, florestas, florestal, floresta, florestais, licenciamento, consultoria ambiental, licenciamento ambiental, aaf, eia, rima, auto de infração, inventário florestal, inventário, nativas, eucalipto, madeira, celulose, carvão, laudo, engenharia, engenheiro, sustentabilidade, sustentável, desenvolvimento, gestão ambiental, engenheiro ambiental, engenheiro florestal, divinopolis, itauna, curvelo, sete lagoas, mariana, ouro preto, itabirito, congonhas, conselheiro lafaiete, lavras, nova serrana, abaete, joao monlevade, consultor, treinamento, aulas, meio ambiente, environment, environmental"/>
		<meta content= "Projetos e consultoria no setor de meio ambiente e florestas. Agilidade e preço competitivo. Confira." name="description">
		<title>TM Consultoria Ambiental e Florestal - Sobre</title>
	</head>
	
	<body>
		<div class="rowmenu"  style="padding:0px">

			<div class="col-1">&nbsp;</div>
			<div class="col-2" > <img src="image/tmlogo2.png" class="logo"> </div>

			<div class="col-9"  > 
				<ul >
					<a href="index.html"><li class="btnmenu">Home</li></a>
					<a href="sobre.html"><li class="btnmenu">Sobre</li></a>
					<a href="solucoes.html"><li class="btnmenu">Soluções</li></a>
					<a href="clientes.html"><li class="btnmenu">Clientes</li></a>
					<a href="uteis.html"><li class="btnmenu">Notícias</li></a>
					<a href="contato.html"><li class="btnmenu">Contato</li></a>
					
				</ul> 
				</div>
				<div class="col-1">&nbsp;</div>
		</div>
		
		
		<div class="row" style="z-index:100; "> 
			
			<div class="col-12" style="position:relative">
				<img src="image/fundo4.jpg" style="display:block; margin:auto; width:100%;height:auto;">
				<p class="txtSlogan">Contato</p>
			</div>
				

		</div>
		
			
			<div class="row" style="position:relative; vertical-align:top;">
				<div class="col-3"> &nbsp;</div>
				<div class="col-5" style="margin:auto;">
				
					<div class="mainBox">
						<h1>Contato</h1>
						
							<p>
								Resp. Técnico: Tarço M. O. Luz<br>Engº Florestal - CREA-MG: 159.182/D<br>Mestre em Ciência Florestal<br><br>E-mail: contato@tmambiental.com<br>Telefone: (31) 9 9383 - 7795<br>
							</p>
							<p>
							<form action="assinar.php" method="POST">
								Nome:&nbsp;&nbsp;&nbsp;<input maxlength="256" style="width:330px;" name="enome" type="text"><br>
								E-mail:&nbsp;&nbsp;&nbsp;<input maxlength="256" style="width:330px;" name="eemail" type="text"><br>
								Tel:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input maxlength="32"style="width:330px;" name="etelefone" type="text"><br>
								Assunto:<input maxlength="256" style="width:330px;" name="eassunto" type="text"><br>
								Mensagem: <br><textarea name="emensagem" rows="10" cols="52"></textarea><br>	<br>			
								<input type="Submit" value="Enviar" size="100" style="margin-right:12px; width:200px; height:32px"><br><?php echo $erromsg ?><br>
								<br>Responderemos em menos de 24 horas.<input type="hidden" name="wf" value="e">
			</form>
							
							</p>
					
						<br><br>
								
					
					</div>	

				
				</div>
			</div>
		
	
		
				<div class="row">
				<div class="col-12" style="color:#222222;background-color:#222222; height:10px;"></div>
			</div>
		<div class="row" style="color:#CCCCCC;background-color:#222222; height:100px;">

			
				<div class="col-2" ><font color="#222222">&nbsp;</font></div>
				<div class="col-5">(C) Todos os direitos reservados - 2017</div>
				
				<div class="col-5" style="color:#CCCCCC;background-color:#222222; ">TM Consultoria Ambiental <br>Telefone: (31) 9 9383 - 7795 <br>E-mail: contato@tmambiental.com</div>
								<div class="col-1"></div>
			</div>

				

		
		
	</body>
</html>
