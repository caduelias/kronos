<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="treino" method="POST" action="#" novalidate>
                
                <div class="card-body">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_treino">
                    <label for="modalidade">Nome do Treino:</label>
                    <input type="text" class="form-control" name="treino" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>
                
      
                    <!-- time Picker -->
                  <div class="form-group">
                    <label>Duração:</label>

                    <div class="input-group date">
                      <input type="time" class="form-control" name="duracao" placeholder="Horas:Minutos" required />
                      <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                      </div>
                    <!-- /.input group -->
                  </div>

                

                  <div class="form-group">
                  <label>Peso:</label>
                <div class="row">
              
                  <div class="col-3">
                    <input type="text" class="form-control" placeholder="20 Kg" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>   
                </div>
                </div>
                </div>

                  <div class="form-group">
                        <label>Descrição:</label>
                        <textarea class="form-control" rows="3" name="descricao" placeholder="Sobre o Treino ..." required></textarea>
                        <div class="invalid-feedback">
                            Preencha este campo!
                        </div>  
                    </div>    
                  <!-- /.form group -->

                  <div class="form-group">
                        <label>Ordem do Treino:</label>
                        <select class="form-control" >
                          <option>Selecione...  </option>
                          <option>option 2</option>
                          <option>option 3</option>
                          <option>option 4</option>
                          <option>option 5</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione!
                        </div>
                      </div>
                </div>
                
        

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>
</div>
