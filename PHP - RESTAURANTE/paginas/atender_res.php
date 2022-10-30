<?php 
include('../basedados/basedados.h');

$id = $_POST['atender_id'];

//Atualizar com base no id do utilizador existente na tabela da base de dados
//query : atualizar onde id = $id
// O valor de estado está a ser alterado para Atendida, ou seja, o a reserva foi Atendida
$query = " UPDATE reserva SET estado = 'Atendida' WHERE id = $id"; 

if (mysqli_query($db, $query)) {
    mysqli_close($db);

         // caso atualize : redireccionar a página para a página chefe_mesa_res.php usando o método header()

    header('Location: chefe_mesa_res.php'); 
    exit;
} else {
    echo "Erro na atualização do registo";
}

?>