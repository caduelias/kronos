<?php
    include "config/funcoes.php";

    $tipo = $_SESSION["admin"]["tipo"];
      
    if ($tipo == "admin"){
    
?>
<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="admin" method="POST" action="salvar/admin" novalidate>        
        <div class="card-body">
            
        <div class="row">
            <div class="col-4">
                  <div class="form-group">
                <label>Status:</label>
                    <select class="form-control" name="ativo" required>
                        <option value="">Selecione...  </option>
                        <option value="0">Inativo</option>
                        <option value="1" selected>Ativo</option>  
                    </select>
                    <div class="invalid-feedback">
                        Selecione!
                    </div>
                </div>
        </div>
    
    <div class="col-5">

        <div class="form-group">
                <label>Tipo:</label>
                    <select class="form-control" name="tipo" required>
                        <option value="">Selecione...  </option>
                        <option value="admin">Administrador</option>
                        <option value="instrutor">Instrutor</option>  
                    </select>
                    <div class="invalid-feedback">
                        Selecione!
                    </div>
            </div>
    </div>
    </div>
        

            <div class="form-group">
                    <input type="hidden" class="form-control" name="codigo_admin">
                <label for="modalidade">Nome:</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                        Preencha este campo!
                    </div>
            </div>

            <div class="form-group">
                <label for="modalidade">Senha:</label>
                    <input type="password" id="senha" class="form-control" name="senha" placeholder="Digite a senha" required>
                    <div class="invalid-feedback">
                        Preencha este campo!
                    </div>
            </div>

            <div class="form-group">
                <label for="modalidade">Confirmar Senha:</label>
                    <input type="password" id="redigite" class="form-control" name="redigite" placeholder="Redigite a senha anterior" required>
                    <div class="invalid-feedback">
                        Preencha este campo!
                    </div>
            </div>
                
           
            
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info float-right" onclick="return validarSenha()"><i class="fas fa-user-plus"></i> Salvar</button>
        </div>

    </form>
</div>
<script type="text/javascript">
    function validarSenha(){
        var senha = admin.senha.value;
        var redigite = admin.redigite.value;
    
        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                    
        })
    
            if(senha == "" || senha.length <= 7){
                Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no minimo 8 caracteres!'
                        
                    })
                admin.senha.focus();
                return false;
            }

            if(redigite== "" || redigite.length <= 7){
                    Toast.fire({
                        type: 'warning',
                        title: 'Preencha o campo da senha com no minimo 8 caracteres!'
                        
                    })
               // alert ('Preencha o campo da senha com no minimo 4 caracteres');
                admin.redigite.focus();
                return false;
            }
            
            if(senha != redigite){

                Toast.fire({
                        type: 'error',
                        title: 'Senhas digitadas não conferem, são diferentes!'
                        
                    })
               // alert (' Senhas digitadas não conferem, são diferentes!'); 
                admin.redigite.focus();
            
                return false;
            }
    } 
</script>

<?php

  } else {
        $titulo = "Erro";
        $mensagem = "O Usuário não tem permissão!";
        error($titulo, $mensagem);
  }