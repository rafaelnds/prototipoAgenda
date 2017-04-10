
<html>
   
   <head>
      <title>Login</title>
    
      
   </head>
	
   <body>
      
      <h2>Login</h2> 
   
           <form method = "post" action = "login.php" name="myForm">
           <input type="hidden" value="1" name="controle">
		   
         <table>
           
            <tr>
               <td>Login:</td>
               <td> <input type = "text" name = "log">
                  <span class = "error">
               </td>
            </tr>
             <tr>
               <td>Senha:</td>
               <td> <input type = "text" name = "password">
                  <span class = "error">
               </td>
            </tr>
       
			<table>
			
			
			<tr>
               <td>
                  <input type = "submit" name = "submit" value = "Login" > 
                  <input type=button onClick="parent.location='http://localhost/insere.php'" value='CADASTRE-SE' >
                
               </td>
            </tr>
         </table>
      </form>
      
   </body>
</html>
<?php session_start();?>
<?php
             require("bancoDados.php");   
	 if(isset($_POST["controle"])){
		$conn=bancoDados::fazConexao();
		error_log($_POST['log']);	
	
		
            try{ 
		$num_rows="SELECT ID FROM dbo.USUARIO WHERE LOGIN ='".$_POST['log']."' AND SENHA='".$_POST['password']."'";
                $stmt=$conn->prepare($num_rows); 
		$stmt->execute();
		$arr=$stmt->fetchAll(PDO::FETCH_ASSOC);	
		$id=$arr[0]["ID"];
				
		error_log($id);
				
		if($id){
                     echo 'Login accepted';
                    $logged = $_POST['log'];
                    $pass = $_POST['password'];
                    $_SESSION['login'] = $logged;
                    $_SESSION['senha'] = $pass;
                    header( "Location: http://localhost/tela2.php" );
                    
		}
		else {
                    echo "<span style='color:red'>*Login ou Senha incorretos!</span>";
                    unset ($_SESSION['login']);
                    unset ($_SESSION['senha']);
                   
		}
            }
				
			catch(Exception $e){
			die(print_r($e->getMessage()));   
			}	
		}
?>	
