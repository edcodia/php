<?php 
	include('funcoes.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<div class="conteudo">
	<!-- Controle de sessão, só utilizadores autorizados têm acesso à página tem acesso a página -->

	<?php  if (isset($_SESSION['user']) && $_SESSION['user']['user_type']=='cliente') : ?>


		<div class="header u_logado">
				<?php echo clienteMenu(); ?>
		</div>

	
		<!-- Mensagem de notificação -->
		<?php if (isset($_SESSION['sucesso'])) : ?>
			<div class="sucesso" >
				<h3>
					<?php 
						echo $_SESSION['sucesso']; 
						unset($_SESSION['sucesso']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- Informações do utilizador logado -->
		<div class="roww">
			<div class="perfil_info">
				<div>
						<strong><?php echo $_SESSION['user']['nome']; ?></strong>
						<small>
							<i  style="color: #fff;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
							<br>
						</small>
				</div>
			</div>
		</div>
		


		<div class="footer">
			<?php echo rodape(); ?>
		</div>

		<!-- Notificação caso o utilizador não tenha autorização para aceder à página -->

		
        <?php else:?> 

		<?php 
			array_push($erros,'Não tem acesso a essa página');
			echo mostarErro();
		?>
		<?php endif ?>

	
	</div>
</body>
</html>