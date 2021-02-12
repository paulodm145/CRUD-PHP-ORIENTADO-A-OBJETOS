/** */
$('#tipopessoa').change(function(){

    if ($('#tipopessoa').val() == "JURIDICA"){
      $('#txtNome').html('Razão Social');
      $('#dtnascimento').removeClass('required');
      $('#lblCpfCnpj').html('CNPJ:');
      $('#lblnomefantasia').slideDown('slow').show();
      $('#lblnome').removeClass('col-sm-9');
      $('#lblnome').addClass('col-sm-9').slideDown('slow');
      $('#lblNascimento').hide('slow');
      var maskcnpjcpf = "maskIt(this,event,'##.###.###/####-##')";
      $('#cpfcnpj').attr("onkeyup", maskcnpjcpf);

}else if($('#tipopessoa').val() == "FISICA"){ 

      $('#txtNome').html('Nome:');
      $('#lblCpfCnpj').html('CPF:');
      $('#dtnascimento').addClass('required');
      $('#lblnomefantasia').slideDown('slow').hide();
      $('#lblnome').removeClass('col-sm-9');
      $('#lblnome').addClass('col-sm-9').slideDown('slow');
       $('#lblNascimento').show('slow');
      var maskcnpjcpf = "maskIt(this,event,'###.###.###-##')"; 
      $('#cpfcnpj').attr("onkeyup",  maskcnpjcpf);
    }

});


function selectByText(select, text) {
  $(select).find('option:contains("' + text + '")').prop('selected', true);
}
    function limpa_formulario_cep() {
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
    }

    function codigoUF(uf){
                          var estados = {
                            'AC':1,
                            'AL':2,
                            'AP':3,
                            'AM':4,
                            'BA':5,
                            'CE':6,
                            'DF':7,
                            'ES':8,
                            'GO':9,
                            'MA':10,
                            'MT':11,
                            'MS':12,
                            'MG':13,
                            'PA':14,
                            'PB':15,
                            'PR':16,
                            'PE':17,
                            'PI':18,
                            'RJ':19,
                            'RN':20,
                            'RS':21,
                            'RO':22,
                            'RR':23,
                            'SC':24,
                            'SP':25,
                            'SE':26,
                            'TO':27
                          }
      return estados[uf]; 
    }

    $("#cep").blur(function() {
    
        var cep = $(this).val().replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                $("#endereco").val("Carregando...");
                $("#bairro").val("Carregando...");
                $("#cidadecli").val("Carregando...");
                $("#ufcli").val("Carregando...");
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        /*Provocar Evento OnChange e exibir a tela adequada para pessoa Fisica ou Juridica*/
                        var uf = codigoUF(dados.uf);
                        $("#ufcli").val(uf);  
                        
                        $.ajax({
                                type: 'GET',
                                url: __PATH__+'/cidades/selecionacidade/'+codigoUF(dados.uf)+'/'+dados.localidade,  
                                timeout:5000,
                                success: function(e){
                                  $("#cidadecli").html(e);
                                },
                                error: function(e){
                                  alert('Cidade n&atilde; encontrada');
                                }
                          });
                    }
                    else {
                        limpa_formulario_cep();
                        alert("CEP n&aatilde;o encontrado.");
                    }
                });
            } 
            else {
                limpa_formulario_cep();
                alert("Formato de CEP inv&aacute;lido.");
            }
        }
        else {
            limpa_formulario_cep();
        }
    });
  


