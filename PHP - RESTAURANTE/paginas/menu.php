<?php 
	include('funcoes.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de utilizadores</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
	<div class="conteudo">
		<div class="header">
			<ul>
                <li><a href="pagina_inicial.php">Home</a></li>
				<li><a href="menu.php">Menu</a></li>
				<li><a href="pagina_inicial.php?id=contactos">Contatos</a></li>
				<li><a href="pagina_inicial.php?id=horario">Horários</a></li>
				<li><a href="login.php" class="botao">Login</a></li>

			</ul>
		</div>
		<div class="row_menu">
            <?php echo mostrarPratos(); ?>
			
		</div>


	<div class="footer">
<?php echo rodape(); ?>
</div>
	</div>

</body>
</html>