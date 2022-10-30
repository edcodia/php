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

 <?php if (isset($_SESSION['user']) && $_SESSION['user']['user_type']=='cliente') : ?>

    <div class="header u_logado">
            <?php echo clienteMenu() ?>
    </div>


        <!-- Informação -->
    <div class="roww">
            <form  method="post" action="editar_res.php">
                <?php 
                    echo mostarErro(); 
                    $id = e($_POST['edit_id']);
                    $user_id = $_SESSION['id_utilizador'];
                    
                    $query = "SELECT * FROM reserva WHERE user_id = '$user_id' AND id = '$id'";
                    $results = mysqli_query($db, $query);
                    $row = mysqli_fetch_array($results);
                ?>
                <div class="input-group">
                    <label>Data : <?php echo $row['data'] ?> </label>
                    <input type="date" name="edit_data_res" placeholder="<?php echo $row['data'] ?>"><br>
                    <input type='hidden' name='ed_id' value='<?php echo $id ?>'>
                </div>
                <div class="input-group">
                    <label>Hora: <?php echo $row['hora'] ?></label>
                    <input type="time" name="edit_hora_res" placeholder="<?php echo $row['hora'] ?>"><br>
                </div>
                <div class="input-group">
                    <label>Lugares</label>
                    <input type="text" name="edit_lugar_res" placeholder="<?php echo $row['lugares'] ?>"><br>
                </div>

                <div class="input-group">
                    <label>Pedido</label>
                    <input type="text" name="edit_pedido_res" placeholder="<?php echo $row['pedido'] ?>"><br>
                </div>
                
               

                <input type="submit" class="botao" value="Reservar" name="edit_res_bt">

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