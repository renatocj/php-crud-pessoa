<?php

class Pessoa {
	
	// 6 funcoes
	
	private $pdo;
	// conexao com o banco de dados
	public function __construct($dbname, $host, $user, $senha)
	{
		try
		{
			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
		}
		catch (PDOException $e){
			echo "Erro com banco de dados: ".$e->getMessage();
			exit();
		}
		catch(Exception $e){
			echo "Erro generico: ".$e->getMessage();
			exit();
		}
	}
	
	// Funcao para buscar dados e colocar no canto direito da tela section lado direito
	public function buscarDados()
	{
		// $cmd = $this->pdo->prepare("SELECT * FROM pessoa ORDER BY id DESC");
		$res = array();
		$cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
		$res = $cmd->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}
	
	// funcao de cadastrar pessoa no banco de dados
	public function cadastrarPessoa($nome, $telefone, $email)
	{
		//Antes de cadastrar verificar se ja tem o email cadastrado
		$cmd = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();
		if($cmd->rowCount() > 0) // email ja existe no banco
		{
			return false;
		}else // nao foi encontrado o email
		{
			$cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES(:n, :t,:e)");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":t",$telefone);
			$cmd->bindValue(":e",$email);
			$cmd->execute();
			return true;
		}
	}
	
	public function excluirPessoa($id)
	{
		$cmd->$pdo->prepare("DELETE FROM pessoa WHERE id = :id");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
	}
	
	//BUSCAR DADOS DE UM PESSOA ESPECIFICA
	
	public function buscarDadosPessoa($id)
	{
		$res = array();
		$cmd->$pdo->prepare("SELECT * FROM pessoa WHERE ID = :ID");
		$cmd->bindValue(":id",$id);
		$cmd->execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res;
	}
			
	// ATUALIZAR DADOS NO BANCO DE DADOS
	
	public function atualizarDados($id, $nome, $telefone, $email)
	{
		// antes de atualizar verificar se email ja esta cadastrado
		
		$cmd = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();
		if($cmd->rowCount() > 0) // email ja existe no banco
		{
			return false;
		}else // nao foi encontrado o email
		{
		
			$cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":t",$telefone);
			$cmd->bindValue(":e",$email);
			$cmd->bindValue(":id",$id);
			$cmd->execute();
			return true;
		}
	}	
}
?>