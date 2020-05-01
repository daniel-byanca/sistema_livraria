<?php 
class Emprestimo{
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
    $cmd = $this->pdo->query("SELECT * FROM emprestimo ORDER BY nome");
    $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $res;
   }
   public function cadastrarEmprestimo($cpf, $nome, $livro, $dataEmprestimo, $dataEmtrega, $situacao)
   {
    $cmd = $this->pdo->prepare("SELECT from id from emprestimo WHERE nome = :n");
    $cmd->bindValue(":n", $nome);
    $cmd->execute();
    if($cmd->rowCount() > 0)
    {
      return false;
    }else
    {
      $cmd = $this->pdo->prepare("INSERT INTO emprestimo(cpf,nome,livro,dataEmprestimo,dataEmtrega,situacao) VALUES (:c, :n, :l, :d, :e, :s)");
      $cmd->bindValue(":c", $cpf);
      $cmd->bindValue(":n", $nome);
      $cmd->bindValue(":l", $livro);
      $cmd->bindValue(":d", $dataEmprestimo);
      $cmd->bindValue(":e", $dataEmtrega);
      $cmd->bindValue(":s", $situacao);
      $cmd->execute();
      return true;
    }
   }
   public function excluirEmprestimo($id)
   {
     $cmd = $this->pdo->prepare("DELETE FROM emprestimo WHERE id= :id");
     $cmd->bindValue(":id", $id);
     $cmd->execute();
   }
   public function buscarDadosEmprestimo($id)
   {
    $res = array();
      $cmd = $this->pdo->prepare("SELECT * FROM emprestimo WHERE id = :id");
      $cmd->bindValue(":id", $id);
      $cmd->execute();
      $res = $cmd->fetch(PDO::FETCH_ASSOC);
      return $res;
   }
   public function atualizarDados($id,$cpf,$nome,$livro,$dataEmprestimo,$dataEmtrega,$situacao)
   {
    
     $cmd = $this->pdo->prepare("UPDATE emprestimo SET cpf = :c, nome = :n, livro = :l, dataEmprestimo = :d, dataEmtrega = :e, situacao = :s WHERE id = :id");
     $cmd->bindValue(":c", $cpf);
     $cmd->bindValue(":n", $nome);
     $cmd->bindValue(":l", $livro);
     $cmd->bindValue(":d", $dataEmprestimo);
     $cmd->bindValue(":e", $dataEmtrega);
     $cmd->bindValue(":s", $situacao);
     $cmd->bindValue(":id", $id);
     $cmd->execute();
    
   }
   //-------------pesquisar------------
   
      //------------codigo termina aqui--------
}
?>