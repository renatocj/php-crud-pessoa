<?php
require_once 'classe-pessoa.php';
$p = new Pessoa("crudpdo","localhost","root","123");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="estilo.css">
    <title>Cadastrar Pessoa</title>
</head>
<body>
	<?php
		if(isset($_POST['nome']))//clicou no botao cadastrar ou editar
	{
			// ----------------------- Editar
			if(isset($_GET['id_up']) && !empty($_GET['id_up']))
			{
			$id_upd 	= addslashes($_GET['id_up']);
			$nome   	= addslashes($_POST['nome']);
			$telefone 	= addslashes($_POST['telefone']);
			$email 		= addslashes($_POST['email']);
			
			if(!empty($nome) && !empty($telefone) && !empty($email)
			   )
			{
				//Editar
				$p->atualizarDados($id_upd, $nome, $telefone, $email);
			}else{
				echo "Preencha todos os campos";
			}
		
		}
			// --------------------- Cadastrar
			else
			{
			$nome 		= addslashes($_POST['nome']);
			$telefone 	= addslashes($_POST['telefone']);
			$email 		= addslashes($_POST['email']);
			if(!empty($nome) && !empty($telefone) && !empty($email)
			   ){
				//cadastrar
				if(!$p->cadastrarPessoa($nome, $telefone, $email))
				{
				
					echo "Email ja esta cadastrado!";
				}
				
			}
			else
			{
				echo "Preencha todos os campos";
			}
			}
			
			$nome 		= addslashes($_POST['nome']);
			$telefone 	= addslashes($_POST['telefone']);
			$email 		= addslashes($_POST['email']);
			if(!empty($nome) && !empty($telefone) && !empty($email)
			   ){
				//cadastrar
				if(!$p->cadastrarPessoa($nome, $telefone, $email))
				{
				
					echo "Email ja esta cadastrado!";
				}
				
			}
			else
			{
				?>
					<div>
						<img src="">
						<h4>Preencha todos os campos</h4>
					</div>
				
				<?php
			
			}
		}
	?>
	<?php
	
		if(isset($_GET['id_up'])) //se a pessoa clicou no botao editar
		{
			$id_update = addslashes($_GET['id_up']);
			$res = $p->buscarDadosPessoa($id_update);
		}
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>Cadastrar pessoa</h2>
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome"
			value="<?php if(isset($res)){echo $res['nome'];}?>">
			
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone"
			value="<?php if(isset($res)){echo $res['telefone'];}?>">
			
			<label for="email">Email</label>
			<input type="email" name="email" id="email"
			value="<?php if(isset($res)){echo $res['email'];}?>">
			
			<input type="submit" 
			value="<?php if(isset($res)){echo "Atualizar";}else{
			echo "Cadastrar";} ?>">
		</form>
	</section>
	
	<section id="direita">
		<table>
			<tr id="titulo">
				<td>Nome</td>
				<td>Telefone</td>
				<td colspan="2">Email</td>
			</tr>
		
		<?php
			$dados = $p->buscarDados();
			
			if(count($dados) > 0)
			{
				for($i=0; $i < count($dados); $i++)
				{
					echo "<tr>";
					foreach($dados[$i] as $k => $v) {
						if($k != "id")
						{
							echo "<td>".$v."</td>";
						}
					}
					?>
						<td>
							<a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
							<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
						</td>
					<?php				
					echo "</tr>";
				}
				
			?>
			<?php 
			}else{
			?>	
		</table>
				
					<div>
						<h4>Ainda n??o h?? pessoas cadastradas</h4>
					</div>
				
				<?php
			}
				?>
	</section>
</body>
</html>

<?php
	if(isset($_GET['id']))
	{
		$id_pessoa = addslashes($_GET['id']);
		$p->excluirPessoa($id_pessoa);
		header("location: index.php");
	}
?>