<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="modalidade" method="POST" action="#" novalidate>
                
                <div class="card-body">

                <div class="form-group float-right">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="ativo" class="custom-control-input" id="customSwitch3">
                      <label class="custom-control-label" for="customSwitch3">Status Plano</label>
                    </div>
                  </div>


                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_plano">
                    <label for="modalidade">Nome do Plano:</label>
                    <input type="text" class="form-control" name="modalidade" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>
          
                <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_plano">
                    <label for="modalidade">Taxa de adesão:</label>
                    <input type="text" class="form-control" name="modalidade" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>

                <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_plano">
                    <label for="modalidade">Valor da mensalidade:</label>
                    <input type="text" class="form-control" name="modalidade" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>

                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" placeholder="Sobre a plano..." required></textarea>
                        <div class="invalid-feedback">
                            Preencha este campo!
                        </div>  
                    </div>    
      
                
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>
</div>
