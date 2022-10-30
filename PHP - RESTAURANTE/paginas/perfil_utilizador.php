
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
    <?php  if (isset($_SESSION['user'])) : ?>
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

        <!-- Infornação -->
        <div class="header u_logado">
            <!-- Controle de sessão, só utilizadores autorizados têm acesso à página tem acesso a página -->

            <?php
                if ($_SESSION['user']['user_type'] == 'administrador') {
                    echo admMenu();
                } else if ($_SESSION['user']['user_type'] == 'chefe_mesa') {
                    echo chefeMesaMenu();
                } else {
                    echo clienteMenu();
                }
            ?>
        
        </div>

        <div class="roww">
            <form action="perfil_utilizador.php" method="post">
                <?php echo mostarErro(); ?>

                <div class="input-group">
                    <label>Nome</label>
                    <input type="text" name="prf_nome" placeholder=<?php echo $_SESSION['user']['nome']; ?>> <br>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="prf_email" placeholder=<?php echo $_SESSION['user']['email']; ?>> <br>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="prf_password1" placeholder="Password"> <br>
                </div>

                <div class="input-group">
                    <label>Confirmar Password</label>
                    <input type="password" name="prf_password2" placeholder="Confirmar Password"> <br>
                </div>

                <div class="int-group">
                    <input type="submit" class="botao" value="Submit" name="prf_bt"> <br>
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