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
        error_log($ide);
            $ver= bancoDados::validaMudanca($ide,$_POST['newtel'],$_POST['newemail']);
               if($ver==true){    /*ativa mudança*/
               bancoDados::mudaPessoa($ide,$_POST[newrs],$_POST['newempresa'],$_POST['newtel'],$_POST['newemail'],$_POST['newec'],$_POST['newcnpj']);
              header("Location: http://localhost/tela2.php");
               }
                else {header("Location: http://localhost/mudanca.php?idn=$ide");}
            }
        
if(isset($_GET['idn'])){

   $pessoa=bancoDados::imprimi($_GET['idn']);
     $pessoa=$pessoa[0];
     $t="p";
     $idn=$pessoa['ID'];
    }}
?>
 
 
<html>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
      <script src="jquery.maskedinput.js" type="text/javascript"></script>
    <form method = "post" action="mudanca.php" >
    <input type="hidden" value="1" name="contr">
    <input type="hidden" value="<?php echo $_GET['idn']?>"  name="idEntidade">
    <body>
            
            <table>
                <tr>
                    <td>Telefone:</td> 
                    <td> <input type = 'text' name = 'newtel' id ='newtel' value="<?php  echo $pessoa['TELEFONE'];?>">
                    <span class = 'error' </td>
                </tr>
                <tr> 
                    <td>Nome Fantasia:</td> <td> 
                    <input type = 'text' name = 'newempresa' value="<?php echo $pessoa['NOME_FANTASIA'];?>" > 
                    <span class = 'error'</td> 
                </tr>
                <tr> 
                    <td>Razão Social:</td> <td> 
                    <input type = 'text' name = 'newrs' value="<?php echo $pessoa['RAZAO_SOCIAL'];?>" > 
                    <span class = 'error'</td> 
                </tr>
                <tr>
                    <td>Email:</td> <td> 
                    <input type = 'text' name = 'newemail'  value="<?php echo $pessoa['EMAIL'];?>" > 
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
           
        });
 
</script>
    </form>
      
</html>