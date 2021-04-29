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
	
	if ($_POST["act"] == "details") {
		$_SESSION["Act"] = 4;
		$_SESSION["procN"] = htmlentities($_POST["proc"]);
	}	
	
	if ($_POST["act"] == "voltar") {
		$_SESSION["Act"] = 2;
	}	
	
}
	

if (($_SESSION["Act"] == 2) and (isset($_POST["novasenha"])) and ($_SESSION["Sid"] == $dados["sid"])) {
	
	if (htmlentities($_POST["novasenha"]) != ""){
		$sql =  "SELECT * FROM lista WHERE matricula='$_SESSION[Ident]'";
		$resultado = mysqli_query($conn, $sql);
		$dados = mysqli_fetch_array($resultado);
		
	$md5s = md5(substr($dados["cpfcnpj"],1, 5));
	$sql =  "UPDATE lista SET senha='".md5(htmlentities($_POST["novasenha"]).$md5s)."' WHERE matricula='$_SESSION[Ident]'";
	mysqli_query($conn, $sql);
	$_SESSION["Act"] = 3;
	}
	
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
			<?php 
			
				if ($_SESSION["Usrtyp"] <> "g5d8b2f8") {
					readfile("faixasupc.php" );
				} elseif ($_SESSION["Usrtyp"] == "g5d8b2f8") {
					readfile("faixasupa.php");
				}
			
			?>
			</div>
		
		<div id="caixafundo3" >
		<div id="secaocont4">
		
	<?php
			if ($_SESSION["Sid"] == $dados["sid"]) {
				
				
			
				if ($_SESSION["Act"] < 10) {
					
					$sql =  "SELECT nome FROM lista WHERE matricula='$_SESSION[Ident]'";
					$resultado = mysqli_query($conn, $sql);
					$dados = mysqli_fetch_array($resultado);
					$nome = $dados["nome"];
					echo "<div id=\"nmltext\">Bem vindo(a) <b> $nome</b>,</div><br>";
					echo "<div id=\"nmltext\">Você está na área exclusiva para clientes da TM Consultoria Ambiental.<br>";
					echo "Nesta página você pode visualizar todos os dados importantes que precisamos sobre você ou sua empresa.<br>";
					echo "Para alterar algum destes itens, envie um e-mail clicando em \"contato\".<br>";
					echo "Você também pode alterar sua senha se quiser. <br><br></div>";
					
					$sql =  "SELECT * FROM lista WHERE matricula='$_SESSION[Ident]'";
					$resultado = mysqli_query($conn, $sql);
				
				
					if ($resultado <> false){
					
						if (mysqli_num_rows($resultado) <= 0){
							echo "--------------------------------------------------------<br>";
							echo "<div id=\"nmltext\">Seus dados estão incompletos. Entre em contato com tarcomurilo@gmail.com</div>";
							echo "--------------------------------------------------------<br>";
							} else {
								echo "<table id=\"dadostable\" rules=\"rows\" width=\"500\">";
								echo "<tr>";
								echo "<td width=\"110\"><div id=\"bldtext2\">Dados Pessoais</div></td><td></td>";
								echo "</tr>";
								
								$row = mysqli_fetch_array($resultado);
							
								echo "<tr><td><div id=\"nmltext\">Nome completo: </td><td>" . $row["nome"] . "</div></td></tr>";
								echo "<tr><td><div id=\"nmltext\">ID: </td><td>" . $row["matricula"] . "</div></td></tr>";
								echo "<tr><td><div id=\"nmltext\">CPF/CNPJ: </td><td>" . $row["cpfcnpj"] . "</div></td></tr>";
								echo "<tr><td><div id=\"nmltext\">E-mail: </td><td>" . $row["email"] . "</div></td></tr>";
								echo "<tr><td><div id=\"nmltext\">Telefone: </td><td>" . $row["telefone"] . "</div></td></tr>";
								echo "<tr><td><div id=\"nmltext\">Endereço: </td><td>" . $row["endereco"] . "</div></td></tr>";
							
						}
					
						if (mysqli_num_rows($resultado) > 0){
							echo "</table>";
							}
					} 
					echo "<br>";
					echo "<form action=\"perfil.php\" method=\"post\"><div id=\"nmltext\">Nova senha: <input type=text name=\"novasenha\" size=\"16\"><input type=\"hidden\" name=\"act\" value=\"voltar\"><input type=\"submit\" value=\"Atualizar\"> </form></div>";
				
					if ($_SESSION["Act"] == 3){
						echo "<div id=\"nmltext\">Senha alterada com sucesso.</div><br>";
						$_SESSION["Act"] = 2;
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