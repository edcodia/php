<?php 
	include('funcoes.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"/>

    <title>Document</title>
</head>
<body>
    <div class="conteudo">
    <!-- Controle de sessão, só utilizadores autorizados têm acesso à página tem acesso a página -->

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['user_type']=='administrador') : ?>

       
        <div class="header u_logado">
			    <?php echo admMenu(); ?>
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

        <!-- Informação -->
        <div class="roww adm_bt">
                <h2>Utilizadores registados</h2>
                <?php
                    echo mostrarUtilizadores();
                ?>
                <br>

            <ul>
				<li><a href="criar_user.php"> +add Utilizador </a></li>
			</ul>

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