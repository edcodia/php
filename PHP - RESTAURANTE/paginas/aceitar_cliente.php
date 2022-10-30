<?php 
include('../basedados/basedados.h');

$id = $_POST['aceitar_utlz_id'];

//Atualizar com base no id do utilizador existente na tabela da base de dados
//query : atualizar onde id = $id
// O valor de validado está a ser alterado para 1, ou seja, o utilizador foi validado

$query = " UPDATE rest_user SET validado = 1 WHERE id = $id"; 

if (mysqli_query($db, $query)) {
    mysqli_close($db);

    // caso atualize : redireccionar a página para a página registos_pendentes.php usando o método header()

    header('Location: registos_pendentes.php'); 
    exit;
} else {
    echo "Erro na atualização do registo";
}

?>