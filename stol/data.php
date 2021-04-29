<?php
$servername = 'mysql.hostinger.com.br';
$username = 'u426237964_stolu';
$password ='mXBpP#[;lbbB8j1y';
$dbname = 'u426237964_stol';

$conn = mysqli_connect(servername, username, password, dbname);

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
		<table>
			<?php
				echo "eita" . mysqli_query($conn, "SELECT * FROM 'DtFieldT'");
			?>
		</table>
	</body>
	
</html>