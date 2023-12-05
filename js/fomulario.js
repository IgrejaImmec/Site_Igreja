$(document).ready(function () {
    function enviarDados(formData) {
        $('#mensagem-retorno').removeClass('success').addClass('error').text('Enviando...');

        console.log(formData);

        return new Promise(function (resolve, reject) {
            $.ajax({
                url: "php/contato.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    setTimeout(function () {
                        $('#mensagem-retorno').removeClass('error').addClass('success').text('Obrigado pela confiança! Responderei o mais rápido possível.');
                    }, 100);

                    $('#meuFormulario')[0].reset();

                    resolve(data);
                },
                error: function (xhr, status, error) {
                    $('#mensagem-retorno').removeClass('success').addClass('error').text('Ocorreu um erro: ' + error);
                    console.log("Erro:", error);

                    reject(error);
                }
            });
        });
    }

    $('#meuFormulario').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        enviarDados(formData)
            .then(function (data) {
                console.log("Sucesso:", data);
            })
            .catch(function (error) {
                console.log("Erro:", error);
            });
    });
});
