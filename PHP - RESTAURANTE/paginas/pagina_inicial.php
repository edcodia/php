<?php include('funcoes.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="conteudo">
        <div class="header">
            <ul>
                <li><a href="pagina_inicial.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="#contactos">Contatos</a></li>
                <li><a href="#horario">Horários</a></li>
                <li><a href="login.php" class="botao">Login</a></li>
            </ul>
        </div>

       
    

    <div class="horario" id="horario">
        <h2>Horários</h2>
        <p>
            <span>Segunda-feira à Sexta-feira</span><br>
            <span>11:30 - 12:30</span> <br>
            <span>12:30 - 13:30</span> <br>
            <span>13:30 - 14:30</span> <br>
            <span>14:30 - 15:30</span> <br>
        </p>    
    </div>

    <div class="roww">
        <div class="contact" id="contactos">
            <div class="contact-info">
                <div>

                    <span>Endereço:</span>
                    <p>
                        Rua de São Bartolomeu, nº 0
                    </p>
                    
                </div>
                
                <div>
                    <span>Telefone:</span>

                    <p>
                        
                        (+351) 999-999-999
                    </p>
                </div>

                <div>
                    <span>E-mail:</span>

                    <p>
                        <a href="mailto:">  restaurante@gmail.com</a>
                    
                    </p>
                </div>

            </div>

        </div>

    </div>

    <div class="footer">
        <?php echo rodape(); ?>
    </div>

</div>

</body>
</html>