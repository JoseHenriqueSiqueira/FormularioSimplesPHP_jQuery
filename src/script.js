$(document).ready(function() {
        $('#myForm').submit(function(e) {
            e.preventDefault(); // previne que a página seja atualizada
            $.ajax({
                type: "POST",
                url: "form.php",
                data: $('#myForm').serialize(), // serializa os dados do formulário
                success: function(result) {
                    $('#result').html(result); // insere a resposta na div result
                }
            });
        });
    });