$(document).ready(function () {
    // Função para enviar os dados usando AJAX com promessas
    function enviarDados(formData) {
        $('#mensagem-retorno').removeClass('success').addClass('error').text('Enviando...');
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: "php/contato.php", // Corrija o caminho para o arquivo PHP, se necessário
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    // Exibe uma mensagem de sucesso ao usuário
                    setTimeout(function () {
                        $('#mensagem-retorno').removeClass('error').addClass('success').text('Obrigado pela confiança! Responderei o mais rápido possível.');
                    }, 100);

                    // Limpa o formulário
                    $('#meuFormulario')[0].reset();

                    resolve(data); // Resolva a promessa com os dados retornados
                },
                error: function (xhr, status, error) {
                    // Exibe uma mensagem de erro caso a requisição falhe
                    $('#mensagem-retorno').removeClass('success').addClass('error').text('Ocorreu um erro: ' + error);
                    console.log(error);

                    reject(error); // Rejeita a promessa com o erro
                }
            });
        });
    }

    // Seleciona o formulário com o ID 'meuFormulario'
    $('#meuFormulario').submit(function (e) {
        // Evita o comportamento padrão do formulário de recarregar a página
        e.preventDefault();

        // Cria um objeto FormData com os dados do formulário
        var formData = new FormData(this);

        // Enviar os dados usando a função com promessas
        enviarDados(formData)
            .then(function (data) {
                // Lidar com o sucesso, se necessário
                console.log("Sucesso:", data);
            })
            .catch(function (error) {
                // Lidar com o erro, se necessário
                console.log("Erro:", error);
            });
    });
});
