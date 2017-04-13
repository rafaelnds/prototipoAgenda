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
            
            $sEmpresa = ($_POST['empresa']);
            $sRs=($_POST['razaosocial']);
            $sEc=($_POST['ec']);
            $sName=($_POST['nome']);
            $sCpf=$_POST['cpf'];
            $sRg=$_POST['rg'];
            $sCnpj=$_POST['cnpj'];
           
           
            $rgErr = $emailErr = $cpfErr = $cnpjErr =$rsErr = $empresaErr = $emailErr = $nameErr="";
            /*Valida se o usuario digitou vazio*/
            if($_POST['pessoa']=="pf"){
            $sEmail =($_POST['emailf']);
            $sTelefone = ($_POST['telefonef']);
             error_log($sEmail);
            error_log($sTelefone);
            if($sName!=""){
                if(isset($sEc)){
                    if ($sEmail!="" && filter_var($sEmail, FILTER_VALIDATE_EMAIL) == true){
                        if ($sTelefone!="") {
                            if($sCpf!=""){ 
                                    if($sRg!=""){
                                        $var=bancoDados:: validaDoc($sCpf,$sRg,0,"insere");
                               		if($var==true){
                                             $var2=bancoDados:: validaPessoa($sTelefone,$sEmail);
                                             if($var2==true){
                                               
                                                bancoDados::inserePessoa($sTelefone,$sEmail);
                                                header("Location: http://localhost/tela2.php");
	                                    }
                             		}		
				    }else{
				        $rgErr="*RG Inválido";}
			        }else{
			            $cpfErr="*CPF Inválido";}
                                     }else {
                                $telErr = '*Telefone Inválido';
                                }
                                }else {
                                  $emailErr = '*Email Inválido';}
                                }else {
                                   $emailErr = '*Estado Civil Inválido';}
                            }else{ 
                                $nameErr="*Nome Inválido"; }  
	                  			
                            }
                            else{error_log('entrou pessoa j');
                            $sEmail =($_POST['email']);
                            $sTelefone = ($_POST['telefone']);
                            if ($sEmail!="" && filter_var($sEmail, FILTER_VALIDATE_EMAIL) == true){
                               if ($sTelefone!="") {
                                if($sEmpresa!=""){
                                  if($sRs!=""){
                                      if($sCnpj==""){
                                         $cnpjErr="*CNPJ Inválido";
                                    }
                                    else {
                                        $var2=bancoDados:: validaPessoa($sTelefone,$sEmail);
                                        if($var2==true){
                                        /*Insere*/
                                       bancoDados::inserePessoa($sTelefone,$sEmail);
                                       header("Location: http://localhost/tela2.php");
                                        }
                                    }
                                  }else {
                                    $rsErr = '*Razão Social Inválida';}
                                    }else {
                                         $empresaErr = '*Nome Fantasia Inválido'; }
                                         }else {
                                    $telErr = '*Telefone Inválido';
                                    }
                                    }else {
                                      $emailErr = '*Email Inválido';}
  
                            }         
                          
        }}}
         
          
     $tipo=$_POST["pessoa"];
         
       ?>
<html>
   <head>
       
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
  <script src="jquery.maskedinput.js" type="text/javascript"></script>
  <script type="text/javascript">

                 
    function myFunction() {
    switch( document.getElementById("pessoa").value ){
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
        break;
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
          
               <?php
                  echo "<tr><td>Tipo de Pessoa:</td>";
                        echo "<td><select name='pessoa' id='pessoa' onchange='javascript:myFunction();' >";
                           
                            
                            if($tipo=="pf"){
                                echo"<option selected value = 'pf'>Pessoa Física</option>";
                                echo"<option  value = 'pj'>Pessoa Jurídica</option>";
                            }
                            else if($tipo=="pj"){
                                echo"<option selected value = 'pj'>Pessoa Jurídica</option>";
				echo"<option  value = 'pf'>Pessoa Física</option>";
                            }
                            else{ echo"<option>Selecione</option>";
                           echo"<option  value = 'pf'>Pessoa Física</option>";
                           echo"<option  value = 'pj'>Pessoa Jurídica</option>";}
                           echo "</td></tr></select>";
                           error_log($_POST["pessoa"]);
             ?>
                 
               </td>
            </tr>
             <table id="pessoaj">
                        <tr>
               <td>E-mail: </td>
               <td><input type = "text" name = "email" id='email' value="<?php echo $sEmail;?>">
                  <span class = "error"><?php echo $emailErr;?></span>
               </td>
            </tr>
           
    <tr>
               <td>Telefone:</td>
               <td> <input type = "text" name = "telefone" id="telefonej" value="<?php echo $sTelefone;?>" >
                  <span class = "error"><?php echo $telErr;?></span>
               </td>
            </tr>
                <tr> 
                  <td>CNPJ:</td> 
                    <td> <input type = 'text' name = 'cnpj' id='cnpj' value='<?php echo $sCnpj;?>' > 
                    <span class = 'error'><?php echo $cnpjErr;?></span></td>
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
            </table>
            <table id="pessoaf">
                <tr>
               <td>Nome:</td>
               <td> <input type = "text" name = "nome" id="nome" value="<?php echo $sName;?>">
                  <span class = "error"><?php echo $nameErr;?></span>
               </td>
                </tr>
                <tr>
               <td>E-mail: </td>
               <td><input type = "text" name = "emailf" id='email' value="<?php echo $sEmail;?>">
                  <span class = "error"><?php echo $emailErr;?></span>
               </td>
            </tr>
           
            <tr>
               <td>Telefone:</td>
               <td> <input type = "text" name = "telefonef" id="telefone" value="<?php echo $sTelefone;?>" >
                  <span class = "error"><?php echo $telErr;?></span>
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
                 if($ide==$sEc){
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
                <tr>
                    <td>CPF:</td> 
                    <td> <input type = 'text' name = 'cpf'  id = 'cpf' value="<?php echo $sCpf;?>" >
                    <span class = 'error'><?php echo $cpfErr;?></span></td>
                </tr>
                <tr> 
                    <td>RG:</td> <td> 
                    <input type = 'text' name = 'rg' id='rg' value="<?php echo $sRg;?>" > 
                    <span class = 'error'><?php echo $rgErr;?></span></td> 
                </tr>
            <table>
 
             
            <tr>
               <td>
                  <input type = "submit" name = "submit" value = "Salvar" > 
                  <input type=button onClick="parent.location='http://localhost/tela2.php'" value='Voltar' >
               </td>
            </tr>
         </table>
      </form>
    <script type="text/javascript">
 
 
        jQuery(function($){
           
           $("#telefone").mask("(999) 99999-9999");
           $("#telefonej").mask("(999) 99999-9999");
           $("#rg").mask("9.999.999");
           $("#cpf").mask("999.999.999.99"); 
           $("#cnpj").mask("99.999.999/9999-99"); 
        });
             
        switch( document.getElementById("pessoa").value ){
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
        break;
    }
</script>
   </body>
</html>