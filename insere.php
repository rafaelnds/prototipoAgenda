 <?php
   session_start();
    require("bancoDados.php");
   
       error_log("entrou");
        if(isset($_POST["control"])){
            /*Valida se o usuario digitou vazio*/
           if (isset($_POST['submit'])) {
            $sLogin =($_POST['login']);
            $sPass = ($_POST['senha']);
            $sNome = ($_POST['name']);
            $nameErr = $loginErr = $pasErr = "";
            error_log($sNome);
            if ($sNome!="") {
             if ($sLogin!="") {
              if ($sPass!=""){
                   
                  error_log("entrou aqui");
                 /*Envia pra validação de usuario existente*/
                  $v=bancoDados::validaUsuario(0,$sLogin);
                  if($v == true){
                      error_log("entou no  if v==tr");
                      /*Insere usuario*/
                      bancoDados::insereUser();
                    $logged = $sLogin;
                    $pass = $sPass;
                    if(!isset($_SESSION['login'])&& !isset($_SESSION['senha'] )){
                    $_SESSION['login'] = $logged;
                    $_SESSION['senha'] = $pass;}
                    
                  header("Location: http://localhost/tela2.php?type=us");}
              }else {/*Imprime erros*/
                 error_log("entrou aqui no else");
                $pasErr = '*Senha Inválida';
                
                }
             }else {
                $loginErr = '*Login Inválido';
              }
           }else {
                $nameErr = '*Nome Inválido';
            }
         
        
         }
        }
      
    
        ?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
 
   <body> 
       
      <h2>Novo Cadastro</h2>
      
      
      
      <form method = "post"  name="myForm" action="insere.php">
          <input type="hidden" value="1" name="control">
         <table>
            <tr>
               <td>Nome:</td>
               <td><input type = "text" name = "name" id="name" value="<?php echo $sNome;?>" >
                  <span class = "error"><?php echo $nameErr;?></span>
               </td>
            </tr>
                      
            <tr>
               <td>Login:</td>
               <td> <input type = "text" name = "login" id="login" value="<?php echo $sLogin;?>">
                  <span class = "error"><?php echo $loginErr;?></span>
               </td>
            </tr>
             <tr>
               <td>Senha:</td>
               <td> <input type = "text" name = "senha" value="<?php echo $sPass;?>">
                  <span class = "error"><?php echo $passErr;?></span>
               </td>
            </tr>
        </table>
        <table>
		<tr>
               <td>
                  <input type = "submit" name = "submit" value = "Submit" > 
                  <input type=button onClick="parent.location='http://localhost/tela2.php'" value='Voltar' >
               </td>
            </tr>
        </table>
      </form>
   
   </body>
</html>

