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
<html lang="pt-br">
<head>
	<title></title>
	<meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="CSS/Homes.css">
  <link rel="stylesheet" href="CSS/Area_Privada.css">
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
<a href="sair.php" style="text-align: right;background-color: blue; font-size: 20px;color: black;text-decoration: none;"> SAIR </a>
    </ul>
</nav>
<?php
    if(isset($_POST['nome']))
    {
        //-----------editar--------
        if(isset($_GET['id_up']) && !empty($_GET['id_up']))
        {
          $id_upd = addslashes($_GET['id_up']);
          $id = addslashes($_POST['id']);
          $nome = addslashes($_POST['nome']);
          if(!empty($id) && !empty($nome))         

     {
        $p->atualizarDados($id_upd,$id,$nome);
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
          if(!empty($nome))
     {
        if(!$p->cadastrarCategoria($nome))
        
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
        $res = $p->buscarDadoscategoria($id_update);
    } 
    ?>
<section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR LIVROS</h2>
            <label for="id">ID</label>
            <input type="text" name="id" id="id" value="<?php if(isset($res)){echo $res['id'];}?>">
            <label for="nome">NOME</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
            <input type="submit" 
            value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
        </form>
    </section>
    <section id="direita">
        <input type="text" name="" id="pesquisar" placeholder="pesquisar" value = "<?= (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '') ?>">
        <table>
            <tr id="titulo">
                <td>ID</td>
                <td colspan="2">NOME</td>
                
            
                

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
</body>
</html>
<?php
  if(isset($_GET['id']))
  {
    $id_categorias = addslashes($_GET['id']);
    $p->excluirCategoria($id_categorias);
    header("location: categoria_Livro.php");
  } 
?>

<a href="home.php" id="voltar">volta a página inicial</a>