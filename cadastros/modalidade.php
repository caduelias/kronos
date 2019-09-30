<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="modalidade" method="POST" action="#" novalidate>
                
                <div class="card-body">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_modalidade">
                    <label for="modalidade">Nome da Modalidade:</label>
                    <input type="text" class="form-control" name="modalidade" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>
                  <div class="form-group">
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" name="ativo" class="custom-control-input" id="customSwitch3">
                      <label class="custom-control-label" for="customSwitch3">Status Modalidade</label>
                    </div>
                  </div>

                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" placeholder="Sobre a modalidade ..." required></textarea>
                        <div class="invalid-feedback">
                            Preencha este campo!
                        </div>  
                    </div>    
      
                    <!-- time Picker -->
                  <div class="form-group">
                    <label>Horário:</label>

                    <div class="input-group date">
                      <input type="time" class="form-control" name="horario" required />
                      <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                      </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>
</div>
