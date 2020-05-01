<?php 
class Categoria{
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
    $cmd = $this->pdo->query("SELECT * FROM categorias ORDER BY nome");
    $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
    return $res;
   }
   public function cadastrarCategoria($nome)
   {
    $cmd = $this->pdo->prepare("SELECT from id from categorias WHERE nome = :n");
    $cmd->bindValue(":n", $nome);
    $cmd->execute();
    if($cmd->rowCount() > 0)
    {
      return false;
    }else
    {
      $cmd = $this->pdo->prepare("INSERT INTO categorias(nome) VALUES (:n)");
      $cmd->bindValue(":n", $nome);
      $cmd->execute();
      return true;
    
    }
   }
   public function excluirCategoria($id)
   {
     $cmd = $this->pdo->prepare("DELETE FROM categorias WHERE id= :id");
     $cmd->bindValue(":id", $id);
     $cmd->execute();
   }
   public function buscarDadosCategoria($id)
   {
    $res = array();
      $cmd = $this->pdo->prepare("SELECT * FROM categorias WHERE id = :id");
      $cmd->bindValue(":id", $id);
      $cmd->execute();
      $res = $cmd->fetch(PDO::FETCH_ASSOC);
      return $res;
   }
   public function atualizarDados($id,$nome)
   {
    
     $cmd = $this->pdo->prepare("UPDATE categorias SET nome = :n WHERE id = :id");
     $cmd->bindValue(":n", $nome);
     $cmd->bindValue(":id", $id);
     $cmd->execute();
    
   }
}
?>