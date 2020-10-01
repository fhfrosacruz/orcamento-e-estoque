
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="./js/bootstrap.min.js"></script>

<!-- INICIO MODAL CLIENTE -->
<script>
$('#clienteModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_nome = button.data('nome')
  var recipient_cpf = button.data('cpf')
  var recipient_nasc = button.data('nasc')
  var recipient_email = button.data('email')
  var recipient_telefone = button.data('telefone')
  var recipient_endereco_id = button.data('endereco_id')
  var recipient_rua = button.data('rua')
  var recipient_numero = button.data('numero')
  var recipient_complemento = button.data('complemento')
  var recipient_cep = button.data('cep')
  var recipient_bairro = button.data('bairro')
  var recipient_cidade = button.data('cidade')
  var recipient_estado = button.data('estado')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar Cliente - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#nome').val(recipient_nome)
  modal.find('#cpf').val(recipient_cpf)
  modal.find('#nasc').val(recipient_nasc)
  modal.find('#email').val(recipient_email)
  modal.find('#telefone').val(recipient_telefone)
  modal.find('#endereco_id').val(recipient_endereco_id)
  modal.find('#rua').val(recipient_rua)
  modal.find('#numero').val(recipient_numero)
  modal.find('#complemento').val(recipient_complemento)
  modal.find('#cep').val(recipient_cep)
  modal.find('#bairro').val(recipient_bairro)
  modal.find('#cidade').val(recipient_cidade)
  modal.find('#estado').val(recipient_estado)
})
</script>
<!-- FIM MODAL CLIENTE -->

<!-- INICIO MODAL FUNCIONARIO -->
<script>
$('#funcionarioModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_pessoa_id = button.data('pessoa_id')
  var recipient_nome = button.data('nome')
  var recipient_cargo = button.data('cargo')
  var recipient_adm = button.data('adm')
  var recipient_saida = button.data('saida')
  var recipient_cpf = button.data('cpf')
  var recipient_nasc = button.data('nasc')
  var recipient_email = button.data('email')
  var recipient_telefone = button.data('telefone')
  var recipient_endereco_id = button.data('endereco_id')
  var recipient_rua = button.data('rua')
  var recipient_numero = button.data('numero')
  var recipient_complemento = button.data('complemento')
  var recipient_cep = button.data('cep')
  var recipient_bairro = button.data('bairro')
  var recipient_cidade = button.data('cidade')
  var recipient_estado = button.data('estado')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar Funcionario - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#pessoa_id').val(recipient_pessoa_id)
  modal.find('#nome').val(recipient_nome)
  modal.find('#cargo').val(recipient_cargo)
  modal.find('#adm').val(recipient_adm)
  modal.find('#saida').val(recipient_saida)
  modal.find('#cpf').val(recipient_cpf)
  modal.find('#nasc').val(recipient_nasc)
  modal.find('#email').val(recipient_email)
  modal.find('#telefone').val(recipient_telefone)
  modal.find('#endereco_id').val(recipient_endereco_id)
  modal.find('#rua').val(recipient_rua)
  modal.find('#numero').val(recipient_numero)
  modal.find('#complemento').val(recipient_complemento)
  modal.find('#cep').val(recipient_cep)
  modal.find('#bairro').val(recipient_bairro)
  modal.find('#cidade').val(recipient_cidade)
  modal.find('#estado').val(recipient_estado)
})
</script>
<!-- FIM MODAL FUNCIONARIO -->

<!-- INICIO MODAL EMPRESA -->
<script>
$('#empresaModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_razao_social = button.data('razao_social')
  var recipient_nome_fantasia = button.data('nome_fantasia')
  var recipient_cnpj = button.data('cnpj')
  var recipient_telefone = button.data('telefone')
  var recipient_responsavel = button.data('responsavel')
  var recipient_website = button.data('website')
  var recipient_email = button.data('email')
  var recipient_endereco_id = button.data('endereco_id')
  var recipient_rua = button.data('rua')
  var recipient_numero = button.data('numero')
  var recipient_complemento = button.data('complemento')
  var recipient_cep = button.data('cep')
  var recipient_bairro = button.data('bairro')
  var recipient_cidade = button.data('cidade')
  var recipient_estado = button.data('estado')
  var recipient_detalhes = button.data('detalhes')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar Empresa - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#razao_social').val(recipient_razao_social)
  modal.find('#nome_fantasia').val(recipient_nome_fantasia)
  modal.find('#cnpj').val(recipient_cnpj)
  modal.find('#telefone').val(recipient_telefone)
  modal.find('#responsavel').val(recipient_responsavel)
  modal.find('#website').val(recipient_website)
  modal.find('#email').val(recipient_email)
  modal.find('#endereco_id').val(recipient_endereco_id)
  modal.find('#rua').val(recipient_rua)
  modal.find('#numero').val(recipient_numero)
  modal.find('#complemento').val(recipient_complemento)
  modal.find('#cep').val(recipient_cep)
  modal.find('#bairro').val(recipient_bairro)
  modal.find('#cidade').val(recipient_cidade)
  modal.find('#estado').val(recipient_estado)
  modal.find('#detalhes').val(recipient_detalhes)
})
</script>
<!-- FIM MODAL EMPRESA -->

<!-- INICIO MODAL LOGIN -->
<script>
$('#loginModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_nome = button.data('nome')
  var recipient_cargo_log = button.data('cargo_log')
  var recipient_usuario = button.data('usuario')
  var recipient_senha = button.data('senha')
  var recipient_conf_senha = button.data('conf_senha')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Criar login')
    modal.find('#nome').val(recipient_nome)
    modal.find('#usuario').val(recipient_usuario)
    modal.find('#senha').val(recipient_senha)
    modal.find('#conf_senha').val(recipient_conf_senha)
})
</script>
<!-- FIM MODAL LOGIN -->

<!-- INICIO MODAL ADICIONA MATERIAL -->
<script>
$('#material_add_Modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_nome_mat = button.data('nome_mat')
  var recipient_tipo = button.data('tipo')
  var recipient_uni_medida = button.data('uni_medida')
  var recipient_quantidade = button.data('quantidade')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Adicionar material')
  modal.find('#nome_mat').val(recipient_nome_mat)
  modal.find('#tipo').val(recipient_tipo)
  modal.find('#uni_medida').val(recipient_uni_medida)
  modal.find('#quantidade').val(recipient_quantidade)
})
</script>
<!-- FIM MODAL ADICIONA MATERIAL -->

<!-- INICIO MODAL EDITA MATERIAL -->
<script>
$('#materialModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_nome_mat = button.data('nome_mat')
  var recipient_tipo = button.data('tipo')
  var recipient_uni_medida = button.data('uni_medida')
  var recipient_quantidade = button.data('quantidade')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar material - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#nome_mat').val(recipient_nome_mat)
  modal.find('#tipo').val(recipient_tipo)
  modal.find('#uni_medida').val(recipient_uni_medida)
  modal.find('#quantidade').val(recipient_quantidade)
})
</script>
<!-- FIM MODAL EDITA MATERIAL -->

<!-- INICIO MODAL ADICIONA COMPRA -->
<script>
$('#compra_add_Modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_material_id = button.data('material_id')
  var recipient_preco_total = button.data('preco_total')
  var recipient_quantidade = button.data('quantidade')
  var recipient_data_compra = button.data('data_compra')
  var recipient_observacao = button.data('observacao')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Adicionar material')
  modal.find('#id').val(recipient_id)
  modal.find('#material_id').val(recipient_material_id)
  modal.find('#preco_total').val(recipient_preco_total)
  modal.find('#quantidade').val(recipient_quantidade)
  modal.find('#data_compra').val(recipient_data_compra)

})
</script>
<!-- FIM MODAL ADICIONA COMPRA -->

<!-- INICIO MODAL EDITA COMPRA -->
<script>
$('#compraModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_material_id = button.data('material_id')
  var recipient_nome = button.data('nome')
  var recipient_preco_total = button.data('preco_total')
  var recipient_quantidade = button.data('quantidade')
  var recipient_data_compra = button.data('data_compra')
  var recipient_observacao = button.data('observacao')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar material - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#material_id').val(recipient_material_id)
  modal.find('#nome').val(recipient_nome)
  modal.find('#preco_total').val(recipient_preco_total)
  modal.find('#quantidade').val(recipient_quantidade)
  modal.find('#data_compra').val(recipient_data_compra)
  modal.find('#observacao').val(recipient_observacao)
})
</script>
<!-- FIM MODAL EDITA COMPRA -->

<!-- INICIO MODAL EDITA ORCAMENTO -->
<script>
$('#orcamentoModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient_id = button.data('id')
  var recipient_observacao = button.data('observacao')
  var recipient_estoque = button.data('estoque')
  var recipient_status = button.data('status')

  // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Editar Orçamento - ' + recipient_id)
  modal.find('#id').val(recipient_id)
  modal.find('#observacao').val(recipient_observacao)
  modal.find('#estoque').val(recipient_estoque)
  modal.find('#status').val(recipient_status)
})
</script>
<!-- FIM MODAL EDITA ORCAMENTO -->


<div class="container_footer">
  <hr>
  <footer>
    <p class="muted"><small>&copy; <?php echo date('Y'); ?> GESTOC Ateliê dos Estofados (Cnpj : 31.470.449/0001-47) v1.0</small></p>
  </footer>
</div>


</body>
</html>
