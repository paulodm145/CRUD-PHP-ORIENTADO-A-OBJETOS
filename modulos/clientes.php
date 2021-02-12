<?php
use ClassesSistema\Url;
use ClassesSistema\Cliente;
use Helpers\Common;
use Helpers\Data;
$cliente = new Cliente();
?>
<h1 class="mb-3">Clientes</h1>

<a href="<?php echo URL::getBase(); ?>" class="btn btn-primary mb-3 float-right">  <i class="fa fa-arrow-circle-left"></i> Voltar</a>
<a href="#" class="btn btn-info mb-3 float-right text-white"  data-toggle="modal" data-target="#staticBackdrop">  <i class="fa fa-plus-circle"></i> Novo</a>
<?php
    if(count($cliente->fetchAll()) != 0){
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Ações</th>
      <th scope="col">Nome</th>
      <th scope="col">Cpf/CNPJ</th>
      <th scope="col">Email</th>
      <th scope="col">Telefone</th>
      <th scope="col">Data de Cadastro</th>
      <th scope="col">Última Atualização</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        foreach($cliente->fetchAll() as $cliente){ 
    ?>
        <tr>
            <th>
                <button type="button" onclick="carregaCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm btn-primary" alt="Editar"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="excluirCliente(<?php echo $cliente['id']; ?>)" class="btn btn-sm btn-danger" alt="Excluir"><i class="fa fa-trash"></i></button>

                <a href="<?php echo URL::getBase(); ?>dividas/cliente/<?php echo $cliente['id']; ?>"  class="btn btn-sm btn-warning"><i class="fa fa-money"></i></a>

                <a href="https://wa.me/55<?php echo $cliente['telefone'];?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-whatsapp"></i></a>
            </th>
            <td><?php echo $cliente['nome'];?></td>
            <td><?php echo Common::getMaskedDocumento($cliente['cpfcnpj']);?></td>
            <td><?php echo $cliente['email'];?></td>
            <td>
                <?php 
                    $telefone = ( strlen($cliente['telefone']) == 11 ? Common::Mask($cliente['telefone'], "(##) #####-####") : Common::Mask($cliente['telefone'], "(##) ####-####"));
                    echo $telefone;
                ?>
            </td>
            <td><?php echo Data::getFormat($cliente['created'], 'd/m/Y H:i');?></td>
            <td><?php if($cliente['updated']!=''){echo Data::getFormat($cliente['updated'], 'd/m/Y H:i'); }else{echo "-";}?></td>
        </tr>
    <?php } 
        
    ?>
  </tbody>
</table>
<?php }else{ ?>
    <?php echo '<div class="alert alert-warning" role="alert">
                Não há registros para serem exibidos
                </div>'; ?>
<?php } ?>





<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Novo Cadastro</h5>
        
      </div>
      <div class="modal-body">

      <div class="msg"></div>

      <form method="post" id="formClientes"  name="formClientes" onsubmit="return enviaCadastro(this);" >
            
            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="nomeproduto">Nome:</label>
                    <input type="text" required="required" class="form-control" id="nome" name="nome"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="cpfcnpj">CPF/CNPJ:</label>
                    <input type="text" required="required"   class="form-control" id="cpfcnpj" name="cpfcnpj"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="text" required="required" onkeyup="maskIt(this,event,'##/##/####')" class="form-control date" id="data_nascimento" name="data_nascimento"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="email">E-Mail:</label>
                    <input type="text" required="required" class="form-control" id="email" name="email"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="telefone">Telefone:</label>
                    <input type="text" required="required" class="form-control phone" id="telefone" name="telefone"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="cep">Cep:</label>
                    <input type="text" required="required" onkeyup="maskIt(this,event,'#####-###')" class="form-control" onblur="getEndereco('cep','cep')" id="cep" name="cep"   required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="endereco">Endereço:</label>
                    <input type="text" required="required" class="form-control" id="endereco" name="endereco"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="numero">Número:</label>
                    <input type="text" required="required" class="form-control" id="numero" name="numero"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="bairro">Bairro:</label>
                    <input type="text" required="required" class="form-control" id="bairro" name="bairro"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="cidade">Cidade:</label>
                    <input type="text" required="required" class="form-control" id="cidade" name="cidade"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group  col-sm-12">
                <label for="estado">UF: </label>
                    <select name="estado" id="estado" class="form-control">
                        <option>SELECIONE UF</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AM">Amazonas</option>
                        <option value="AP">Amapá</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="PR">Paraná</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SE">Sergipe</option>
                        <option value="SP">São Paulo</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
            </div>
             
            <div class="form-row">
                <div class="form-group mb-3 mt-3 col-12">
                    <input type="hidden" value="0" name="id" id="id"> 
                    <input type="hidden" value="1" name="opcao" id="opcao"> 
                    <input class="btn btn-success" type="submit" value="Cadastrar" id="btnCompradores">
                    <input class="btn btn-danger" type="reset" value="Limpar Campos">
                </div>
            </div>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function enviaCadastro(form){
        if(validaForm(form, true)){
            $(form).ajaxSubmit({
                url: __PATH__+'operacoes/crudClientes.php',
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                  blockUi();
                },
                success: function(e)
                {
                  unblockUi();
                  if (e.data == 0) {
                    Swal.fire(`${e.msg} `)
                    setTimeout(function(){document.location.reload(true);}, 2000);
                  }else{
                    Swal.fire(`${e.msg} `)
                      form.reset();
                      setTimeout(function(){document.location.reload(true);}, 2000);
                  }
                },
                error: function(e)
                {
                    unblockUi();
                    msg = 'Ocorreu um erro: ';
                    setTimeout(function(){document.location.reload(true);}, 2000);
                    return false;
                }
            });

       } 
        return false;
    }

    function excluirCliente(id){
        Swal.fire({
            title: 'Excluir Cliente',
            text: "Esta ação é permanente e não poderá ser desfeita",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir'
            }).then(
                    (result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: __PATH__+'operacoes/crudClientes.php',
                                type: "post",
                                data:{id:id, opcao:4},
                                success: (e) => {
                                    console.log(e);
                                    Swal.fire(
                                                'Excluído!',
                                                'Cliente removido com sucesso',
                                                'success'
                                                )
                                    setTimeout(function(){document.location.reload(true);}, 2000);
                                }
                            });
                            /** */

                            /** */
                        }
                    }
                )
    }

    function carregaCliente(id){
        $('#opcao').val(3);
        $.ajax({
                type: 'post',
                url: __PATH__ + 'operacoes/crudClientes.php',  
                timeout:5000,
                data:{id:id, opcao:3},
                datatype:'json',
                beforeSend:()=>{
                    blockUi();
                },
                complete:()=>{
                    unblockUi();
                    $("#staticBackdrop").modal('show');
                },
                success: function(a){
                            console.log(a);
                            if(a.data == 1){     
                                    const e = a.info  
                                    $('#nome').val(e.nome);
                                    $('#cpfcnpj').val(e.cpfcnpj);
                                    $('#data_nascimento').val(e.data_nascimento);
                                    $('#telefone').val(e.telefone);
                                    $('#endereco').val(e.endereco);
                                    $('#numero').val(e.numero);
                                    $('#bairro').val(e.bairro);
                                    $('#cep').val(e.cep);
                                    $('#email').val(e.email);
                                    $('#cidade').val(e.cidade);
                                    $('#estado').val(e.estado);
                                    $('#id').val(e.id);
                                    $('#opcao').val(2);    
                            }
                        },
                error: function(e){
                        console.log(e);
                        }
                });
        
    };
</script>

