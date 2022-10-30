<?php 
	// Inclusão do ficheiro que contém as funções que irão ser utilizadas nesta página
	// Qualquer variável disponível no arquivo que incluiu estará disponível no arquivo incluído, daquela linha em diante.
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
			
	
		</div>

		<div class="roww">
				<h2>Faça a sua reserva</h2>

				<form action="reservar.php" method="post">
					<?php echo mostarErro(); ?>
					<div class="input-group">

						<input type="date" name="res_data"> 
					</div>

					<div class="input-group">
						<input type="time" name="res_hora"> <br>
					</div>

					<div class="input-group">
						<input type="text" name="res_lugar" placeholder="lugar"> <br>
					</div>

					<div class="input-group">
						<input type="text" name="res_pedido" placeholder="pedido"> <br>
					</div>

					<div class="int-group">
						<input type="submit" class="botao" value="Reservar" name="res_bt">
					</div>	

				</form>	
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