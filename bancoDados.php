<?php
     class bancoDados {
         
        /*Conecta ao Banco de Dados*/
        public static function fazConexao(){
            $connect = new PDO("odbc:Driver={ODBC Driver 11 for SQL Server};Server=localhost\sqlexpress,59783;Database=CADASTRO;Uid=rafael;Pwd=rafael123");
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connect->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_SYSTEM); 
             return $connect;
         }
        /*Valida dados de Usuario*/
        function validaUsuario($uId=0,$log) {
           $conn= bancoDados::fazConexao();
         
            try{ 
		$num_rows="SELECT ID,LOGIN FROM dbo.USUARIO";
                $stmt=$conn->prepare($num_rows); 
		$stmt->execute();
		$arr=$stmt->fetchAll(PDO::FETCH_ASSOC);	
                
                for($i=0;$i<count($arr);$i++){
                    
                    $login = $arr[$i]['LOGIN'];
                    $id= $arr[$i]['ID'];
                    error_log($login);
                    error_log($log);
                   
                    if($uId!=0 ){
                     if($login==$log && $id!=$uId){
                        error_log("entrou com id != 0");
                        $ver2 = "2";}}
                     else{
                       if($login==$log){error_log("entrou id=0");
                        $ver2 = "2";}}
                        }
                     
                     if($ver2=="2"){
                         error_log("entrou ver=2");
                        
                        echo '<script language="javascript">';
                        echo 'alert("*Login ja cadastrado")';
                        echo '</script>';
                        $var=false;
                    }
                    else{$var=true;
                    }
                
            }
            catch(Exception $e){
            die(print_r($e->getMessage()));   
            }return $var;
          }
          /*Valida RG/CPF */
        function validaDoc($vCpf,$vRg){
              $conn= bancoDados::fazConexao();
             error_log('executou');
            try{ 
                $num_rows3 ="SELECT RG,CPF FROM dbo.PESSOA_FISICA";
                $stmt3 = $conn->prepare($num_rows3); 
                $stmt3->execute(); 
                $arr3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                error_log($vTipo);
               
                for($i=0;$i<count($arr3);$i++){
                    $cpf = $arr3[$i]['CPF'];
                    $rg = $arr3[$i]['RG'];
                    error_log($cpf);
                    error_log($rg);
                   if($cpf==$vCpf){$ver7 = "7";}
                   else if($rg==$vRg){$ver6 = "6";}
                   }
                   if($ver7){
                        echo '<script language="javascript">';
                        echo 'alert("*CPF ja cadastrado")';
                        echo '</script>';
                        }
                    else if($ver6){
                        echo '<script language="javascript">';
                        echo 'alert("*RG ja cadastrado")';
                        echo '</script>';}
                     if($ver7||$ver6){
                        $var=false;
                    }else{
                        error_log("entrou nesse else");
                        $var=true;}
            
          }catch(Exception $e){
                die( print_r( $e->getMessage() ) );   
            }
            return $var;
        }
          /*Valida dados de Pessoa*/
        function validaPessoa($vTel,$vEmail){
            $conn= bancoDados::fazConexao();
             error_log('executou');
            try{ 
                $num_rows2 ="SELECT TELEFONE,EMAIL FROM dbo.PESSOA";
                $stmt2 = $conn->prepare($num_rows2); 
                $stmt2->execute(); 
                $arr2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); 
                
                for($i=0;$i<count($arr2);$i++){
                    $telefone = $arr2[$i]['TELEFONE'];
                    $email = $arr2[$i]['EMAIL'];                  
                    error_log($telefone);
                    error_log($vTel);
                    error_log($email);
                    error_log($vEmail);
                    if($telefone==$vTel){
                        $ver3 = "3";
                    }
                    else if($email==$vEmail){
                        $ver4 = "4";
                    }
                   
                       }
                    
                    if($ver3=="3"){
                        error_log("entrou ver=3");
                       
                        echo '<script language="javascript">';
                        echo 'alert("*Telefone ja cadastrado")';
                        echo '</script>';
                        $var=false;
                    }
                    else if($ver4=="4"){
                        error_log("entrou ver=4");
                        echo '<script language="javascript">';
                        echo 'alert("*Email ja cadastrado")';
                        echo '</script>';
                        $var=false;
                    }
                    
                    else{
                        error_log("entrou nesse else");
                        $var=true;}		
            }
            catch(Exception $e){
            die(print_r($e->getMessage()));   
            }
             error_log($var);
            return $var; 
          }
          /*Insere dados de Usuario*/
        function insereUser(){ 
             $conn= bancoDados::fazConexao();
            try{ 
                    $num_rows = "SELECT ISNULL(MAX(ID),0)+1 AS PROXID FROM USUARIO";
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                    $cadastro=$insert->fetchAll(PDO::FETCH_ASSOC);
                    $id=$cadastro[0]["PROXID"];
                    $tsql2 = "INSERT INTO dbo.USUARIO(ID,NOME,   
                       LOGIN,SENHA)   
                    VALUES (?,?,?,?)";  
                    $params2 = array($id, 
                    $_POST['name'],$_POST['login'],$_POST['senha']);  
                    $insertCadastro2=$conn->prepare($tsql2);  
                    $insertCadastro2->execute($params2);
            }
            catch(Exception $e){
                die( print_r( $e->getMessage() ) );   
            }
        }
        /*Insere dados de Pessoa*/    
        function inserePessoa(){
             $conn= bancoDados::fazConexao();
            try{ 
                    $num_rows = "SELECT ISNULL(MAX(ID),0)+1 AS PROXID FROM PESSOA";
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                    $cadastro=$insert->fetchAll(PDO::FETCH_ASSOC);
                    $id=$cadastro[0]["PROXID"];

                    $tsql = "INSERT INTO dbo.PESSOA(ID,NOME,RAZAO_SOCIAL,   
                      NOME_FANTASIA, TELEFONE,EMAIL,ID_ESTADO_CIVIL) 
                    VALUES (?,?,?,?,?,?,?)";  
                    $params = array($id,$_POST['nome'], 
                    $_POST['razaosocial'],     /*ESTADO CIVIL AQUI*/
                    $_POST['empresa'],$_POST['telefone'],$_POST['email'],$_POST['ec']);  
                    $insertCadastro=$conn->prepare($tsql);  
                    $insertCadastro->execute($params);
                if($_POST['cpf']=="" || $_POST['rg']==""){
                    $cpf=NULL;
                    $rg=NULL;
                }
                else{$cpf=$_POST['cpf'];
                    $rg=$_POST['rg'];
                }
                    $tsql3 = "INSERT INTO dbo.PESSOA_FISICA(ID,RG,   
                      CPF)   
                    VALUES (?,?,?)";  
                    $params3 = array($id,
                    $rg,    
                    $cpf);  
                    $insertCadastro3=$conn->prepare($tsql3);  
                $insertCadastro3->execute($params3);
                if($_POST['cnpj']==""){
                    $cnpj=NULL;
                }
                else{$cnpj=$_POST['cnpj'];}
                    $tsql4 = "INSERT INTO dbo.PESSOA_JURIDICA(ID,CNPJ)   
                    VALUES (?,?)";  
                    $params4 =  array ($id,$cnpj);
                    $insertCadastro4=$conn->prepare($tsql4);  
                    $insertCadastro4->execute($params4);
                    $tsql6 = "INSERT INTO dbo.TELEFONE(ID,TELEFONE)   
                    VALUES (?,?)";  
                    $params6 = array($id, 
                    $_POST['telefone']);  
                    $insertCadastro6=$conn->prepare($tsql6);  
                    $insertCadastro6->execute($params6);
            }
            catch(Exception $e){
                die( print_r( $e->getMessage() ) );   
            }
           
        }
        /*Faz Mudança de dados de Pessoa*/
        function mudaPessoa($idn,$newrs,$newempresa,$newtelefone,$newemail,$ec,$newcnpj=0) {
             $conn= bancoDados::fazConexao();
             error_log('veio no muda');
            try{ 
                if($newrs){
                    $num_rows ="UPDATE dbo.PESSOA SET RAZAO_SOCIAL='".$newrs."' WHERE ID=".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();}
                if($newempresa){
                    $num_rows ="UPDATE dbo.PESSOA SET NOME_FANTASIA='".$newempresa."' WHERE ID=".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();  
                }
                if($newtelefone){
                    $num_rows ="UPDATE dbo.PESSOA SET TELEFONE='".$newtelefone."' WHERE ID=".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                    $num_rows2 ="UPDATE dbo.TELEFONE SET TELEFONE='".$_POST['newtelefone']."' WHERE ID =".$idn;
                    $insert2=$conn->prepare($num_rows2);  
                    $insert2->execute();
                }
                if($newemail){
                    $num_rows ="UPDATE dbo.PESSOA SET EMAIL='".$newemail."' WHERE ID=".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                }
                if($ec){
                    $num_rows ="UPDATE dbo.PESSOA SET ID_ESTADO_CIVIL='".$ec."' WHERE ID=".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                }
                
                if($newcnpj){
                    $num_rows ="UPDATE dbo.PESSOA_JURIDICA SET CNPJ='".$newcnpj."' WHERE ID =".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                }
            } 
            catch(Exception $e)  
                    {die( print_r( $e->getMessage() ) );   
            }
          
            
           }
         /*Faz Mudança de dados de Usuario*/
        function mudaUser($idn,$newl,$news){
               $conn= bancoDados::fazConexao();
              try{
                  error_log($idn);
               if(isset($newl)){
                   error_log('entrou login');
                    $num_rows ="UPDATE dbo.USUARIO SET LOGIN='".$newl."' WHERE ID =".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
                    
                }
                if(isset($news)){
                    error_log('entrou senha');
                    $num_rows ="UPDATE dbo.USUARIO SET SENHA='".$news."' WHERE ID =".$idn;
                    $insert=$conn->prepare($num_rows);  
                    $insert->execute();
              }}
            catch (Exception $e)  
                   {die( print_r( $e->getMessage() ) );  
                     }
                echo '<script language="javascript">';
                echo 'alert ("Mudança feita com sucesso!")';
                echo ' <input type="button" value="OK" onclick="parent.location="http://localhost/tela.php?type=u""/>';
                echo '</script>'; 
                }
       /*Imprimi dados de Pessoa*/
        public static function imprimi($id=0) {
            
            $conn= bancoDados::fazConexao();
           
            try {
            $num_rows="SELECT P.ID,P.RAZAO_SOCIAL, P.NOME_FANTASIA,P.TELEFONE,P.EMAIL,P.NOME,P.ID_ESTADO_CIVIL,EC.DESCRICAO,PF.RG,PF.CPF,PJ.CNPJ FROM PESSOA P LEFT JOIN ESTADO_CIVIL EC ON P.ID_ESTADO_CIVIL = EC.ID LEFT JOIN  PESSOA_FISICA PF ON P.ID=PF.ID LEFT JOIN PESSOA_JURIDICA PJ ON P.ID=PJ.ID".($id ? " WHERE P.ID=".$id :"");
            $stmt=$conn->prepare($num_rows); 
            $stmt->execute();
            $arr=$stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(Exception $e)  
                    {die( print_r( $e->getMessage() ) );   
            }
           return $arr;
        }
        /*Imprimi dados de Usuario*/
        public static function imprimiUser($id=0) {
            $conn= bancoDados::fazConexao();
            try {
            $num_rows="SELECT ID,NOME,LOGIN,SENHA FROM dbo.USUARIO".($id ? " WHERE ID=".$id :"");
            $stmt=$conn->prepare($num_rows); 
            $stmt->execute();
            $arr=$stmt->fetchAll(PDO::FETCH_ASSOC);
            }catch(Exception $e)  
                    {die( print_r( $e->getMessage() ) );   
            }
           return $arr;
        }
        /*Exclui dados*/
        function exclui($t,$vetor)/*ALERT*/{
            $conn= bancoDados::fazConexao();
            try {
                if($t=="pes"){
                for($i=0;$i<count($vetor);$i++){  
                $id=$vetor[$i];
                $num_rows = "DELETE FROM PESSOA WHERE ID =".$id;
                $del=$conn->prepare($num_rows);  
                $del->execute();
                

                $num_rows2 = "DELETE FROM PESSOA_FISICA WHERE ID =".$id;
                $del=$conn->prepare($num_rows2);  
                $del->execute();
                

                $num_rows3 = "DELETE FROM PESSOA_JURIDICA WHERE ID =".$id;
                $del=$conn->prepare($num_rows3);  
                $del->execute();
                
                $num_rows5 = "DELETE FROM TELEFONE WHERE ID =".$id;
                $del=$conn->prepare($num_rows4);  
                $del->execute();
                }
                echo '<script language="javascript">';
                echo 'alert ("Remoção feita com sucesso!")';
                echo '</script>'; 
                }
                else{
                error_log("entrou US");
                for($i=0;$i<count($vetor);$i++){  
                $id=$vetor[$i];
                $num_rows4 = "DELETE FROM USUARIO WHERE ID =".$id;
                $del=$conn->prepare($num_rows4);  
                $del->execute();
                $t="us";
                }
                }
                header("Location: http://localhost/tela2.php?type=$t");
            } catch (Exception $e){
                   die( print_r( $e->getMessage() ) );   
                }
           
        }
        /*Filtro de pessoa*/
        function buscaPessoa( $varnomep=0, $varid=0, $vartel=0,$varemail=0) {
               $conn= bancoDados::fazConexao();
               echo "<table><tr><th></th><th>ID</th><th>Nome</th><th>Telefone</th><th>Nome fantasia</th><th>Razao Social</th><th>EMAIL</th><th>Estado Civil</th><th>CPF</th><th>RG</th><th>CNPJ</th></tr>";
                try{
                  
                if($varid){
                   $busca= bancoDados::imprimi($varid);
                    $id=$varid;
                    $nome = $busca[0]['NOME'];
                    $ec=$busca[0]['DESCRICAO'];
                    $telefone = $busca[0]['TELEFONE'];
                    $empresa = $busca[0]['NOME_FANTASIA'];
                    $razao = $busca[0]['RAZAO_SOCIAL'];
                    $email = $busca[0]['EMAIL'];
                    $cpf = $busca[0]['CPF'];
                    $rg = $busca[0]['RG'];
                    $cnpj = $busca[0]['CNPJ'];
                     echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td>$telefone</td><td>$empresa</td><td>$razao</td><td>$email</td><td>$ec</td><td> $cpf </td><td> $rg </td><td>$cnpj</td></tr>";
                }
               
                else if($vartel){
                    
                    $num_rows ="SELECT ID FROM dbo.PESSOA WHERE TELEFONE='".$vartel."'";
                    $stmt = $conn->prepare($num_rows); 
                    $stmt->execute(); 
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $id = $arr[0]['ID'];
                    $busca= bancoDados::imprimi($id);
                    $nome = $busca[0]['NOME'];
                    $ec=$busca[0]['DESCRICAO'];
                    $telefone = $vartel;
                    $empresa = $busca[0]['NOME_FANTASIA'];
                    $razao = $busca[0]['RAZAO_SOCIAL'];
                    $email = $busca[0]['EMAIL'];
                    $cpf = $busca[0]['CPF'];
                    $rg = $busca[0]['RG'];
                    $cnpj = $busca[0]['CNPJ'];
                     echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td>$telefone</td><td>$empresa</td><td>$razao</td><td>$email</td><td>$ec</td><td> $cpf </td><td> $rg </td><td>$cnpj</td></tr>";
                }
                else if($varemail){
                    $num_rows ="SELECT ID FROM dbo.PESSOA WHERE EMAIL='".$varemail."'";
                    $stmt = $conn->prepare($num_rows); 
                    $stmt->execute(); 
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $id = $arr[0]['ID'];
                    $busca= bancoDados::imprimi($id);
                    $nome = $busca[0]['NOME'];
                    $ec=$busca[0]['DESCRICAO'];
                    $telefone = $busca[0]['TELEFONE'];
                    $empresa = $busca[0]['NOME_FANTASIA'];
                    $razao = $busca[0]['RAZAO_SOCIAL'];
                    $email = $varemail;
                    $cpf = $busca[0]['CPF'];
                    $rg = $busca[0]['RG'];
                    $cnpj = $busca[0]['CNPJ'];
                     echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td>$telefone</td><td>$empresa</td><td>$razao</td><td>$email</td><td>$ec</td><td> $cpf </td><td> $rg </td><td>$cnpj</td></tr>";
                }
                else{
                    $num_rows ="SELECT ID FROM dbo.PESSOA WHERE NOME='".$varnomep."'";
                    $stmt = $conn->prepare($num_rows); 
                    $stmt->execute(); 
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $id = $arr[0]['ID'];
                    $busca= bancoDados::imprimi($id);
                    for($i=0;$i<count($arr);$i++){
                    $nome =$varnomep;
                    $ec=$busca[$i]['DESCRICAO'];
                    $telefone = $busca[$i]['TELEFONE'];
                    $empresa = $busca[$i]['NOME_FANTASIA'];
                    $razao = $busca[$i]['RAZAO_SOCIAL'];
                    $email =  $busca[$i]['EMAIL'];
                    $cpf = $busca[$i]['CPF'];
                    $rg = $busca[$i]['RG'];
                    $cnpj = $busca[$i]['CNPJ'];
                     echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td>$telefone</td><td>$empresa</td><td>$razao</td><td>$email</td><td>$ec</td><td> $cpf </td><td> $rg </td><td>$cnpj</td></tr>";
                }}
                echo '</table>';
            }
               catch(Exception $e){
                   die( print_r( $e->getMessage() ) );   
                }
                
             }
        /*Filtro de usuarios*/
        function buscaUser($nomeuser=0,$log=0,$idu=0){
                 $conn= bancoDados::fazConexao();
                  echo "<table><tr><th></th><th>ID</th><th>Nome</th><th>Login</th><th>Senha</th></tr>";  
                   
                 try{
                    
                    if($nomeuser){
                    $num_rows ="SELECT ID,LOGIN,SENHA FROM dbo.USUARIO WHERE NOME='".$nomeuser."'";
                    $stmt = $conn->prepare($num_rows); 
                    $stmt->execute(); 
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     for($i=0;$i<count($arr);$i++){
                    $senha = $arr[$i]['SENHA'];
                    $nome = $nomeuser;
                    $id = $arr[$i]['ID'];
                    $login = $arr[$i]['LOGIN'];
                    echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td> $login </td><td>$senha</td></tr>";
                     }
                } else if($log){
                    $num_rows ="SELECT NOME,ID,SENHA FROM dbo.USUARIO WHERE LOGIN='".$log."'";
                    $stmt = $conn->prepare($num_rows); 
                    $stmt->execute(); 
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $login = $log;
                    $id = $arr[0]['ID'];
                    $nome = $arr[0]['NOME'];
                    $senha = $arr[0]['SENHA'];
                    echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td> $login </td><td>$senha</td></tr>";
                }
                else {
                    $arr=  bancoDados::imprimiUser($idu);
                    $id =$idu;
                    $nome = $arr[0]['NOME'];
                    $login = $arr[0]['LOGIN'];
                    $senha = $arr[0]['SENHA'];
                    echo "<tr><td><input type='checkbox' id='boxpes' name='boxpes'onclick='getVcheck' value=$id></td><td><a href='http://localhost/mudanca.php?idn=$id&tipo=p'>$id</a></td><td>$nome</td><td> $login </td><td>$senha</td></tr>";
                }
             } catch(Exception $e){
                   die( print_r( $e->getMessage() ) );   
                }
                echo "</table>";  
            }

             /*Faz Validacao de Pessoa na Mudanca*/
        function validaMudanca($vId,$vTel,$vEmail){
            $conn= bancoDados::fazConexao();
            try{ 
                $num_rows2 ="SELECT TELEFONE,EMAIL,ID FROM dbo.PESSOA";
                $stmt2 = $conn->prepare($num_rows2); 
                $stmt2->execute(); 
                $arr2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); 

                for($i=0;$i<count($arr2);$i++){
                    $telefone = $arr2[$i]['TELEFONE'];
                    $email = $arr2[$i]['EMAIL'];                  
                    $id= $arr2[$i]['ID'];
                    error_log($telefone);
                    error_log($vTel);
                    error_log($email);
                    error_log($vEmail);
                    error_log($id);
                    error_log($vId);
                    if($telefone==$vTel && $vId != $id){
                        $ver3 = "3";
                    }
                    else if($email==$vEmail && $vId != $id){
                        $ver4 = "4";
                    }
                    
                    
                       }
                       if($ver3){
                         echo '<script language="javascript">';
                         echo 'alert("*Telefone ja cadastrado")';
                         echo '</script>'; 
                         
                         }
                    else if($ver4){
                         echo '<script language="javascript">';
                         echo 'alert("*Email ja cadastrado")';
                         echo '</script>';
                         
                         }
                   
                    if($ver3||$ver4){
                        $var=false;
                    }else{
                       
                        $var=true;}		
            }
            catch(Exception $e){
            die(print_r($e->getMessage()));   
            }
            error_log($var);
            return $var; 
          }
          
     }       
?>
 