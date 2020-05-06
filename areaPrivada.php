<?php
session_start();
if(!isset($_SESSION['id_usuario']))
{
	header("location:index.php");
	exit();
} 

?>
<?php
require_once 'classes/Livro.php';

$p = new Livro("sistemalogin","localhost","root",""); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cadastro de Livros</title>
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
	if(isset($_POST['autor']))
	{
		//-----------editar--------
		if(isset($_GET['id_up']) && !empty($_GET['id_up']))
		{
		  $id_upd = addslashes($_GET['id_up']);
		  $autor = addslashes($_POST['autor']);
          $titulo = addslashes($_POST['titulo']);
          $pagina = addslashes($_POST['pagina']);
          $editora = addslashes($_POST['editora']);
          $ano = addslashes($_POST['ano']);
          $categoria = addslashes($_POST['categoria']);
          if(!empty($autor) && !empty($titulo) && !empty($pagina) && !empty($editora) && !empty($ano) && !empty($categoria))
     {
        $p->atualizarDados($id_upd,$autor,$titulo,$pagina,$editora,$ano,$categoria);
        header("location: areaPrivada.php");
        
        
     }
     else
     {
        echo "preencha todos os campos!";
          }


		}
     
     
	 
         //-----------cadastrar---------
		else
		{
          $autor = addslashes($_POST['autor']);
          $titulo = addslashes($_POST['titulo']);
          $pagina = addslashes($_POST['pagina']);
          $editora = addslashes($_POST['editora']);
          $ano = addslashes($_POST['ano']);
          $categoria = addslashes($_POST['categoria']);
          if(!empty($autor) && !empty($titulo) && !empty($pagina) && !empty($editora) && !empty($ano) && !empty($categoria))
     {
        if(!$p->cadastrarLivro($autor,$titulo,$pagina,$editora,$ano,$categoria))
        
        {
         echo "Livro ja cadastrado";
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
		$res = $p->buscarDadosLivro($id_update);
	} 
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>CADASTRAR LIVROS</h2>
			<label for="autor">Autor</label>
			<input type="text" name="autor" id="autor" value="<?php if(isset($res)){echo $res['autor'];}?>">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" id="titulo" value="<?php if(isset($res)){echo $res['titulo'];}?>">
			<label for="pagina">Pagina</label>
			<input type="number" name="pagina" id="pagina" value="<?php if(isset($res)){echo $res['pagina'];}?>">
			<label for="editora">Editora</label>
			<input type="text" name="editora" id="editora" value="<?php if(isset($res)){echo $res['editora'];}?>">
			<label for="ano">Ano</label>
			<input type="date" name="ano" id="ano" value="<?php if(isset($res)){echo $res['ano'];}?>">
			<label for="categoria">CATEGORIA</label>
			<input type="text" name="categoria" id="categoria" value="<?php if(isset($res)){echo $res['categoria'];}?>">
			<input type="submit" 
			value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
		</form>
	</section>
	<section id="direita">
		<input type="text" name="" id="pesquisar" placeholder="pesquisar" value = "<?= (isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '') ?>">
		<table>
			<tr id="titulo">
				<td>AUTOR</td>
				<td>TÍTULO</td>
				<td>PÁGINAS</td>
				<td>EDITORA</td>
				<td>ANO</td>
				<td>CATEGORIA</td>
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
              	<a href="areaPrivada.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
              	<a href="areaPrivada.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
              </td>
              <?php
              echo "</tr>";
            }
            
            
            
		   }else{
		   	echo "Ainda não há pessoa cadastradas";
		   }
		?>
		</table>
	</section>
</body>
</html>
<?php
  if(isset($_GET['id']))
  {
  	$id_livro = addslashes($_GET['id']);
  	$p->excluirLivro($id_livro);
  	header("location: areaPrivada.php");
  } 
?>

<a href="home.php" id="voltar">volta a página inicial</a>