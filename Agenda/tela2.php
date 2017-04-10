
<html>
    
    <head>
    <?php
    session_start();
    if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
       unset($_SESSION['login']);
       unset($_SESSION['senha']);
       header('location:login.php');
       
    }  
    else{
        $logado = $_SESSION['login'];
        error_log($logado);
        require("bancoDados.php");
        /*Filtrar*/
        if(isset($_POST['ctrl'])){
            error_log("busca");
            if(isset($_POST['buscauser'])){bancoDados::buscaUser($_POST['nameu'], $_POST['login'],$_POST['idu']);
                echo "<table>";
                echo '<form action="tela2.php" method="post">';
                echo "<tr><td><input type='submit' name='mostrar'value='Mostrar Usuarios' ></td></tr>";
                echo'</form>';
                echo "</table>";
            }
            else{
                bancoDados::buscaPessoa($_POST['namep'], $_POST['idp'], $_POST['telefone'],$_POST['email']);
                echo "<table>";
                echo '<form action="tela2.php" method="post">';
                echo "<tr><td><input type='submit' value='Mostrar Pessoas' ></td></tr>";
                echo'</form>';
                echo "</table>";
            }
            } 
        /*Ativa Excluir*/
          else if(isset($_POST['exclui'])){
                if(!empty($_POST["boxpes"])){
                
                $tipo="pes";
                bancoDados::exclui($tipo,$_POST["boxpes"]); 
                
                }
            else if (!empty($_POST["boxuser"])) {
                 error_log("entrou") ;
                $tipo="us";
                 bancoDados::exclui($tipo,$_POST["boxuser"]);
                 
            }
           else{
             
            
            header("Location: http://localhost/tela2.php");
            }

       }
       
        /*Ativa Mostrar Usuario*/
        else if(isset($_POST['mostrar']) || $_GET['type']=="us"){
           $array=bancoDados::imprimiUser();
          echo '<form method="post">';
          echo'<h1>Tabela de Usuários Cadastrados</h1>';
          echo "<table border='3'><tr><th></th><th>ID</th><th>Nome</th><th>Login</th><th>Senha</th></tr>";
          for($i=0;$i<count($array); $i++){

                error_log($array[$i]['ID']);

                $id = $array[$i]['ID'];	
                $nam = $array[$i]['NOME']; 
                $log = $array[$i]['LOGIN'];
                $sen = $array[$i]['SENHA'];
                 echo "<tr><td><input type='checkbox' name='boxuser[]' id='box' value=$id></td><td><a href='http://localhost/mudancaUsuario.php?idn=$id'>$id</a></td><td>$nam</td><td>$log</td><td>$sen</td></tr>";
                 
       }

        echo "</table>";   
        echo "<input type='submit'  name='exclui' value='Excluir Dados'  >";
        echo '</form>';
        echo "<table>";
        echo '<form action="tela2.php" method="post">';
        echo "<tr><td><input type='submit' value='Mostrar Pessoas' ></tr>";
        echo "</table>";
        echo'</form>';
        echo '<table>';
        echo"<tr></td><td><input type='submit' id='busc' name='busca' value='Fazer Busca de Usuario' onclick='javascript:getSearch();'></td></tr>";
        echo '</table>';
        
        }
        /*Mostra dados de Pessoa como início*/
        else {
            echo '<form method="post">';
            echo'<h1>Tabela de Pessoas Cadastradas</h1>';
            echo "<table border='3'><tr><th></th><th>ID</th><th>Nome</th><th>Telefone</th><th>Nome fantasia</th><th>Razao Social</th><th>EMAIL</th><th>Estado Civil</th><th>CPF</th><th>RG</th><th>CNPJ</th></tr>";
            $array=bancoDados::imprimi();
             for($i=0;$i<count($array); $i++){
                error_log($array[$i]['ID']);
                $pnome=$array[$i]['NOME'];  
                $id = $array[$i]['ID'];	
                $ec=$array[$i]['DESCRICAO'];
                $empresa = $array[$i]['NOME_FANTASIA']; 
                $razao = $array[$i]['RAZAO_SOCIAL'];
                $telefone = $array[$i]['TELEFONE'];
                $email = $array[$i]['EMAIL'];
                $cpf = $array[$i]['CPF'];
                $rg = $array[$i]['RG'];
                $cnpj = $array[$i]['CNPJ'];
           echo "<tr><td><input type='checkbox' id='box' name='boxpes[]' value='$id '></td><td><a href='http://localhost/mudanca.php?idn=$id'>$id</a></td><td>$pnome</td><td>$telefone</td><td>$empresa</td><td>$razao</td><td>$email</td><td>$ec</td><td> $cpf </td><td> $rg </td><td>$cnpj</td></tr>";
          
        }  
        
        echo "</table>";
        echo "<tr><td><input type='submit'  name='exclui' value='Excluir Dados'  ></td></tr>";
        echo '</form>';
        echo "<table>";
        echo '<form action="tela2.php" method="post">';
        echo "<tr><td><input type='submit' name='mostrar'  value='Mostrar Usuarios'></td></tr>";
        echo "</table>";
        echo'</form>'; 
        echo "<table>";
        echo "<tr><td><input type='submit' name='busca' id='busc' value='Fazer Busca de Pessoa' onclick='javascript:getSearch();'></td></tr>";
        echo "</table>";
        
             }
               }
    ?> 
    </head>
    <!--Botoes de Ativação-->
    <body>
        <form action="tela2.php" method="post">
        <table>
            <tr>
                <td>
                    <input type = "button" name = "ins" onclick="parent.location='http://localhost/inserePessoa.php'" value = "Iserir novo Cadastro de pessoa" > 
                </td>
                <td>
                    <input type = "button" name = "ins" onclick="parent.location='http://localhost/insere.php'" value = "Iserir novo Cadastro de usuario" > 
                </td>
            </tr> 
        </table>
        </form>
        <table>
            <tr>
               <td>
                <input type=button onClick="parent.location='http://localhost/logout.php'" value='Logout' >	
               </td>
            </tr>   
         </table>
          <!--Tela de Filtro-->
      <form method = "post" action="tela2.php">  
      <input type="hidden" value="1" name="ctrl">
        <table id="user">
            <tr>
               <td>Filtrar por:</td>
               </tr>
                <tr> 
                  <td>Login:</td> 
                    <td> <input type = "text" name = "login">
                </tr>
                <tr> 
                  <td>Nome:</td> 
                    <td><input type = "text" name = "nameu">
                </tr>
                <tr> 
                  <td>ID:</td> 
                    <td> <input type = "text" name = "idu">
                </tr>
                <tr>
                <td>
                  <input type = "submit" name = "buscauser" value = "Buscar" > 
                </td>
                </tr>
            </table>
        
            <table id="pessoa">
               <tr>
               <td>Filtrar por:</td>
               </tr>
                <tr>
                    <td>Telefone:</td> 
                    <td> <input type = "text" name = "telefone" id="telefone">
                </tr>
                <tr> 
                    <td>Nome:</td> <td> 
                    <input type = "text" name = "namep">
                </tr>
                <tr> 
                    <td>ID:</td> <td> 
                        <input type = "text" name = "idp">
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type = "text" name = "email">
                </tr>
                <tr>
                <td>
                  <input type = "submit" name = "buscapes" value = "Buscar" > 
                </td>
                </tr>
             </table>
      </form>
       
    </body>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
	  <script src="jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript">
             document.getElementById("user").style.display = "none";
             document.getElementById("pessoa").style.display = "none";
                            
                    
        
            function getSearch(){
                switch(	document.getElementById("busc").value ){
                    case "Fazer Busca de Usuario":
                        document.getElementById("user").style.display = "block";
                        document.getElementById("pessoa").style.display = "none";
                    break;
                    case "Fazer Busca de Pessoa":
                            document.getElementById("user").style.display = "none";
                            document.getElementById("pessoa").style.display = "block";
                    break;
                    default:document.getElementById("user").style.display = "none";
                            document.getElementById("pessoa").style.display = "none";
                            break;
                    }
            }
          
         jQuery(function($){
          
           $("#telefone").mask("(999) 99999-9999");
          
        });
        </script> 
       
</html>
 