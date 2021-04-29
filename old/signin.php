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
$erromsg2 = "<div id=\"nmltext\"><a href=\"logpag.php\" style=\"color:#005500\">Você já possui um login? Clique aqui.</a></div>";

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
			$erromsg = "Desculpe-nos, mas algo deu errado. Por favor, mande um e-mail para tarcomurilo@gmail.com"; 
			} else {
				$erromsg = "Responderemos em menos de 24 horas.";
			}
			
		}
		
	} else { $erromsg = "Insira um e-mail valido."; } } }
	
} 


if ($_POST <> null){
		
	if (htmlentities($_POST["wf"]) == "i") { 
		
		if ((htmlentities($_POST["email"]) != htmlentities($_POST["email2"]))) { 
			$erromsg2 = "<div id=\"bldtext2\">O e-mail não é igual ao outro.</div>" ;
		} else {
		
		
		if ((htmlentities($_POST["nome"]) =="" ) or (htmlentities($_POST["matricula"]) =="" ) or (htmlentities($_POST["cpfcnpj"]) =="" ) or (htmlentities($_POST["email"]) =="" ) or (htmlentities($_POST["email2"]) =="" )) {

		$erromsg2 = "<div id=\"bldtext2\">Preencha todos os campos corretamente.</div>";

		} else {
			
			if ((!(emailVld( htmlentities($_POST["email"]))) and (!(userVld(htmlentities($_POST["matricula"])))))) {
				$erromsg2 = "<div id=\"bldtext2\">Insira um e-mail válido.<br>O nome de usuário deve ter pelo menos 5 letras ou números.</div>";
			} else {
			
			$sql =  "SELECT matricula FROM lista WHERE matricula='" . htmlentities($_POST["matricula"])."'";
			$resultado = mysqli_query($conn, $sql);
			$sql =  "SELECT cpfcnpj FROM lista WHERE cpfcnpj='" . htmlentities($_POST["cpfcnpj"])."'";
			$resultado2 = mysqli_query($conn, $sql);
			
			$dados = mysqli_fetch_array($resultado);
			$dados2 = mysqli_fetch_array($resultado2);
			
			if ($dados["matricula"] == htmlentities($_POST["matricula"])) { $mlin = 1;} else {$mlin = 	0;}; 
			if ($dados2["cpfcnpj"] == htmlentities($_POST["cpfcnpj"])) { $clin = 1;} else {$clin = 0;};
						
			
			if ($mlin == 1){
				
				$erromsg2 = "<div id=\"bldtext2\">Matrícula já cadastrada.</div>";
				$clin = 2;
			} 
		
			if ($clin == 1 ) {
			
				$erromsg2 = "<div id=\"bldtext2\">CPF ou CNPJ já cadastrado.</div>";
			
			}
			
			if (($mlin == 0 ) and ($clin == 0))  {
				$gerasenha = Rand(100000,999999);
				$salt = substr(htmlentities($_POST["cpfcnpj"]), 1, 5);
				$md5s = md5($salt);
				$md5p = md5("$gerasenha".$md5s);
				$sql =  "INSERT INTO lista(nome, cpfcnpj, email, matricula, senha, usrtyp) VALUES ('".htmlentities($_POST["nome"])."','".htmlentities($_POST["cpfcnpj"])."','".htmlentities($_POST["email"])."','".htmlentities($_POST["matricula"])."','".$md5p."','user')";
				mysqli_query($conn, $sql);
				$erromsg2 = "<div id=\"bldtext2\" >Cadastro efetuado. <br> A senha foi enviada para seu e-mail. </div>";				
				
				$headers = "MIME-Version: 1.1\r\n";
				$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
				$headers .= "From: " . htmlentities($_POST["email"]) . "\r\n"; // remetente
				$headers .= "Return-Path: " . htmlentities($_POST["email"]) . "\r\n"; // return-path
	
				$msgemail = "Novo usuário cadastrado. O usuário é: " . htmlentities($_POST["matricula"]);
	
				$envio = mail("tarcomurilo@gmail.com", "Novo cadastro no site TM Consultoria Ambiental", $msgemail, $headers);
			
				if($envio) {
					$erromsg2 = "<div id=\"bldtext2\" >Cadastro efetuado. <br> A senha foi enviada para seu e-mail. </div>"; }
					else {
						if (htmlentities($_POST["wf"]) == "i") {
						$erromsg2 = "<div id=\"bldtext2\" >Desculpe-nos, mas algo deu errado. Por favor, mande um e-mail para tarcomurilo@gmail.com</div>"; 
						} else {
						$erromsg2 = "<div id=\"nmltext\"><a href=\"logpag.php\" style=\"color:#005500\">Você já possui um login? Clique aqui.</a></div>";
						}
			
					}
				

				$headers="";
				$headers = "MIME-Version: 1.1\r\n";
				$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
				$headers .= "From: tarcomurilo@gmail.com\r\n"; // remetente
				$headers .= "Return-Path: tarcomurilo@gmail.com\r\n"; // return-path
	
				$msgemail = htmlentities($_POST["nome"]) . ",\r\n";
				$msgemail .= "\r\nBem vindo a TM Consultoria Ambiental!\r\n";
				$msgemail .= "\r\nSeu nome de usuário: " . htmlentities($_POST["matricula"]);
				$msgemail .= "\r\nSua senha: " . $gerasenha;
				$msgemail .= "\r\nA partir de agora, você pode acessar a Área do Cliente em nosso site.";
				$msgemail .= "\r\nSe houver algum erro nos seus dados, eles serão corrigidos assim que você fechar o primeiro orçamento. Não se preocupe.\r\n";
				$msgemail .= "\r\nAtenciosamente,\r\n";
				$msgemail .= "\r\nEquipe da TM Consultoria Ambiental";
				$msgemail .= "\r\nwww.tmambiental.com";
	
				$envio = mail(htmlentities($_POST["email"]), "Cadastro na TM Consultoria Ambiental.", $msgemail, $headers);
			
				if($envio) {
					$erromsg2 = "<div id=\"bldtext2\" >Cadastro efetuado. <br> A senha foi enviada para seu e-mail. </div>"; }
					else {
						if (htmlentities($_POST["wf"]) == "i") {
						$erromsg2 = "<div id=\"bldtext2\" >Desculpe-nos, mas algo deu errado. Por favor, mande um e-mail para tarcomurilo@gmail.com</div>"; 
						} else {
						$erromsg2 = "<div id=\"nmltext\"><a href=\"logpag.php\" style=\"color:#005500\">Você já possui um login? Clique aqui.</a></div>";
						}
			
					}
				
		}
			}
		} }
}
}

mysqli_close($conn); 
?>


<html>
	<head>

		<title>Contato - TM Consultoria Ambiental</title>
		<link rel="stylesheet" type="text/css" href="estilo/estilo1.css">
	</head>
	<body>
	<div id="boxfundo"></div>
		<div id="faixacentral">
		
			<div id="secaosup">
			<?php readfile("faixasup.php" )?>
			</div>
		
		
			<div id="secaocont">

		
		<div id="bldtext" >Relacionamento com o cliente</div><br>
		<?php /*<div id="assinar-box1">
		<div id="bldtext2">Atendimento Rápdio</div><br>
		<div id="nmltext">Ficou mais dinâmico entrar em contato conosco sempre que precisar. <br><br>
		Com nosso sistema automático de relacionamento com o cliente você pode requisitar orçamentos, acompanhar o andamento de seus projetos e entrar em contato direto conosco.<br><br>
		Para evitar longos formulários, seus outros dados serão preenchidos por nós mesmos, assim que você fechar seu primeiro projeto conosco. É rápido e prático. <br><br>
		A sua primeira senha será enviada para o seu e-mail assim que você se cadastrar. <br><br>
		Se preferir não efetuar o cadastro de cliente agora, use o formulário da direita para nos enviar um e-mail.</div></div> */ ?>
			<table id="assinar-table2">
			<tr>
			<form action="signin.php" method="POST">
			<tr><td colspan="2"><div id="bldtext2">Cadastro de novo cliente</div></td></tr>
			<td><div id="nmltext" >Nome completo: </div></td><td align="Center"><input maxlength="256" name="nome" type="text"></td>
			<tr><td><div id="nmltext" >Nome de usuário: </div></td><td align="Center"><input maxlength="32" name="matricula" type="text"></td></tr>
			<tr><td><div id="nmltext" >CPF ou CNPJ: </div></td><td align="Center"><input maxlength="32" name="cpfcnpj" type="text"></td></tr>
			<tr><td><div id="nmltext" >E-mail: </div></td><td align="Center"><input maxlength="256" name="email" type="text"></td></tr>
			<tr><td><div id="nmltext" >Confirma o e-mail: </div></td><td align="Center"><input maxlength="256" name="email2" type="text"></td>
			<tr><td colspan="2" align="right"><input type="Submit" value="Criar conta" size="100"></td></tr>
			<tr><td colspan="2" align="right"><?php echo $erromsg2 ?></td></tr><input type="hidden" name="wf" value="i">
			</form>
			</table>
				
			</div>
			<img id="figura1A" src="images/forest1.jpg">
		</div>
	
	</body>

</html>