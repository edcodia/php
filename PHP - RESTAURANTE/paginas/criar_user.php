
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

    <?php  if (isset($_SESSION['user']) && $_SESSION['user']['user_type']=='administrador') : ?>

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
        <div class="header u_logado">
                <?php echo admMenu();?>
        </div>

        <div class="roww">


                <form method="post" action="criar_user.php">
                    <?php echo mostarErro(); ?>
                    <div class="input-group">
                        <label>Nome do Utilizador</label>
                        <input type="text" name="cr_nomeUtilizador" value="<?php echo $nome_utilizador; ?>">
                    </div>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="cr_email" value="<?php echo $mail; ?>">
                    </div>
                    <select name="user_type" id="">
                        <?php 
                            $query = " Select * from user_type";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['nome']."'>".$row['nome']."</option>";
                            }         
                        ?>
                    </select>
                    <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="cr_password_1">
                    </div>
                    <div class="input-group">
                        <label>Confirmar a password</label>
                        <input type="password" name="cr_password_2">
                    </div>

                    <div class="input-group">
                        <button type="submit" class="botao" name="cr_utlzr_bt">+Criar</button>
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