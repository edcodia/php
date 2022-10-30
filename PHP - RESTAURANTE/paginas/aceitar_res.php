<?php 
include('../basedados/basedados.h');

$id = $_POST['aceitar_id'];

//Atualizar com base no id do utilizador existente na tabela da base de dados
//query : atualizar onde id = $id
// O valor de estado está a ser alterado para Aceite, ou seja, o a reserva foi aceite
$query = " UPDATE reserva SET estado = 'Aceite' WHERE id = $id"; 

if (mysqli_query($db, $query)) {
    mysqli_close($db);

     // caso atualize : redireccionar a página para a página adm_res.php usando o método header()
    header('Location: adm_res.php'); 
    exit;
} else {
    echo "Erro na atualização do registo";
}

?>