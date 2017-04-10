 <?php session_start();
         require("bancoDados.php");
        if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
           unset($_SESSION['login']);
           unset($_SESSION['senha']);
           header('location:login.php');
    }  
        else{ $logado = $_SESSION['login'];
        if(isset($_POST[controle])){
            error_log("entrou no 1º");
        if (isset($_POST['submit'])) {
            
            error_log("entrou no 2º");
            $sEmail =($_POST['email']);
            $sTelefone = ($_POST['telefone']);
            $sEmpresa = ($_POST['empresa']);
            $sRs=($_POST['razaosocial']);
            $sEc=($_POST['ec']);
            $sName=($_POST['nome']);
            $sCpf=$_POST['cpf'];
            $sRg=$_POST['rg'];
            $sCnpj=$_POST['cnpj'];
            $rgErr = $emailErr = $cpfErr = $cnpjErr =$rsErr = $empresaErr = $emailErr = $nameErr="";
            /*Valida se o usuario digitou vazio*/
            if($sName!=""){
            if(isset($sEc)){
            if ($sEmail!="" && filter_var($sEmail, FILTER_VALIDATE_EMAIL) == true){
             if ($sTelefone!="") {
              if ($sEmpresa!=""){
                  if($sRs!=""){
                      error_log("entrou no if");
                      /*Valida RG e CPF/CNPJ vazio*/
                      if($_POST['pessoa']=="pf"){
                        if($sCpf!=""){ 
                            error_log('entrou pessoa cpf');
                             if($sRg!=""){
                                $var=bancoDados:: validaDoc($sCpf,$sRg);
                                if($var==true){
                                    $var2=bancoDados:: validaPessoa($sTelefone,$sEmail);
                                    error_log($var2);
                                    if($var2==true){
                                        /*Insere*/
                                       bancoDados::inserePessoa();
                                       header("Location: http://localhost/tela2.php");
                                    }
                                }
                            }else{
                                $rgErr="*RG Inválido";
                                }
                        }
                          else{
                               $cpfErr="*CPF Inválido";
                            }
                      }
                      else{error_log('entrou pessoa j');
                        if($sCnpj==""){
                           $cnpjErr="*CNPJ Inválido";
                      }
                        else {
                            $var2=bancoDados:: validaPessoa($sTelefone,$sEmail);
                            if($var2==true){
                            /*Insere*/
                           bancoDados::inserePessoa();
                           header("Location: http://localhost/tela2.php");
                        }
                        }
                        }
 
                }else {/*Imprimi erros*/
                $rsErr = '*Razão Social Inválida';
                
                }
                      
                }else {
                $empresaErr = '*Nome Fantasia Inválido';
                }
                }else {
                $telErr = '*Telefone Inválido';
                }
                
            } else {
                $emailErr = '*Email Inválido';
                
              }
              } else {
                   $emailErr = '*Estado Civil Inválido';
                                    
             
        }}  else{ 
                  $nameErr="*Nome Inválido";
                    }     
        }}}
        
         
    
        
       ?>
<html>
   <head>
      
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
	  <script src="jquery.maskedinput.js" type="text/javascript"></script>
	  <script type="text/javascript">

                
    function myFunction() {
	switch(	document.getElementById("pessoa").value ){
	case "pj":
            document.getElementById("pessoaj").style.display = "block";
            document.getElementById("pessoaf").style.display = "none";
	break;
	case "pf":
		document.getElementById("pessoaj").style.display = "none";
		document.getElementById("pessoaf").style.display = "block";
	break;
        default:document.getElementById("pessoaj").style.display = "none";
		document.getElementById("pessoaf").style.display = "none";
	}
    }
  
      
			
 
</script>
<style>
.error {color: #FF0000;}
</style>
   </head>
   
   <body> 
       
      <h2>Novo Cadastro de Pessoa</h2>
      
      
      
      <form method = "post" action="inserePessoa.php" name="myForm">
          <input type="hidden" value="1" name="controle">
         <table> 
             <tr>
               <td>Nome:</td>
               <td> <input type = "text" name = "nome" id="nome" value="<?php echo $sName;?>">
                  <span class = "error"><?php echo $nameErr;?></span>
               </td>
            </tr>
             <tr>
               <td>E-mail: </td>
               <td><input type = "text" name = "email" id='email' value="<?php echo $sEmail;?>">
                  <span class = "error"><?php echo $emailErr;?></span>
               </td>
            </tr>
            <?php
                  
                $conn=bancoDados::fazConexao();
         
                try{ 
                
			$num_rows="SELECT DESCRICAO, ID FROM dbo.ESTADO_CIVIL";
			$stmt=$conn->prepare($num_rows); 
			$stmt->execute();
			$arr=$stmt->fetchAll(PDO::FETCH_ASSOC);	
			echo "<tr><td>Estado Civil:</td>";
                        echo "<td><select name = 'ec'  >";
                        echo '<span class = "error"><?php echo $ecErr;?></span>';
                        for($i=0;$i<count($arr);$i++){
				$ide=$arr[$i]['ID'];
				$desc=$arr[$i]['DESCRICAO'];
				
                            echo"<option value = $ide>$desc</option>";
                        }   echo "</td></tr></select>";

                
                }
                catch(Exception $e){
                        die(print_r($e->getMessage()));   
                        }
		
		
			
            ?>
	<tr>
               <td>Telefone:</td>
               <td> <input type = "text" name = "telefone" id="telefone" value="<?php echo $sTelefone;?>" >
                  <span class = "error"><?php echo $telErr;?></span>
               </td>
            </tr>
			
			<tr>
               <td>Nome fantasia:</td>
               <td> <input type = "text" name = "empresa" id="empresa" value="<?php echo $sEmpresa;?>" >
                  <span class = "error"><?php echo $empresaErr;?></span>
               </td>
            </tr>
			<tr>
               <td>Razão Social:</td>
                <td> <input type = "text" name = "razaosocial" id="razaosocial" value="<?php echo $sRs;?>">
                  <span class = "error"><?php echo $rsErr;?></span>
               </td>
            </tr>
		<tr>
               
               <td>
                  <select name="pessoa" id="pessoa" onchange="javascript:myFunction();">
                     <option>Selecione</option>
                      <option value = "pf">Pessoa Física</option>
                     <option value = "pj">Pessoa Jurídica</option>
                  </select>
			
				
               </td>
            </tr>
			 <table id="pessoaj">
                            <tr> 
                              <td>CNPJ:</td> 
                                <td> <input type = 'text' name = 'cnpj' id='cnpj' value='cnpj' > 
                                <span class = 'error'><?php echo $cnpjErr;?></span></td>
                            </tr>
			</table>
			<table id="pessoaf">
                            <tr>
                                <td>CPF:</td> 
                                <td> <input type = 'text' name = 'cpf'  id = 'cpf' value="cpf" >
                                <span class = 'error'><?php echo $cpfErr;?></span></td>
                            </tr>
                            <tr> 
                                <td>RG:</td> <td> 
                                <input type = 'text' name = 'rg' id='rg' value="rg" > 
                                <span class = 'error'><?php echo $rgErr;?></span></td> 
                            </tr>
			<table>

			
			<tr>
               <td>
                  <input type = "submit" name = "submit" value = "Submit" > 
                  <input type=button onClick="parent.location='http://localhost/tela2.php'" value='Voltar' >
               </td>
            </tr>
         </table>
      </form>
	<script type="text/javascript">


        jQuery(function($){
           $("#cpf").mask("999.999.999.99"); 
           $("#telefone").mask("(999) 99999-9999");
           $("#rg").mask("9.999.999");
           $("#cnpj").mask("99.999.999/9999-99"); 
        });
			
   document.getElementById("pessoaj").style.display = "none";
		document.getElementById("pessoaf").style.display = "none";
</script>
   </body>
</html>
 