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
	
if (($_SESSION["Sid"] != $dados["sid"]) or ($_SESSION["Act"] == 0) or  ($_SESSION["Usrtyp"] <> "g5d8b2f8")) {
	header("Location:incdir/logout.php");
} 

if ((isset($_POST["act"])) and ($_SESSION["Sid"] == $dados["sid"])) {
	
	if ($_POST["act"] == "details") {
		$_SESSION["Act"] = 3;
		$_SESSION["Matricula"] = $_POST["client"];
	}	
}
	
if ((isset($_POST["act"])) and ($_SESSION["Sid"] == $dados["sid"])) {
	
	if ($_POST["act"] == "voltar") {
		$_SESSION["Act"] = 1;
	}	
}

readfile("incdir/charset.php");

?> 

<html>
	<head>
		<meta charset="ISO-8859-15"> 
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
			if (($_SESSION["Sid"] == $dados["sid"]) and ($_SESSION["Usrtyp"] == "g5d8b2f8"))  {
			
				if ($_SESSION["Act"] < 3) {
					
					$sql =  "SELECT nome FROM lista WHERE matricula='$_SESSION[Ident]'";
					$resultado = mysqli_query($conn, $sql);
					$dados = mysqli_fetch_array($resultado);
					$nome = $dados["nome"];
					echo "<div id=bldtext>Informações sobre clientes</div><br>";
					echo "<div id=\"nmltext\">&nbsp;&nbsp;Aqui você verifica as informações dos clientes.<br>";
					echo "&nbsp;&nbsp;Aqui você poderá modificar as informações do cliente, gerar uma nova senha e acrescentar novos processos.<br><br></div>";
					
					
					$sql =  "SELECT nome, matricula FROM lista WHERE 1 GROUP BY nome";
					$resultado = mysqli_query($conn, $sql);
				
				
					if ($resultado <> false){
					
						if (mysqli_num_rows($resultado) <= 0){
							echo "--------------------------------------------------------<br>";
							echo "<div id=\"nmltext\">Não há cliente cadastrado.</div>";
							echo "--------------------------------------------------------<br>";
							} else {
								echo "<table id=\"table1\" rules=rows width=\"450\">";
								echo "<tr>";
								echo "<td colspan=\"2\" align=\"center\"><div id=\"bldtext2\">Processos Ativos</div></td>";
								echo "</tr>";
							}
						
						
						while ($row = mysqli_fetch_assoc($resultado)){
							echo "<tr><td>";
							echo "<div id=\"nmltext\">Nome: " . $row["nome"] . " - Cliente ID: " . $row["matricula"] . "</div>";
							echo "</td>";
							echo "<td align=\"right\"><form action=\"aclientes.php\" method=\"post\"><input type=\"hidden\" name=\"act\" value=\"details\"><input type=\"hidden\" name=\"client\" value=\"". $row["matricula"] ."\" ><input type=\"submit\" value=\"Detalhes\"></form></td></tr>";
						}
					
						if (mysqli_num_rows($resultado) > 0){
							echo "</table>";
							}
					} 
											
				}
				
				if ($_SESSION["Act"] == 3) {
					
					$sql =  "SELECT * FROM lista WHERE matricula = \"$_SESSION[Matricula]\" ;";
					$resultado = mysqli_query($conn, $sql);
					
					echo "<div id=\"bldtext\">Cliente ID: $_SESSION[Matricula] </div><br>";
					echo "<table id=\"table1\" rules=\"all\" width=\"600\">";
					echo "<tr><td width=\"130\"><div id=\"bldtext\" align=\"center\" >Item</div></td><td><div id=\"bldtext\" align=\"center\">Descrição</td></tr>";
					
					$dados = mysqli_fetch_array($resultado);
					
						
						echo "<tr><td><div id=\"nmltext\">Nome:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"inome\" value=\"". $dados["nome"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">ID:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"imatri\" value=\"". $dados["matricula"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">CPF/CNPJ:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"icpf\" value=\"". $dados["cpfcnpj"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">E-mail:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"iemail\" value=\"". $dados["email"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">Telefone:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"itele\" value=\"". $dados["telefone"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">Endereço:</div></td>";
						echo "<td><div id=\"nmltext\"><input type=\"text\" style=\"width:450px\"name=\"iend\" value=\"". $dados["endereco"] ."\"></div></td></tr>";
						
						echo "<tr><td><div id=\"nmltext\">Novo processo:</div></td>";
						echo "<td><div id=\"nmltext\"><input id=\"button1\" style=\"width:130px\" type=\"button2\" name=\"newproc\" value=\"Abrir novo processo\"></div></td></tr>";

						
						echo "<tr><td><div id=\"nmltext\">Nova senha:</div></td>";
						echo "<td style=\"padding-left:315px\"><div id=\"nmltext\"><input id=\"button1\" style=\"width:130px\" type=\"button1\" name=\"newpass\" value=\"Enviar nova senha\"></div></td></tr>";

					$_SESSION["Act"] = 1;
					echo "</table>";
					echo "&nbsp;&nbsp;<input type=\"submit\" value=\"Atualizar\">";
	
										
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