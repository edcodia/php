<?php 
session_start();


include('../basedados/basedados.h');

// declaração de variável
$nome_utilizador = "";
$mail    = "";
$erros   = array(); 



// devolver array de utilizadores regstados a partir do seu id
function buscarUtilizadorPeloId($id){
	global $db;
	$query = "SELECT * FROM rest_user WHERE id=" . $id;
	$resultado = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($resultado);
	return $user;
}

// chamar a função registar() se register_btn for clicado
if (isset($_POST['register_btn'])) {
	registar();
}

// Registar utilizador
function registar(){
	// chamar estas variáveis com a palavra-chave global para as tornar disponíveis na função
	global $db, $erros, $nome_utilizador, $mail;

	// receber todos os valores de entrada a partir do formulário. Chamar a função e()
	// e() definido abaixo para contornar os valores da forma
	$nome_utilizador    =  e($_POST['nomeUtilizador']);
	$mail       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// validação do formulário: assegurar que o formulário é correctamente preenchido
	if (empty($nome_utilizador)) { 
		array_push($erros, "O nome de utilizador é obrigatório"); 
	}
	if (empty($mail)) { 
		array_push($erros, "O Email é obrigatório"); 
	}
	if (empty($password_1)) { 
		array_push($erros, "A palavra-passe é obrigatória"); 
	}
	if ($password_1 != $password_2) {
		array_push($erros, "As duas palavras-passe não são compatíveis ");
	}


	// registar o utilizador se não houver erros no formulário
	if (count($erros) == 0) {

		//encriptar a palavra-passe antes de guardar na base de dados
		$password = md5($password_1);
	
			$query = "INSERT INTO rest_user (nome, email, password, user_type, validado) 
					  VALUES('$nome_utilizador', '$mail', '$password', 'cliente', '0')";
			mysqli_query($db, $query);

			// obter o id do utilizador criado
			$utilizador_log_id = mysqli_insert_id($db);

			// colocar o utilizador logado na sessão
			$_SESSION['user'] = buscarUtilizadorPeloId($utilizador_log_id); 
			$_SESSION['id_utilizador'] = $utilizador_log_id;
			$_SESSION['sucesso']  = "Está agora resgistado, aguarde a confirmação do administrador para poder fazer login";
			header('location: login.php');				
		}

}

if (isset($_POST['cr_utlzr_bt'])) {
	criar_utilizador();
}

function criar_utilizador(){
	// chamar estas variáveis com a palavra-chave global para as tornar disponíveis na função
	global $db, $erros, $nome_utilizador, $mail;

	// receber todos os valores de entrada a partir do formulário. Chamar a função e()
	// e() definido abaixo para contornar os valores da forma
	$nome_utilizador    =  e($_POST['cr_nomeUtilizador']);
	$mail       =  e($_POST['cr_email']);
	$password_1  =  e($_POST['cr_password_1']);
	$password_2  =  e($_POST['cr_password_2']);
   
	// validação do formulário: assegurar que o formulário é correctamente preenchido
	if (empty($nome_utilizador)) { 
		array_push($erros, "O nome de utilizador é obrigatório"); 
	}
	if (empty($mail)) { 
		array_push($erros, "O Email é obrigatório"); 
	}
	if (empty($password_1)) { 
		array_push($erros, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($erros, "As duas palavras-passe não são compatíveis ");
	}

	// registar o utilizador se não houver erros no formulário
	if (count($erros) == 0) {
		//encriptar a palavra-passe antes de guardar na base de dados
		$password = md5($password_1);

		if (isset($_POST['user_type'])) {
			$tipo_utilizador = e($_POST['user_type']);
			$query = "INSERT INTO rest_user (nome, email, user_type, password, validado) 
					  VALUES('$nome_utilizador', '$mail', '$tipo_utilizador', '$password', '1')";
			mysqli_query($db, $query);

			// Colocar a mensagem de sucesso na sessão
			$_SESSION['sucesso']  = "Novo utilizador criado com sucesso!!";
			header('Location: gerir_utilizadores.php');

		}else{
			array_push($erros, "Insira o tipo de Utilizador");
					
		}
	}
}
function mostarErro() {
	global $erros;

	if (count($erros) > 0){
		echo '<div class="erro">';
			foreach ($erros as $erro){
				echo $erro .'<br>';
			}
		echo '</div>';
	}
}	

// função de contorno para os valores de entrada
// A função real_escape_string() / mysqli_real_escape_string() contornar caracteres especiais em uma string para uso em uma consulta SQL, levando em consideração o conjunto de caracteres atual da conexão.
//Esta função é usada para criar uma string SQL legal que pode ser usada em uma instrução SQL. 
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}




// chamar a função login() se o register_btn for clicado
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN de utilizador
function login(){
	global $db, $nome_utilizador, $erros;

	// Pega os dados do formulário
	$nome_utilizador = e($_POST['nomeUtilizador']);
	$password = e($_POST['password']);

	// certificar-se de que o formulário é devidamente preenchido
	if (empty($nome_utilizador)) {
		array_push($erros, "O nome de utilizador é obrigatório");
	}
	if (empty($password)) {
		array_push($erros, "É necessária uma palavra-passe");
	}

	// tentativa de login se não houver erros no formulário
	if (count($erros) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM rest_user WHERE nome='$nome_utilizador' AND password='$password' LIMIT 1";
		$resultados = mysqli_query($db, $query);

		if (mysqli_num_rows($resultados) == 1) { 
			
			// utilizador encontrado
			// verificar se o utilizador é administrador, chefe de mesa ou utilizador

			$utilizador_log = mysqli_fetch_array($resultados);
			if ($utilizador_log['validado'] == '1') {
				
				if ($utilizador_log['user_type'] == 'administrador') {

					$_SESSION['user'] = $utilizador_log;
					$_SESSION['id_utilizador'] = $utilizador_log['id'];
					$_SESSION['sucesso']  = "Está agora autenticado";
					header('location: adm_index.php');		  
				} elseif ($utilizador_log['user_type'] == 'chefe_mesa') {
					$_SESSION['user'] = $utilizador_log;
					$_SESSION['id_utilizador'] = $utilizador_log['id'];
					$_SESSION['sucesso']  = "Está agora autenticado";
					header('location: chefe_mesa_index.php');
				}
				
				else{
					$_SESSION['user'] = $utilizador_log;
					$_SESSION['id_utilizador'] = $utilizador_log['id'];
					$_SESSION['sucesso']  = "Está agora autenticado";

					header('location: cliente_index.php');
				}
			}else{
				array_push($erros, "A conta está desativada");
			}
		}else {
			array_push($erros, "Combinação de utilizador/palavra-passe errada");
		}
	}
}


// Fazer reserva de um restaurante

function reservar(){
	global $db, $erros;

	
	$data_atual = date("Y/m/d");
	$data = e($_POST['res_data']);
	$hora = e($_POST['res_hora']);
	$lugar = e($_POST['res_lugar']);
	$pedido = e($_POST['res_pedido']);
	$id_utilizador = $_SESSION['id_utilizador'];
	$timestamp1 = strtotime($data);

	if (empty($data)) {
		array_push($erros, "data é obrigatória");
	}
	if (empty($hora)) {
		array_push($erros, "hora é obrigatória");
	}
	if (empty($lugar)) {
		array_push($erros, "Lugares é obrigatório");
	}

	if ( $lugar != '2' && $lugar!='3' && $lugar!='4' && $lugar!='6') {
		array_push($erros, "Os lugares estão limitados a 2, 3, 4 e 6");
	}
	if ($hora != '11:30' && $hora != '12:30' && $hora != '13:30' && $hora != '14:30' && $hora != '15:30') {
		array_push($erros, "As horas estão limitadas a 11:30, 12:30, 13:30, 14:30 e 15:30");
	}

	if ($timestamp1<strtotime($data_atual)) {
		array_push($erros, "A data tem de ser igual ou superior à data atual");
	}

	if (count($erros) == 0) {

			$query = "SELECT * FROM reserva WHERE data ='$data' AND hora='$hora'";
			$resultados = mysqli_query($db, $query);

			if (mysqli_num_rows($resultados) < 50) {
				$sql = "INSERT INTO reserva (lugares, hora, data, pedido, estado,user_id)
				VALUES ('$lugar', '$hora', '$data_atual', '$pedido', 'Pendente','$id_utilizador')";

				if (mysqli_query($db, $sql)) {
					echo "Novo registo criado com sucesso";
				echo "Novo registo criado com sucesso";
				header('location: minhas_res.php');
				} else {
				echo "Erro: " . $sql . "<br>" . mysqli_error($db);
				}
			}else{
				array_push($erros, "Não há lugares disponiveis para essa data e hora");
			}

	}
}

if (isset($_POST['res_bt'])) {
	reservar();

}

// Mostrar as reservas do utilizador
function mostrarResCliente(){
	global $db;
	$id_utilizador = $_SESSION['id_utilizador'];
	$query = "SELECT * FROM reserva WHERE user_id = '$id_utilizador'";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count == 0){
		echo "<div>Não há reservas</div>";
		
	}
	else{
		
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>Data</th>";
		echo "<th>Horário</th>";
		echo "<th>Lugares</th>";
		echo "<th>Estado</th>";
		echo "<th>Pedido</th>";
		echo "<th colspan='2' align='center'>Operações</th>";
		echo "</tr>";
	
	
		while($linha = mysqli_fetch_array($resultados)){
			echo "<tr>";
			echo "<td>".$linha['data']."</td><td>".$linha['hora']."</td><td>".$linha['lugares']."</td><td>".$linha['estado']."</td><td>".$linha['pedido']."</td>";
			echo "<form action='editar_res.php' method='post'>";
			echo "<td><input type='hidden' name='edit_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='ed_btt' value='Editar'></td>";
			echo "</form>";
			echo "<form action='apagar_res.php' method='post'>";
			echo "<td><input type='hidden' name='remover_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='delete_btn' value='Apagar'></td>";
			echo "</form>";
			echo "</tr>";
		}
		
		echo" </table>";
	}
}

// Mostrar as reservas para o administrador
// Reservas cujo estado é pendente
function mostarResAdmin(){
	global $db;
	$query = "SELECT * FROM reserva where estado = 'Pendente'";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count == 0){
		echo "<div>Não há reservas pendentes</div>";
		
	}
	else{
		
		echo "<table border='1' id='tb'>";
		echo "<tr>";	
		echo "<th>Data</th>";
		echo "<th>Horário</th>";
		echo "<th>Lugares</th>";
		echo "<th>Estado</th>";
		echo "<th>Pedido</th>";
		echo "<th colspan='2' align='center'>Operações</th>";
		echo "</tr>";

		while($linha = mysqli_fetch_array($resultados)){
			echo "<tr>";
			echo "<td>".$linha['data']."</td><td>".$linha['hora']."</td><td>".$linha['lugares']."</td><td>".$linha['estado']."</td><td>".$linha['pedido']."</td>";
			echo "<form action='aceitar_res.php' method='post'>";
			echo "<td><input type='hidden' name='aceitar_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='act_btt' value='Aceitar'></td>";
			echo "</form>";
			echo "<form action='rejeitar_reserva.php' method='post'>";
			echo "<td><input type='hidden' name='rej_res_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='delete_btn' value='Rejeitar'></td>";
			echo "</form>";
	
			echo "</tr>";
		}

		echo" </table>";
	}
}

// Mostrar as reservas para o chefe de mesa
// Reservas cujo estado é Aceite 
function mostarResChefeMesa(){
	global $db;
	$query = "SELECT * FROM reserva where estado = 'Aceite'";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count == 0){
		echo "<div>Não há reservas por atender</div>";
		
	}
	else{
		
		echo "<table border='1'>";
		echo "<tr>";	
		echo "<th>Data</th>";
		echo "<th>Horário</th>";
		echo "<th>Lugares</th>";
		echo "<th>Estado</th>";
		echo "<th>Pedido</th>";
		echo "<th colspan='2' align='center'>Operações</th>";
		echo "</tr>";

		while($linha = mysqli_fetch_array($resultados)){
			echo "<tr>";
			echo "<td>".$linha['data']."</td><td>".$linha['hora']."</td><td>".$linha['lugares']."</td><td>".$linha['estado']."</td><td>".$linha['pedido']."</td>";
			echo "<form action='atender_res.php' method='post'>";
			echo "<td><input type='hidden' name='atender_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='atnd_btt' value='Atender'></td>";
			echo "</form>";
	
			echo "</tr>";
		}

		echo" </table>";
	}
}

// Mostrar todas as reservas independentemente do estado
function mostarTodasReservas(){
	global $db;
	$query = "SELECT * FROM reserva ";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count == 0){
		echo "<div>Não há reservas por atender</div>";
		
	}
	else{
		
		echo "<table border=1>";
		echo "<tr>";	
		echo "<th>Data</th>";
		echo "<th>Horário</th>";
		echo "<th>Lugares</th>";
		echo "<th>Estado</th>";
		echo "<th>Pedido</th>";
		echo "</tr>";

		while($linha = mysqli_fetch_array($resultados)){
			echo "<tr>";
			echo "<td>".$linha['data']."</td><td>".$linha['hora']."</td><td>".$linha['lugares']."</td><td>".$linha['estado']."</td><td>".$linha['pedido']."</td>";
			echo "</tr>";
		}

		echo" </table>";
	}
}

// editar reserva caso clique no botão 
if(isset($_POST['edit_res_bt'])){
	editarReserva();
}
	

// Função para editar a reserva
function editarReserva(){
	global $db, $erros;

	$data_atual = date("Y/m/d");
	$data = e($_POST['edit_data_res']);
	$hora = e($_POST['edit_hora_res']);
	$lugar = e($_POST['edit_lugar_res']);
	$pedido = e($_POST['edit_pedido_res']);
	$id_utilizador = $_SESSION['id_utilizador'];
	$id = e($_POST['ed_id']);
	$timestamp1 = strtotime($data);



	$query = "SELECT * FROM reserva WHERE user_id = '$id_utilizador' AND id = '$id'";
	$resultados = mysqli_query($db, $query);
	$linha = mysqli_fetch_array($resultados);

	if (empty($data)) {
		$data = $linha['data'];
	}
	if (empty($hora)) {
		$hora = $linha['hora'];
	}
	if (empty($lugar)) {
		$lugar = $linha['lugares'];
	}

	if ($timestamp1<strtotime($data_atual)) {
		array_push($erros, "A data tem de ser igual ou superior à data atual");
	}

	if (count($erros) == 0) {
		$sql = "UPDATE reserva SET lugares = '$lugar', hora = '$hora', data = '$data', pedido='$pedido' WHERE id = '$id'";
	
		if (mysqli_query($db, $sql)) {
			$_SESSION['sucesso']  = " Reservas actualizadas com sucesso!!";
			header('location: minhas_res.php');
		}else{
			array_push($erros, "Algo correu mal");
		}
	}
	
	
}

// Cabeçalho para a área do cliente
function clienteMenu(){

	echo "<ul>";
	echo "<li><a href='cliente_index.php'>Início</a></li>";
	echo "<li><a href='reservar.php'>Reservar</a></li>";
	echo "<li><a href='minhas_res.php'>Minhas Reservas</a></li>";
	echo "<li><a href='perfil.php'>Perfil</a></li>";
	echo "<li><a href='logout.php' style='float:right' class='active'>Logout</a></li>";
	echo "</ul>";
}

// Cabeçalho para a área do administrador
function admMenu (){
	echo "<ul>";
	echo "<li><a href='adm_index.php'>Início</a></li>";
	echo "<li><a href='adm_res.php'>Reservas Pendentes</a></li>";
	echo "<li><a href='res_geral.php'>Todas Reservas </a></li>";
	echo "<li><a href='registos_pendentes.php'>Registos Pendentes</a></li>";
	echo "<li><a href='gerir_utilizadores.php'>Gerir Utilizadores</a></li>";

	echo "<li><a href='perfil.php'>Perfil</a></li>";
	echo "<li><a href='logout.php' style='float:right' class='active'>Logout</a></li>";
	echo "</ul>";
}

// Cabeçalho para a área do chefe de mesa
function chefeMesaMenu (){
	echo "<ul>";
	echo "<li><a href='chefe_mesa_index.php'>Início</a></li>";
	echo "<li><a href='chefe_mesa_res.php'>Reservas</a></li>";
	echo "<li><a href='perfil.php'>Perfil</a></li>";
	echo "<li><a href='logout.php' style='float:right class='active'>Logout</a></li>";
	echo "</ul>";
}



function rodape(){
	echo "<footer>";
	echo "<p>Copyright &copy; 2022 - All Rights Reserved - Eduardo-Codia</p>";
	echo "</footer>";
}

function editarPerfil(){
	global $db, $erros;

	$nome = e($_POST['prf_nome']);
	$mail = e($_POST['prf_email']);
	$password1 = e($_POST['prf_password1']);
	$password2 = e($_POST['prf_password2']);

	$id_utilizador = $_SESSION['id_utilizador'];

	$query = "SELECT * FROM rest_user WHERE id = '$id_utilizador'";
	$resultados = mysqli_query($db, $query);
	$linha = mysqli_fetch_array($resultados);

	if (empty($nome)) {
		$nome = $linha['nome'];
	}
	if (empty($mail)) {
		$mail = $linha['email'];
	}
	if (empty($password1)) {
		 $password1 = $linha['password'];
		 $password2 = $linha['password'];
	}
	if ($password1 != $password2) {
		array_push($erros, "As duas palavras-passe não combinam");
	}

	if (count($erros) == 0) {


		$password = md5($password1);

		$sql = "UPDATE rest_user SET nome = '$nome', email = '$mail', password = '$password' WHERE id = '$id_utilizador'";

		if (mysqli_query($db, $sql)) {
			$_SESSION['sucesso']  = "Perfil actualizado com sucesso!!";
			$_SESSION['user']['nome'] = $nome;
			header('location: perfil.php');
		}else{
			array_push($erros, "Algo correu mal");
		}
	}
}

if (isset($_POST['prf_bt'])) {
	editarPerfil();
}

if (isset($_POST['add_item_btn'])) {
	adicionarItem();
}

function adicionarItem(){
	global $db, $erros;
	
	$nome_imagem = $_FILES['ficheiro']['name'];
	$diretorio_destino = "./";
	$ficheiro_destino = $diretorio_destino . basename($nome_imagem);	

	$nome = e($_POST['ad_nome']);
	$preco = e($_POST['ad_preco']);
	$tipo_item = e($_POST['ad_tipo']);
	$desc = e($_POST['ad_desc']);


	if ($_FILES['ficheiro']['error']!=0) {
		array_push($erros, "Ocorreu um erro ao carregar a imagem");
	}

	if ( empty($nome)){
		array_push($erros, "O nome não pode estar vazio");
	}

	if ( empty($preco)){
		array_push($erros, "O preço não pode estar vazio");
	}

	if ( empty($tipo_item)){
		array_push($erros, "O tipo não pode estar vazio");
	}

	if ( empty($desc)){
		array_push($erros, "A descrição não pode estar vazia");
	}

	if ( count($erros)==0){
		$tipoImagem = strtolower(pathinfo($ficheiro_destino,PATHINFO_EXTENSION));

		// Extensões de ficheiro válidas
		$extensions_arr = array("jpg","jpeg","png","gif");

		// Verificar extensão
		if( in_array($tipoImagem,$extensions_arr) ){
			// Carregar ficheiro
			if(move_uploaded_file($_FILES['ficheiro']['tmp_name'],$diretorio_destino.$nome_imagem)){

			// Converter para base64
			$imagem_base64 = base64_encode(file_get_contents('./'.$nome_imagem) );
			$imagem = 'data:image/'.$tipoImagem.';base64,'.$imagem_base64;
				
			// Inserir registo

			$query = "INSERT INTO menu (nome, preco, tipo, descricao, imagem) VALUES ('$nome', $preco, '$tipo_item', '$desc', '$imagem')";

			if (mysqli_query($db, $query)) {
				$_SESSION['sucesso']  = "Prato adicionado com sucesso!!";
				header('location: adicionar_menu.php');
			}else{
				array_push($erros, "Algo correu mal");
			}
		}

	}
}
}

// Mostar os registos dos utilizadores pendentes
function mostarRegistosPendentes(){
	global $db;
	$query = "SELECT * FROM rest_user WHERE validado = '0'";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count >0){

		echo "<table border=1>";
		echo "<tr>";	
		echo "<th>Nome</th>";
		echo "<th>Email</th>";
		echo "<th>Estado</th>";
		echo "<th olspan='2' align='center'>Operação</th>";
		
		echo "</tr>";

		while ($linha = mysqli_fetch_array($resultados)) {
			echo "<tr>";
			echo "<td>".$linha['nome']."</td>";
			echo "<td>".$linha['email']."</td>";
			echo "<td>".$linha['validado']."</td>";
			echo "<form action='aceitar_cliente.php' method='post'>";
			echo "<td><input type='hidden' name='aceitar_utlz_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='aceitar_utlz_bt' value='Aceitar'></td>";
			echo "</form>";
			echo "</tr>";
		}
	}
	else{
		echo "Não há registos pendentes";
	}

	

}

// Mostar os itens do menu disponiveis no restaurante
function mostrarPratos(){
	global $db;
	$query = "SELECT * FROM menu";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count >0){

			

		echo "<ul class='cartaos'>";

		while ($linha = mysqli_fetch_array($resultados)) {

			
			echo "<li>";
			echo "<div class='cartao_spc'>";
			echo "<a href='' class='cartao'>"	;
			echo "<img src='".$linha['imagem']."' class='cartao__image' alt='' />";		
			echo "<div class='cartao__header'>";		
			echo "<div class='cartao__header-text'>";			
			echo "<h3 class='cartao__title'>Nome: ".$linha['nome']."</h3> "	;			           
			echo "<span class='cartao__status'>Preço: ".$linha['preco']."</span>"		;		
			echo "</div>"			;
			echo "</div>"			;
			echo "<p class='cartao__description'> Descrição: ".$linha['descricao']."</p>";			
			echo "</a>  "	;
			echo "</div>"	;
			echo "	</li>";
			
		}
		echo "</ul>";
	}
	else{
		echo "Não há pratos registados";
	}
}

// Mostrar as reservas do utilizador
function mostrarUtilizadores(){
	global $db;
	$query = "SELECT * FROM rest_user";
	$resultados = mysqli_query($db, $query);

	$count = mysqli_num_rows($resultados);

	if($count == 0){
		echo "<div>Não há reservas</div>";
		
	}
	else{
		
		echo "<table border='1'>";
		echo "<tr>";
		echo "<th>Nome</th>";
		echo "<th>Email</th>";
		echo "<th>Tipo </th>";
		echo "<th colspan='2' align='center'>Operações</th>";
		echo "</tr>";
	
	
		while($linha = mysqli_fetch_array($resultados)){
			echo "<tr>";
			echo "<td>".$linha['nome']."</td><td>".$linha['email']."</td><td>".$linha['user_type']."</td>";
			echo "<form action='apagar_utilizador.php' method='post'>";
			echo "<td><input type='hidden' name='remover_usr_id' value='".$linha['id']."'></td>";
			echo "<td><input type='submit' name='delete_btn' value='Apagar'></td>";
			echo "</form>";
			echo "</tr>";
		}
		
		echo" </table>";
	}
}