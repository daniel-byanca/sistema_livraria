<?php
session_start();
if(!isset($_SESSION['id_usuario']))
{
  header("location:index.php");
  exit();
} 

?>
<?php
require_once 'classes/Categoria.php';

$p = new Categoria("sistemalogin","localhost","root",""); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>CADASTRAR CATEGORIA</title>
  <link rel="stylesheet" href="CSS/Area_Privada.css">
  <link rel="stylesheet" type="text/css" href="CSS/Homes.css">
</head>
<body>
<nav id="menu">
    <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="Usuarios_ext.php">USUARIOS</a></li>
        <li><a href="categoria_Livro.php">CATEGORIA LIVRO</a></li>
        <li><a href="areaPrivada.php">CADASTRO LIVROS</a></li>
        <li><a href="emprestimoExterno.php">EMPRESTIMOS</a></li>
        <li><a href="Devolucao.php">DEVOLUÇÃO</a></li>
<a href="sair.php" style="text-align: right;background-color: blue;"> SAIR </a>
    </ul>
</nav>
  <?php
  if(isset($_POST['nome']))
  {
    //-----------editar--------
    if(isset($_GET['id_up']) && !empty($_GET['id_up']))
    {
      $id_upd = addslashes($_GET['id_up']);
      $nome = addslashes($_POST['nome']);
      $qtd = addslashes($_POST['qtd']);
          if(!empty($nome) && !empty($qtd))
     {
        $p->atualizarDados($id_upd,$nome,$qtd);
        header("location: categoria_Livro.php");
        
        
     }
     else
     {
        echo "preencha todos os campos!";
          }


    }
     
     
   
         //-----------cadastrar---------
    else
    {
          $nome = addslashes($_POST['nome']);
          $qtd = addslashes($_POST['qtd']);
          if(!empty($nome) && !empty($qtd))
     {
        if(!$p->cadastrarCategoria($nome,$qtd))
        
        {
         echo "Categoria ja cadastrado";
        }
     }
     else
     {
        echo "preencha todos os campos!";
     }
    }
     
     
  } 
  ?>
  <?php
  if(isset($_GET['id_up']))
  {
    $id_update = addslashes($_GET['id_up']);
    $res = $p->buscarDadosCategoria($id_update);
  } 
  ?>
  <section id="esquerda">
    <form method="POST">
      <h2>CADASTRAR CATEGORIA</h2>
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
      <label for="qtd">Quantidade</label>
      <input type="text" name="qtd" id="qtd" value="<?php if(isset($res)){echo $res['qtd'];}?>">
      <input type="submit" 
      value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
    </form>
  </section>
  <section id="direita">
    <input type="text" name="" id="pesquisar" placeholder="pesquisar" value = "<?= (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '') ?>">
    <table>
      <tr id="titulo">
        <td>NOME</td>
        <td>QUANTIDADE</td>
        <td>AÇÃO</td>

      </tr>
    <?php
    $dados = $p->buscarDados(); 
    if(count($dados) > 0)
    {
             for ($i=0; $i < count($dados); $i++) 
             { 
              echo "<tr>";
             foreach ($dados[$i] as $k => $v) 
             {
              if($k != "id")
              {
                    echo "<td>".$v."</td>";
              }
              }
              ?>
              <td>
                <a href="categoria_Livro.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                <a href="categoria_Livro.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
              </td>
              <?php
              echo "</tr>";
            }
            
            
            
       }else{
        echo "Ainda não há categorias cadastradas";
       }
    ?>
    </table>
  </section>
</body>
</html>
<?php
  if(isset($_GET['id']))
  {
    $id_categoria = addslashes($_GET['id']);
    $p->excluirCategoria($id_categoria);
    header("location: categoria_Livro.php");
  } 
?>

<a href="home.php" id="voltar">volta a página inicial</a>