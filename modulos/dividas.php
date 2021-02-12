<?php
use ClassesSistema\Url;
use ClassesSistema\divida;
use ClassesSistema\Cliente;

use Helpers\Common;
use Helpers\Data;

$divida = new Divida();

?>
<h1 class="mb-3">Dívidas</h1>

<a href="<?php echo URL::getBase(); ?>/clientes" class="btn btn-primary mb-3 float-right">  <i class="fa fa-arrow-circle-left"></i> Voltar</a>
<a href="#" class="btn btn-info mb-3 float-right text-white"  data-toggle="modal" data-target="#staticBackdrop">  <i class="fa fa-plus-circle"></i> Novo</a>
<?php
    $id = Url::getURL( 2 );
    $nomeCliente = Cliente::loadObject($id)->nome;
    echo "<div class='alert alert-info'>Exibindo as dívidas do cliente: ".$nomeCliente."</div>";
    if(count($divida->fetchAll($id)) != 0){
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Ações</th>
      <th scope="col">Descrição</th>
      <th scope="col">Valor</th>
      <th scope="col">Vencimento</th>
      <th scope="col">Cadastro</th>
      <th scope="col">Última Atualização</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        foreach($divida->fetchAll($id) as $divida){ 
    ?>
        <tr>
            <th>
                <button type="button" onclick="carregadivida(<?php echo $divida['id']; ?>)" class="btn btn-sm btn-primary" alt="Editar"><i class="fa fa-edit"></i></button>
                <button type="button" onclick="excluirdivida(<?php echo $divida['id']; ?>)" class="btn btn-sm btn-danger" alt="Excluir"><i class="fa fa-trash"></i></button>
            </th>
            <td><?php echo $divida['descricao'];?></td>
            <td><?php echo Common::parseMoney($divida['valor']);?></td>
            <td><?php echo Data::getFormat($divida['vencimento'], 'd/m/Y');?></td>
            <td><?php echo Data::getFormat($divida['created'], 'd/m/Y H:i');?></td>
            <td><?php if($divida['updated']!=''){echo Data::getFormat($divida['updated'], 'd/m/Y H:i'); }else{echo "-";}?></td>
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

      <form method="post" id="formdividas"  name="formdividas" onsubmit="return enviaCadastro(this);" >
            
            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="nomeproduto">Descrição:</label>
                    <input type="text" required="required" class="form-control" id="descricao" name="descricao"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="nomeproduto">Valor:</label>
                    <input type="text" required="required" class="form-control money" id="valor" name="valor"  required>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group mb-3 col-12">
                    <label for="nomeproduto">Vencimento</label>
                    <input type="text" required="required" onkeyup="maskIt(this,event,'##/##/####')" class="form-control" id="vencimento" name="vencimento"  required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group mb-3 mt-3 col-12">
                    <input type="hidden" value="0" name="id" id="id"> 
                    <input type="hidden" value="<?php echo $id; ?>" name="id_cliente" id="id_cliente">
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
                url: __PATH__+'operacoes/crudDividas.php',
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
                    //setTimeout(function(){document.location.reload(true);}, 2000);
                  }else{
                    Swal.fire(`${e.msg} `)
                      form.reset();
                      //setTimeout(function(){document.location.reload(true);}, 2000);
                  }
                },
                error: function(e)
                {
                    unblockUi();
                    msg = 'Ocorreu um erro: ';
                    console.log(e);
                    return false;
                }
            });

       } 
        return false;
    }

    function excluirdivida(id){
        Swal.fire({
            title: 'Excluir divida',
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
                                url: __PATH__+'operacoes/crudDividas.php',
                                type: "post",
                                data:{id:id, opcao:4},
                                success: (e) => {
                                    console.log(e);
                                    Swal.fire(
                                                'Excluído!',
                                                'divida removido com sucesso',
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

    function carregadivida(id){
        $('#opcao').val(3);
        $.ajax({
                type: 'post',
                url: __PATH__ + 'operacoes/crudDividas.php',  
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
                                    $('#descricao').val(e.descricao);
                                    $('#valor').val(e.valor);
                                    $('#vencimento').val(e.vencimento);
                                    $('#id_cliente').val(e.id_cliente);
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

