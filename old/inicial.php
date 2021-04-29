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
		$_SESSION["Act"] = 3;
		$_SESSION["procN"] = $_POST["proc"];
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
			<?php readfile("faixasupc.php" )?>
			</div>
		
		<div id="caixafundo3" >
		<div id="secaocont4">
		
	<?php
			if ($_SESSION["Sid"] == $dados["sid"]) {
				
				
			
				if ($_SESSION["Act"] < 3) {
					
					$sql =  "SELECT nome FROM lista WHERE matricula='$_SESSION[Ident]'";
					$resultado = mysqli_query($conn, $sql);
					$dados = mysqli_fetch_array($resultado);
					$nome = $dados["nome"];
					echo "<div id=bldtext>Andamento de processos</div><br>";
					echo "<div id=\"nmltext\">&nbsp;&nbsp;Aqui você acompanha o andamento de projetos e consultorias que estão em andamento.<br>";
					echo "&nbsp;&nbsp;Você também pode visualizar uma cópia do contrato de serviço. Quando há alguma alteração, você também é avisado por e-mail.<br><br></div>";
					
					
					$sql =  "SELECT processo FROM tbprocessos WHERE matricula='$_SESSION[Ident]' GROUP BY processo";
					$resultado = mysqli_query($conn, $sql);
				
				
					if ($resultado <> false){
					
						if (mysqli_num_rows($resultado) <= 0){
							echo "--------------------------------------------------------<br>";
							echo "<div id=\"nmltext\">Não há processos para acompanhar.</div>";
							echo "--------------------------------------------------------<br>";
							} else {
								echo "<table id=\"table1\" rules=rows width=\"350\">";
								echo "<tr>";
								echo "<td colspan=\"2\" align=\"center\"><div id=\"bldtext2\">Processos Ativos</div></td>";
								echo "</tr>";
							}
						
						
						while ($row = mysqli_fetch_assoc($resultado)){
							echo "<tr><td>";
							echo "<div id=\"nmltext\">Processo Nº: " . $row["processo"] . "</div>";
							echo "</td>";
							echo "<td align=\"right\"><form action=\"inicial.php\" method=\"post\"><input type=\"hidden\" name=\"act\" value=\"details\"><input type=\"hidden\" name=\"proc\" value=\"". $row["processo"] ."\" ><input type=\"submit\" value=\"Detalhes\"></form></td></tr>";
						}
					
						if (mysqli_num_rows($resultado) > 0){
							echo "</table>";
							}
					} 
											
				}
				
				if ($_SESSION["Act"] == 3) {
					
					$sql =  "SELECT texto, data FROM tbprocessos WHERE matricula='$_SESSION[Ident]' AND processo=$_SESSION[procN] ORDER BY data desc";
					$resultado = mysqli_query($conn, $sql);
					
					echo "<div id=\"bldtext\">Processo número: $_SESSION[procN] </div><br>";
					echo "<form action=\"inicial.php\" method=\"post\" style=\"margin-left:10px\"><input type=\"hidden\" name=\"act\" value=\"voltar\"><input id=\"sair\" type=\"submit\" value=\"Voltar\"></form>";
					echo "<table id=\"table1\" rules=\"all\" width=\"600\">";
					echo "<tr><td width=\"130\"><div id=\"bldtext\" align=\"center\" >Data</div></td><td><div id=\"bldtext\" align=\"center\">Descrição</td></tr>";
					
					while ($row = mysqli_fetch_assoc($resultado)){
						echo "<tr><td>";
						$ano = substr($row["data"],0, 4);
						$mes = substr($row["data"],5, 2);
						$dia = substr($row["data"],8, 2);
						$hora = substr($row["data"],11, 8);
						$datahora = "$dia/$mes/$ano - $hora";
						
						echo "<div id=\"nmltext\"> $datahora </div></td>";
						echo "<td><div id=\"nmltext\">$row[texto]</div></td>";
					}
					$_SESSION["Act"] = 1;
					echo "</table>";
	
										
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