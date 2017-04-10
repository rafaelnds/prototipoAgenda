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
            if($_POST['newlogin']!="" && $_POST['newsenha']!=""){
                
             $ver= bancoDados::validaUsuario($ide,$_POST['newlogin']);
               if($ver==true){/*ativa mudanÃ§a*/
                   error_log("VERIFICOU");
                   bancoDados::mudaUser($ide,$_POST['newlogin'],$_POST['newsenha']);
                    header("Location: http://localhost/tela2.php?type=us");
               }
               else {header("Location: http://localhost/mudancaUsuario.php?idn=$ide&erro=err");}
    }
            else {
                   echo "<span style='color:red'>*Espaço em branco Inválido!</span>";
                  $usuario=bancoDados::imprimiUser($ide);
                  $usuario=$usuario[0];}}
    }
             
               
      
        
               
if(isset($_GET['idn'])){
 
 $usuario=bancoDados::imprimiUser($_GET['idn']);
 $usuario=$usuario[0];
  $t="u";
$idn=$pessoa['ID'];
if(isset($_GET["erro"])){
    $sErr="*Login ja cadastrado";
}
}

 
 
 
?>
 
 
<html>
    <head>
    <style>
    .error {color: #FF0000;}
    </style>
    </head>  
    <form method = "post" action="mudancaUsuario.php" >
    <input type="hidden" value="1" name="contr">
    <input type="hidden" value="<?php echo $_GET['idn']?>"  name="idEntidade">
    <body>
             <table id="mudauser" name="mudauser" value="1">
                <tr> 
                  <td>Login:</td> 
                    <td> <input type = 'text' name = 'newlogin' value='<?php echo $usuario['LOGIN'];?>' > 
                    <span class = 'error'><?php echo $sErr;?></span></td> 
                </tr>
                <tr> 
                  <td>Senha:</td> 
                    <td> <input type = 'text' name = 'newsenha' value='<?php echo $usuario['SENHA'];?>' > 
                    </td> 
                </tr>
                 
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
   
    </form>
      
</html>
