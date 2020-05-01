<?php
session_start();
if(!isset($_SESSION['id_usuario']))
{
	header("location:index.php");
	exit();
} 

?>
<?php
require_once 'classes/Devolucao.php';
$p = new Devolucao("sistemalogin","localhost","root",""); 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="CSS/Usuario_estilo.css">
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
          $cpf = addslashes($_POST['cpf']);
          $livro = addslashes($_POST['livro']);
          $dataDevolucao = addslashes($_POST['dataDevolucao']);
          $observacao = addslashes($_POST['observacao']);
          
          if(!empty($nome) && !empty($cpf) && !empty($livro) && !empty($dataDevolucao) && !empty($observacao))
     {
        $p->atualizarDados($id_upd,$nome,$cpf,$livro,$dataDevolucao,$observacao,);
        header("location: devolucao.php");
        
        
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
          $cpf = addslashes($_POST['cpf']);
          $livro = addslashes($_POST['livro']);
          $dataDevolucao = addslashes($_POST['dataDevolucao']);
          $observacao = addslashes($_POST['observacao']);
          if(!empty($nome) && !empty($cpf) && !empty($livro) && !empty($dataDevolucao) && !empty($observacao))
     {
        if(!$p->cadastrarDevolucao($nome,$cpf,$livro,$dataDevolucao,$observacao))
        
        {
         echo "Devolução feito com suscesso";
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
		$res = $p->buscarDadosDevolucao($id_update);
	} 
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>DEVOLUCAO DE LIVROS</h2>
			<label for="nome">NOME</label>
			<input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
			<label for="cpf">CPF</label>
			<input type="text" name="cpf" id="cpf" value="<?php if(isset($res)){echo $res['cpf'];}?>">
			<label for="livro">LIVRO</label>
			<input type="text" name="livro" id="livro" value="<?php if(isset($res)){echo $res['livro'];}?>">
			<label for="dataDevolucao">DATA DEVOLUÇÃO</label>
			<input type="date" name="dataDevolucao" id="dataDevolucao" value="<?php if(isset($res)){echo $res['dataDevolucao'];}?>">
			<label for="observacao">OBSERVAÇÃO</label>
			<textarea type="text" name="observacao" id="observacao" value="<?php if(isset($res)){echo $res['observacao'];}?>"></textarea>
			
			
				
	
                
			<input type="submit" 
			value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
		</form>
	</section>
	<section id="direita">
		<input type="text" name="" id="pesquisar" placeholder="pesquisar">
		<table>
			<tr id="titulo">
				<td>NOME</td>
				<td>CPF</td>
				<td>LIVRO</td>
				<td>DATA DEVOLUCAO</td>
				<td colspan="2">OBSERVACÃO</td>
				
			   

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
              	<a href="devolucao.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
              	<a href="devolucao.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
              </td>
              <?php
              echo "</tr>";
            }
            
            
            
		   }else{
		   	echo "Ainda não há livros devolvidos";
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
  	$p->excluirDevolucao($id_livro);
  	header("location: devolucao.php");
  } 
?>

<a href="home.php" id="voltar">volta a página inicial</a>