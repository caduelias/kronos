<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="treino" method="POST" action="#" novalidate>
                
                <div class="card-body">
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_horario">
                </div>
                
      
            


                  <div class="form-group">
                        <label>Periodo:</label>
                        <select class="form-control" >
                          <option>Selecione...  </option>
                          <option>Manhã</option>
                          <option>Tarde</option>
                          <option>Noite</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione!
                        </div>
                      </div>
               
                
                <div class="form-group">
                    <label>Horário de Treino:</label>

                    <div class="input-group date">
                      <input type="time" class="form-control" name="duracao" placeholder="Horas:Minutos" required />
                      <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                      </div>
                    <!-- /.input group -->
                    </div>


                    <div class="form-group">
                    <label>Limite de Pessoa:</label>

                    <div class="input-group date">
                      <input type="number" class="form-control" name="duracao" placeholder="limite" required />
                      <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                      </div>
                    <!-- /.input group -->
                    </div>
                            <!-- time Picker -->
             
                            </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>
</div>
