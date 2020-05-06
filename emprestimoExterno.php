<?php
session_start();
if(!isset($_SESSION['id_usuario']))
{
	header("location:index.php");
	exit();
} 

?>
<?php
require_once 'classes/Emprestimo.php';
$p = new Emprestimo("sistemalogin","localhost","root",""); 
?>
<!DOCTYPE html>
<html lang="pr-br">
<head>
	<meta charset="UTF-8">
	<title></title>
	
	<link rel="stylesheet" type="text/css" href="CSS/usuario_Estilo.css">
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
		  $cpf = addslashes($_POST['cpf']);
          $nome = addslashes($_POST['nome']);
          $livro = addslashes($_POST['livro']);
          $dataEmprestimo = addslashes($_POST['dataEmprestimo']);
          $dataEmtrega = addslashes($_POST['dataEmtrega']);
          $situacao = addslashes($_POST['situacao']);
          if(!empty($cpf) && !empty($nome) && !empty($livro) && !empty($dataEmprestimo) && !empty($dataEmtrega) && !empty($situacao))
     {
        $p->atualizarDados($id_upd,$cpf,$nome,$livro,$dataEmprestimo,$dataEmtrega,$situacao);
        header("location: emprestimoExterno.php");
        
        
     }
     else
     {
        echo "preencha todos os campos!";
          }


		}
     
     
	 
         //-----------cadastrar---------
		else
		{
          $cpf = addslashes($_POST['cpf']);
          $nome = addslashes($_POST['nome']);
          $livro = addslashes($_POST['livro']);
          $dataEmprestimo = addslashes($_POST['dataEmprestimo']);
          $dataEmtrega = addslashes($_POST['dataEmtrega']);
          $situacao = addslashes($_POST['situacao']);
          if(!empty($cpf) && !empty($nome) && !empty($livro) && !empty($dataEmprestimo) && !empty($dataEmtrega) && !empty($situacao))
     {
        if(!$p->cadastrarEmprestimo($cpf,$nome,$livro,$dataEmprestimo,$dataEmtrega,$situacao))
        
        {
         echo "Emprestimo feito com suscesso";
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
		$res = $p->buscarDadosEmprestimo($id_update);
	} 
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>EMPRESTAR LIVROS</h2>
			<label for="cpf">CPF</label>
			<input type="text" name="cpf" id="cpf" value="<?php if(isset($res)){echo $res['cpf'];}?>">
			<label for="nome">NOME</label>
			<input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];}?>">
			<label for="livro">LIVRO</label>
			<input type="text" name="livro" id="livro" value="<?php if(isset($res)){echo $res['livro'];}?>">
			<label for="dataEmprestimo">DATA EMPRÉSTIMO</label>
			<input type="date" name="dataEmprestimo" id="dataEmprestimo" value="<?php if(isset($res)){echo $res['dataEmprestimo'];}?>">
			<label for="dataEmtrega">DATA EMTREGA</label>
			<input type="date" name="dataEmtrega" id="dataEmtrega" value="<?php if(isset($res)){echo $res['dataEmtrega'];}?>">
			<label for="situacao">SITUACAO:</label>
					<select type="situacao" id="selecione"> name="situacao" value="<?php if(isset($res)){echo $res['situacao'];}?>">
						<option>SELECIONE:</option>
						<option>Entregue</option>
						<option>Devolvido</option></select>     
			<input type="submit" 
			value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
		</form>
	</section>
	<section id="direita">
		<input type="text" name="" id="pesquisar" placeholder="pesquisar">
		<table>
			<tr id="titulo">
				<td>CPF</td>
				<td>NOME</td>
				<td>LIVRO</td>
				<td>DATA EMPRÉSTIMO</td>
				<td>DATA ENTREGA</td>
				<td>SITUACAO</td>
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
              	<a href="emprestimoExterno.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
              	<a href="emprestimoExterno.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
              </td>
              <?php
              echo "</tr>";
            }
            
            
            
		   }else{
		   	echo "Ainda não há livros emprestados";
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
  	$p->excluirEmprestimo($id_livro);
  	header("location: emprestimoExterno.php");
  } 
?>

<a href="home.php" id="voltar">volta a página inicial</a>