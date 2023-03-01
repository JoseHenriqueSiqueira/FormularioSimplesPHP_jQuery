$(document).ready(function() {

    // POST
    $('#postform').submit(function(e) {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#postform').serializeArray() // serializa os dados do formulário
        dados.push({name:'form', value:'postform'})
        $.ajax({
            type: "POST",
            url: "form.php",
            data: dados, 
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
            }
        });
    });

    $('#updateform').submit(function(e) {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#updateform').serializeArray() // serializa os dados do formulário
        dados.push({name:'form', value:'updateform'})
        $.ajax({
            type: "POST",
            url: "form.php",
            data: dados, // serializa os dados do formulário
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
            }
        });
    });

    // GET
    $('#getform').submit(function(e) {
        e.preventDefault(); // previne que a página seja atualizada
        var dados = $('#getform').serializeArray() // serializa os dados do formulário
        dados.push({name:'form', value:'getform'})
        $.ajax({
            type: "GET",
            url: "form.php",
            data: dados, // serializa os dados do formulário
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
            }
        });
    });

}); 

//Aplicando máscara aos campos
$(document).ready(function() {
    $(".cpf").mask("000.000.000-00");
    $("#phone").mask("(00) 00000 - 0000");
    $("#age").mask("00")        
});