<?php

	readfile("incdir/charset.php");

$servername = "localhost";
$username = "touchcooler";
$password = "cas123";
$dbname = "touchcooler";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	}
	
	if ($_POST <> null) {
		
		if ($_POST["controle"] == 0) {
		
			$sql =  "UPDATE lista SET saldo=$_POST[novosaldo] WHERE ident=$_POST[ident]";
			mysqli_query($conn, $sql);
			
		}
		
		if ($_POST["controle"] == 1) {

			$sql =  "DELETE FROM lista WHERE ident=$_POST[ident]";
			mysqli_query($conn, $sql);
			
		}
		
		if ($_POST["controle"] == 2) {
			$sql =  "INSERT INTO lista (nome, saldo) VALUES ('$_POST[nome]', $_POST[novosaldo])";
			mysqli_query($conn, $sql);
	
		}
		
	}
	
?>

<html>
	<head>
 
		<title>Área do Cliente - TM Consultoria Ambiental</title>
	</head>
	<body>

		<h1>Lista de Clientes</h1>


<?php
	$sql = "SELECT * FROM lista";
	$resultado = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($resultado) > 0) {
		while ($linha = mysqli_fetch_assoc($resultado)) {
			echo "Identificação: " . $linha["ident"] . " - Nome: " . $linha["nome"] . " - Saldo: " . $linha["saldo"];
			echo "<form action=clientes.php method=post>Novo saldo: <input type=text name=novosaldo value=" . $linha["saldo"] ."><input type=hidden name=ident value=". $linha["ident"] . "> <input type=hidden name=controle value=0><input type=hidden name=controle value=0><input value=Alterar type=submit> </form>";
			echo "<form action=clientes.php method=post>Excluir cliente: <input type=hidden name=controle value=1> <input type=hidden name=ident value=" . $linha["ident"] . "> <input value=Excluir type=submit> </form>";
			echo "----------------------------------------------------------<br><br>";
	} }
		else {
			echo "Não foi encontrado nenhum cliente.";
		};
	
?>
<p>Adicionar cliente</p>
<form action="clientes.php" method="POST">Nome do cliente: <input name="nome" type="text"> - Saldo: <input name="novosaldo" type="text" value="0"><input type="hidden" name="controle" value="2"><input type="Submit" value="Adicionar"></form>

</form>

<?php mysqli_close($conn); ?>
	</body>

</html>