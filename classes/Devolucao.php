<?php 
class Devolucao{
  private $pdo;
  public function __construct($dbname, $host, $user, $password)
  {
    try
    {
    $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$password );
    }
    catch(PDOException $e){
     echo "Erro com banco de dados:".$e->getMessage();
    }
    catch(Exception $e){
    echo "Erro genérico:".$e->getMessage();
    }

  }
   public function buscarDados()
   {
    $res = array();
    $cmd = $this->pdo->query("SELECT * FROM devolvido ORDER BY nome");
    $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $res;
   }
   public function cadastrarDevolucao($nome, $cpf, $livro, $dataDevolucao, $observacao)
   {
    $cmd = $this->pdo->prepare("SELECT from id from devolvido WHERE nome = :n");
    $cmd->bindValue(":n", $nome);
    $cmd->execute();
    if($cmd->rowCount() > 0)
    {
      return false;
    }else
    {
      $cmd = $this->pdo->prepare("INSERT INTO devolvido(nome,cpf,livro,dataDevolucao,observacao) VALUES (:n, :c, :l, :d, :o)");
      $cmd->bindValue(":n", $nome);
      $cmd->bindValue(":c", $cpf);
      $cmd->bindValue(":l", $livro);
      $cmd->bindValue(":d", $dataDevolucao);
      $cmd->bindValue(":o", $observacao);
      $cmd->execute();
      return true;
    
    }
   }
   public function excluirDevolucao($id)
   {
     $cmd = $this->pdo->prepare("DELETE FROM devolvido WHERE id= :id");
     $cmd->bindValue(":id", $id);
     $cmd->execute();
   }
   public function buscarDadosDevolucao($id)
   {
    $res = array();
      $cmd = $this->pdo->prepare("SELECT * FROM devolvido WHERE id = :id");
      $cmd->bindValue(":id", $id);
      $cmd->execute();
      $res = $cmd->fetch(PDO::FETCH_ASSOC);
      return $res;
   }
   public function atualizarDados($id,$nome,$cpf,$livro,$dataDevolucao,$observacao)
   {
    
     $cmd = $this->pdo->prepare("UPDATE devolvido SET nome = :n, cpf = :c, livro = :l, dataDevolucao = :d, observacao = :o WHERE id = :id");
     $cmd->bindValue(":n", $nome);
     $cmd->bindValue(":c", $cpf);
     $cmd->bindValue(":l", $livro);
     $cmd->bindValue(":d", $dataDevolucao);
     $cmd->bindValue(":o", $observacao);
     
     $cmd->bindValue(":id", $id);
     $cmd->execute();
    
   }
}
?>