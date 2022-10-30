<?php include('funcoes.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar Utilizadores</title>
    <link rel="stylesheet" href="style.css"/>

</head>
<body>

<div class="conteudo">

	<div class="header">
		<ul>
			<li><a href="pagina_inicial.php">Home</a></li>
			<li><a href="menu.php">Menu</a></li>
			<li><a href="pagina_inicial.php?id=contactos">Contatos</a></li>
			<li><a href="pagina_inicial.php?id=horario">Horário</a></li>
			<li><a href="login.php" class="botao">Login</a></li>

		</ul>
	</div>

	<div class="roww">
		<form method="post" action="registo.php">
			<?php echo mostarErro(); ?>

			<div class="input-group">
				<label>Nome do Utilizador</label>
				<input type="text" name="nomeUtilizador" value="<?php echo $nome_utilizador; ?>">
			</div>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $mail; ?>">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>
			<div class="input-group">
				<label>Confirmar a password</label>
				<input type="password" name="password_2">
			</div>

			<div class="input-group">
				<button type="submit" class="botao" name="register_btn">Registar</button>
			</div>

			<p class="in-lnk">
				Já é membro? <a href="login.php">Entrar</a>
			</p>
		</form>
	</div>
	

	<div class="footer">
		<?php echo rodape(); ?>
	</div>


</div>

</body>
</html>


