
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
        <?php  if (isset($_SESSION['user'])) : ?>
         
            <?php
                echo admMenu();
             ?>

        <div class="roww">
                <form action="adicionar_menu.php"  method="post" enctype="multipart/form-data">
                    <?php echo mostarErro(); ?>
                    <div class="input-group">
                        <label>Nome</label>
                        <input type="text" name="ad_nome" placeholder="Nome">
                    </div>
                    <div class="input-group">
                        <label>Preço</label>
                        <input type="text" name="ad_preco" placeholder="Preço">
                    </div>
                    <div class="input-group">
                        <label>Descrição</label>
                        <input type="text" name="ad_desc" placeholder="Descrição">
                    </div>
                    <div class="input-group">
                        <label>Tipo de Item</label>
                        <input type="text" name="ad_tipo" placeholder="Ex bebida">
                    </div>

                    <div class="input-group">
                        <label>Imagem</label>
                        <input type="file" name="ficheiro">
                    </div>
                    
                    

                    <button type="submit" class="botao" name="add_item_btn"> Adicionar </button>

                </form>
            <?php endif ?>
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