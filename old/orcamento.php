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
	
if ((isset($_POST["act"])) and ($_SESSION["Sid"] == $dados["sid"])) {
	
	if ($_POST["act"] == "voltar") {
		$_SESSION["Act"] = 1;
	}	
	
	if ($_POST["act"] == "orc") {
		$_SESSION["Act"] = 3;
	}	
	
}

readfile("incdir/charset.php");

?> 

<html>
	<head>
		<meta charset="ISO-8859-15"> 
		<title>�rea do Cliente - TM Consultoria Ambiental</title>
		<link rel="stylesheet" type="text/css" href="estilo/estilo1.css">
	</head>
	<body>

		<div id="boxfundo" ></div>
		<div id="faixacentral">
		
			<div id="secaosup">
			<?php readfile("faixasupc.php" )?>
			</div>
		
		<div id="caixafundo3" >
		<div id="secaocont4"  >
		
		<div id=bldtext>Pedido de or�amento</div><br>
		<div id="nmltext">&nbsp;&nbsp;Aqui voc� pode fazer o pedido de or�amento para um servi�o. <br>
		&nbsp;&nbsp;Voc� acompanha seu or�amento em "Processos".<br>
		&nbsp;&nbsp;Nesta se��o voc� deve preencher com o m�ximo de detalhes poss�vel.<br>
		&nbsp;&nbsp;Caso seja necess�rio mais alguma informa��o, entraremos em contato. N�o se preocupe.<br>
		&nbsp;&nbsp;Pode utilizar quanto espa�o achar necess�rio em cada item.<br><br></div>
		
		
		
	<?php
			if ($_SESSION["Sid"] == $dados["sid"]) {
				
				
			
				if ($_SESSION["Act"] < 10) {
					
					$procnum = 1000;
					$flag = 0;
					$processo = date('Y').$procnum;
					$processo = 0+ $processo ;
					
					$sql =  "SELECT processo FROM tbprocessos WHERE 1 GROUP BY processo";
					$resultado = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($resultado) <= 0){

						echo "<div id=\"nmltext\">&nbsp;&nbsp;Assim que o or�amento for enviado, voc� poder� acompanh�-lo sob o n�mero: $processo. </div><br>";
						} else {
						
						while ($row = mysqli_fetch_assoc($resultado)){
							$ultimo = $row["processo"];
							$processo++;
						}	
						
							$ultimo++;
							$processo = $ultimo;
							echo "<div id=\"nmltext\">&nbsp;&nbsp;Assim que o or�amento for enviado, voc� poder� acompanh�-lo sob o n�mero: $processo. </div><br>";						
						}
				}
					
				
	
				if ($_SESSION["Act"] == 3) {
					$clitext = "Pedido de orcamento\n";
					$clitext .= "Descricaoo: ". htmlentities($_POST["desc1"]) . "\n";
					$clitext .= "Localizacao: ". htmlentities($_POST["desc2"]). "\n";
					$clitext .= "Tamanho (ha): ". htmlentities($_POST["desc3"]) . "\n";
					$clitext .= "Urbano/rural: ". htmlentities($_POST["desc4"]) . "\n";
					$clitext .= "Tem mapa: ". htmlentities($_POST["desc5"]) . "\n";
					$clitext .= "Curso dagua: ". htmlentities($_POST["desc6"]) . "\n";
					$clitext .= "Mato/Acidentes: ". htmlentities($_POST["desc7"]) . "\n";
					$clitext .= "Licencas: ". htmlentities($_POST["desc8"]) . "\n";
					$clitext .= "Tem GEO/CAR: ". htmlentities($_POST["desc9"]) . "\n";
					$clitext .= "Tem inventario: ". htmlentities($_POST["desc10"]) . "\n";
					$clitext .= "Serraria/Viveiro: ". htmlentities($_POST["desc1"]) . "\n";
					$clitext .= "Reflorestamento/Praga: ". htmlentities($_POST["desc11"]) . "\n";
					$clitext .= "Precisa de Inventario: ". htmlentities($_POST["desc12"]) . "\n";
					$clitext .= "Outros: ". htmlentities($_POST["desc1"]) . "\n";
			
					$sql =  "INSERT INTO tbprocessos(matricula, texto, processo, clientmsg) VALUES ('".$_SESSION["Ident"]."','Or�amento enviado. Assim que ficar pronto, entraremos em contato.', '".$processo."', '".$clitext."')";
					$resultado = mysqli_query($conn, $sql);
					sleep(1);
					$sql =  "INSERT INTO tbprocessos(matricula, texto, processo) VALUES ('".$_SESSION["Ident"]."','Acompanhe tudo por aqui e qualquer d�vida, nos avise.', '".$processo."')";
					$resultado = mysqli_query($conn, $sql);
					
					echo "<div id=\"bldtext2\">&nbsp;&nbsp;O seu or�amento foi enviado. Voc� poder� acompanhar o andamento em \"Processos\".<br>
					&nbsp;&nbsp;</div>";
					
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
	
			$msgemail = "Novo or�amento interno do cliente " . $nome;
			$msgemail .= "\r\n ------ Inicio ------ \r\n" . $clitext;
			$msgemail .= "\r\n ------ FIM ------";
	
			$envio = mail("tarcomurilo@gmail.com", "TM Ambiental - Or�amento de " . $nome, $msgemail, $headers);
 
		if($envio) {
			$retmsg = "Sua mensagem foi enviada."; }
			else {
				$retmsg = "Sua mensagem n�o foi enviada. Entre em contato com tarcomurilo@gmail.com";
					$_SESSION["Act"] = 2;
				}
			
		//fim
					
					$_SESSION["Act"] = 1;
				
				}
	}
	?>
	
	<form action="orcamento.php" method="POST">
	<table id="table1" rules=all width="700">
		<tr> <td style="width:250"><div id="bldtext" align="center">Item</div></td><td><div id="bldtext" align="center">Descri��o</div></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Descreva o seu problema:</div></td><td><input type="text" name="desc1" style="width:450; margin:2px;" value="Ex: Preciso obter licen�a ambiental."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Qual a localiza��o?(cidade, estado)</div></td><td><input type="text" name="desc2" style="width:450; margin:2px;" value="Ex: Belo Horizonte, MG."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Qual o tamanho (ha ou m�)?</div></td><td><input type="text" name="desc3" style="width:450; margin:2px;" value="Ex: Fazenda de 220 ha."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">�rea urbana ou rural?</div></td><td><input type="text" name="desc4" style="width:450; margin:2px;"value="Ex: �rea rural."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Possui mapa da �rea? </div></td><td><input type="text" name="desc5" style="width:450; margin:2px;" value="Ex: Possuo mapa em Autocad."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">H� rios, lagos ou c�rregos?</div></td><td><input type="text" name="desc6" style="width:450; margin:2px;" value="Ex: H� 2 rios e um lago."></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">H� �reas com mato alto e/ou terreno acidentado:</div></td><td><input type="text" name="desc7" style="width:450; margin:2px;" value="Ex: Terreno pouco acidentado. Declividade m�xima de 10�."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">J� possui licenciamento ou processo de licenciamento? (se sim, indique o �rg�o e o n�mero do processo)</div></td><td><input type="text" name="desc8" style="width:450; margin:2px;" value="Ex: Ainda n�o possuo nenhuma licen�a."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">A �rea � georreferenciada ou possui CAR? </div></td><td><input type="text" name="desc9" style="width:450; margin:2px;" value="Ex: N�o possuo CAR, nem georreferenciamento."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">J� possui invent�rio florestal realizado? </div></td><td><input type="text" name="desc10" style="width:450; margin:2px;" value="Ex: Nunca foi feito um invent�rio"></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Necessita de projeto de viveiro ou serraria? (de qual tamanho?) </div></td><td><input type="text" name="desc10" style="width:450; margin:2px;" value="Ex: N�o."></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Necessita de projeto de reflorestamento ou controle de pragas? </div></td><td><input type="text" name="desc10" style="width:450; margin:2px;" value="Ex: Sim. Constrole de erva daninha."></td></tr>	
		<tr> <td style="width:250"><div id="bldtext2" align="left">Necessita de invent�rio florestal? Nativa ou reflorestamento?</div></td><td><input type="text" name="desc11" style="width:450; margin:2px;" value="Ex: Preciso de invent�rio de nativas, para supress�o de vegeta��o." ></td></tr>
		<tr> <td style="width:250"><div id="bldtext2" align="left">Descreva outras coisas que achar necess�rio: </div></td><td><input type="text" name="desc12" style="width:450; margin:2px;" value="Ex: Possuo hospedagem pr�pria e alimenta��o para at� 5 pessoas."></td></tr>
<input type="hidden" name="act" value="orc">
	</table>
	<input type="submit" value="Enviar or�amento" style="width:150px; margin-left:6px;"><br><br>
	</form>
	
<?php 

mysqli_close($conn); 
?>
</div></div>
</div>
	</body>

</html>