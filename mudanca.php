<?php
 
session_start();
require("bancoDados.php");
    if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
       unset($_SESSION['login']);
       unset($_SESSION['senha']);
       header('location:login.php');
    }  
    else{
    if(isset($_POST['contr'])){
        $ide=$_POST["idEntidade"];
        
        if($_GET['tp']=="pf" || $_POST['tiPes']=="pf"){
            if($_POST['nome']!=""){
             if($_POST['cpf']!=""){
              if($_POST['rg']!=""){
               if($_POST['newtelf']!=""){
                if($_POST['newemailf']!=""){
                     $telfone=$_POST['newtelf'];
                     $email=$_POST['newemailf'];
                    $ver1= bancoDados::validaDoc($_POST['cpf'],$_POST['rg'],$ide,"muda");
                    if($ver1==true){
                    $ver= bancoDados::validaMudanca("pf",$ide,$_POST['newtelf'],$_POST['newemailf']);}
                }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pf';";
                    echo 'alert ("Campo Email não pode estar vazio!")';
                    echo '</script>';
                }
                }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pf';";
                    echo 'alert ("Campo Telefone não pode estar vazio!")';
                    echo '</script>';}
                    }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pf';";
                    echo 'alert ("Campo RG não pode estar vazio!")';
                    echo '</script>';}
                    }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pf';";
                    echo 'alert ("Campo CPF não pode estar vazio!")';
                    echo '</script>';}
                    }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pf';";
                    echo 'alert ("Campo Nome não pode estar vazio!")';
                    echo '</script>';}
        }
        else if($_GET['tp']=="pj"|| $_POST['tiPes']=="pj"){
             if($_POST['newtel']!=""){
                if($_POST['newemail']!=""){
                    if($_POST['razaosocial']!=""){
                        if($_POST['empresa']!=""){
                            if($_POST['newcnpj']!=""){
                                $telfone=$_POST['newtel'];
                                $email=$_POST['newemail'];
                                $ver= bancoDados::validaMudanca("pj",$ide,$_POST['newtel'],$_POST['newemail'],$_POST['razaosocial'],$_POST['empresa'],$_POST['newcnpj']);
                            }else{
                                echo '<script language="javascript">';
                                echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pj';";
                                echo 'alert ("Campo CNPJ não pode estar vazio!")';
                            echo '</script>';}
                        }else{
                            echo '<script language="javascript">';
                            echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pj';";
                            echo 'alert ("Campo Nome Fantasia não pode estar vazio!")';
                        echo '</script>';}
                    }else{
                            echo '<script language="javascript">';
                            echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pj';";
                            echo 'alert ("Campo Razão Social não pode estar vazio!")';
                            echo '</script>';}
                }else{
                            echo '<script language="javascript">';
                            echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pj';";
                            echo 'alert ("Campo Email não pode estar vazio!")';
                            echo '</script>';}
             }else{
                    echo '<script language="javascript">';
                    echo"document.location.href='http://localhost/mudanca.php?idn=$ide&&tp=pj';";
                    echo 'alert ("Campo Telefone não pode estar vazio!")';
                    echo '</script>';
                }
        }
               if($ver==true){    /*ativa mudança*/
                   
               bancoDados::mudaPessoa($ide,$_POST['razaosocial'],$_POST['empresa'],$telfone,$email,$_POST['newec'],$_POST['newcnpj'],$_POST['nome'],$_POST['cpf'],$_POST['rg']);
              header("Location: http://localhost/tela2.php");
               }
             
            }
     if(isset($_GET['idn'])){

   $pessoa=bancoDados::imprimi($_GET['idn']);
     $pessoa=$pessoa[0];
     $t="p";
     $idn=$pessoa['ID'];
     
    }
       
    
     }
    

    
?>
 
 
<html>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
      <script src="jquery.maskedinput.js" type="text/javascript"></script>
    <form method = "post" action="mudanca.php" >
        <h1>Mudança de Dados</h1>
    <input type="hidden" value="1" name="contr">
    <input type="hidden" value="<?php echo $_GET['idn']?>"  name="idEntidade">
    <input type="hidden" value="<?php echo $_GET['tp']?>"  name="tiPes">
    <body>
            
            <table id="pessoaf">
                <tr>
               <td>Nome:</td>
               <td> <input type = "text" name = "nome" id="nome" value="<?php  echo $pessoa['NOME'];?>">
                  
               </td>
                </tr>
                <tr>
                <tr>
                    <td>CPF:</td> 
                    <td> <input type = 'text' name = 'cpf'  id = 'cpf' value="<?php  echo $pessoa['CPF'];?>" >
                    </td>
                </tr>
                <tr> 
                    <td>RG:</td> <td> 
                    <input type = 'text' name = 'rg' id='rg' value="<?php  echo $pessoa['RG'];?>" > 
                    </td> 
                </tr>
                <tr>
                    <td>Telefone:</td> 
                    <td> <input type = 'text' name = 'newtelf' id ='newtel' value="<?php  echo $pessoa['TELEFONE'];?>">
                    <span class = 'error' </td>
                </tr>
               
                <tr>
                    <td>Email:</td> <td> 
                    <input type = 'text' name = 'newemailf'  value="<?php echo $pessoa['EMAIL'];?>" > 
                    <span class = 'error'</td> 
                </tr>
                 
                <?php
                
               $conn= bancoDados::fazConexao();
          
                try{ 
                 
            $num_rows="SELECT DESCRICAO, ID FROM dbo.ESTADO_CIVIL";
            $stmt=$conn->prepare($num_rows); 
            $stmt->execute();
            $arr=$stmt->fetchAll(PDO::FETCH_ASSOC);  
            echo "<tr><td>Estado Civil:</td>";
                        echo "<td><select name = 'newec' >";
                        for($i=0;$i<count($arr);$i++){
                        $ide=$arr[$i]['ID'];
                        $desc=$arr[$i]['DESCRICAO'];
                 
                            if($pessoa['DESCRICAO']==$desc){
                                echo"<option selected value = $ide>$desc</option>";
                            }
                            else{
                            echo"<option value = $ide>$desc</option>";}
                        }   echo "</td></tr></select>";
 
                 
                }
                catch(Exception $e){
                        die(print_r($e->getMessage()));   
                        }
         
            ?>
            </table>
        <table id="pessoaj">
                        <tr>
                            <td>Telefone:</td> 
                            <td> <input type = 'text' name = 'newtel' id ='newtel' value="<?php  echo $pessoa['TELEFONE'];?>">
                            <span class = 'error' </td>
                        </tr>

                        <tr>
                            <td>Email:</td> <td> 
                            <input type = 'text' name = 'newemail'  value="<?php echo $pessoa['EMAIL'];?>" > 
                            <span class = 'error'</td> 
                        </tr>
                            <tr> 
                              <td>CNPJ:</td> 
                                <td> <input type = 'text' name = 'newcnpj' id='cnpj' value='<?php echo $pessoa['CNPJ'];?>' > 
                                <span class = 'error'><?php echo $cnpjErr;?></span></td>
                            </tr>
                             <tr>
                           <td>Nome fantasia:</td>
                           <td> <input type = "text" name = "empresa" id="empresa" value="<?php echo $pessoa['NOME_FANTASIA'];?>" >
                              <span class = "error"><?php echo $empresaErr;?></span>
                           </td>
                        </tr>
                        <tr>
                           <td>Razão Social:</td>
                            <td> <input type = "text" name = "razaosocial" id="razaosocial" value="<?php echo $pessoa['RAZAO_SOCIAL'];?>">
                              <span class = "error"><?php echo $rsErr;?></span>
                           </td>
                        </tr>
        <tr>
            </table>
            <table>
            <tr>
                <td>
                  <input type = "submit" name = "submit" value = "Salvar" > 
                  <input type=button onClick="parent.location='http://localhost/tela2.php'" value='Voltar' >
                </td>
                </tr>
            </table>
    </body>
    <script>
   
        jQuery(function($){
            
           $("#newtel").mask("(999) 99999-9999");
           $("#cnpj").mask("99.999.999/9999-99"); 
            $("#rg").mask("9.999.999");
           $("#cpf").mask("999.999.999.99"); 
           
        });
 
</script>
<?php
      if($_GET['tp']=="pj"||$_POST['tiPes']=="pj"){
          error_log("epa!");
        echo'<script type="text/javascript">';
	
        echo 'document.getElementById("pessoaf").style.display = "none"';
        echo'</script>';
     }
     else{echo'<script type="text/javascript">';
	echo 'document.getElementById("pessoaj").style.display = "none"';
        
        echo'</script>';
     }
      ?>
    </form>
      
</html>