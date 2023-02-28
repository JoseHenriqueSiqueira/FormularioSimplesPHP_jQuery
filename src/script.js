$(document).ready(function() {

    // POST
    $('#postform').submit(function(e) {
        e.preventDefault(); // previne que a página seja atualizada
        $.ajax({
            type: "POST",
            url: "form.php",
            data: $('#postform').serialize(), // serializa os dados do formulário
            success: function(result) {
                $('#result').html(result); // insere a resposta na div result
            }
        });
    });

    // GET
    $('#getform').submit(function(e) {
        e.preventDefault(); // previne que a página seja atualizada
        $.ajax({
            type: "GET",
            url: "form.php",
            data: $('#getform').serialize(), // serializa os dados do formulário
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