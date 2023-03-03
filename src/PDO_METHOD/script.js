//Aplicando máscara aos campos
$(document).ready(function() {
    $(".cpf").mask("000.000.000-00");
    $(".telefone").mask("(00) 00000 - 0000");
    $(".idade").mask("00");

    // POST
    $('#cadastro').submit(function(e) 
    {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#cadastro').serializeArray() // serializa os dados do formulário
        dados.push({name:'formulario', value:'cadastro'})
        $.ajax({
            type: "POST",
            url: "main.php",
            data: dados, 
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
                $('#cadastro input').each(function() {
                    $(this).val('');
                });
            }
        });
    });

    // POST
    $('#atualizar').submit(function(e) 
    {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#atualizar').serializeArray() // serializa os dados do formulário
        var cpf = $('#atualizar').find('[name="cpf"]').val();
        dados.push({name:'cpf', value:cpf},{name:'formulario', value:'atualizar'});
        $.ajax({
            type: "POST",
            url: "main.php",
            data: dados, 
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
                $('#atualizar input').each(function() {
                    $(this).val('');
                });
            }
        });
    });

    // GET
    $('#consulta').submit(function(e) 
    {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#consulta').serializeArray() // serializa os dados do formulário
        dados.push({name:'formulario', value:'consulta'})
        $.ajax({
            type: "GET",
            url: "main.php",
            data: dados, 
            success: function(result) {
                try 
                {
                    result = JSON.parse(result);
                    $("#atualizar input").each(function() {
                        var inputName = $(this).attr('name');
                        if (result[inputName] !== undefined) {
                            $(this).val(result[inputName]);
                        }
                    });
                } 
                catch (error) 
                {
                    result = "CPF OU SENHA INVÁLIDOS";
                    $('#result').html(result);
                }
                finally
                {
                    $('#consulta input').each(function() {
                        $(this).val('');
                    });
                }        
            }
        });
    });

});