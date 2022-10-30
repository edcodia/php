<?php 
include('../basedados/basedados.h');

$id = $_POST['remover_id'];

//Apagar com base no id do utilizador existente na tabela da base de dados
//query : apagar onde id = $id
$query = "DELETE FROM reserva WHERE id = $id"; 

if (mysqli_query($db, $query)) {
    mysqli_close($db);

    // caso apague : redireccionar a página para a página minhas_res.php usando o método header()
    header('Location: minhas_res.php');
} else {
    echo "Erro na eliminação do registo";
}

?>