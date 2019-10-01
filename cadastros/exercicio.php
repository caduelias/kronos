<div class="content-wrapper">
    <form class="form-horizontal needs-validation" name="exercicio" method="POST" action="#" novalidate>
                
                <div class="card-body">



                <div class="form-group">
                        <label>Selecione o Treino:</label>
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
                




                <div class="form-group">
                        <label>Tipo:</label>
                        <select class="form-control" >
                          <option>Selecione...  </option>
                          <option>Aparelho</option>
                          <option>Funcional</option>
                          <option>option 4</option>
                          <option>option 5</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione!
                        </div>
                      </div>
                

                  <div class="form-group">
                  <input type="hidden" class="form-control" name="codigo_exercicio">
                    <label for="modalidade">Nome do Exercício:</label>
                    <input type="text" class="form-control" name="nome_exercicio" placeholder="Digite um nome" required>
                    <div class="invalid-feedback">
                            Preencha este campo!
                        </div>
                </div>


                <div class="form-group">
                        <label>Repetições:</label>
                        <select class="form-control" >
                          <option>Selecione...  </option>
                          <option>10x</option>
                          <option>20x</option>
                          <option>30x</option>
                          <option>40x</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecione!
                        </div>
                      </div>

                  


                  <div class="form-group">
                    <label for="exampleInputFile">Imagem</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Procurar</label>
                      </div>
                      
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
        
                  <!-- /.form group -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right"><i class="fas fa-folder-plus"></i> Salvar</button>
                </div>



    </form>
</div>
