<?php
if (!file_exists('./conexao.php')) {
    echo "
        <div class='alert alert-dismissible alert-danger' role='alert'>
            O arquivo de conexão com o Banco de dados não foi definido corretamente!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>  
        ";
} else {
    include("./conexao.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar um novo aluno | FAEX</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./all.css  ">
</head>

<body>
    <div class="container bg-dark-subtle border border-secondary p-4 rounded mt-5 position-relative">
        <div class="d-flex gap-1 position-absolute start-0 top-0 m-1">
            <a class="btn btn-primary" href="./index.php">Voltar</a>
        </div>
        <h1 class="text-center my-2">Novo Aluno</h1>
        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nome-input" class="form-label">Nome:</label>
                <input type="text" required class="form-control" id="nome-input" name="nome">
                <div class="invalid-feedback">
                    Digite o nome do aluno
                </div>
            </div>
            <div class="mb-3">
                <label for="cpf-input" class="form-label">CPF:</label>
                <input type="text" required class="form-control" id="cpf-input" name="cpf">
                <div class="invalid-feedback">
                    Digite o CPF do aluno
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-evenly my-1">
                <button class="btn btn-primary">Criar</button>
                <button class="btn btn-secondary" type="reset">Limpar</button>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nome']) && isset($_POST['cpf'])) {
                $query = "INSERT INTO aluno (nome, cpf) VALUES (:nome, :cpf)";

                $stmt = $conexao->prepare($query);

                $stmt->bindParam(':nome', $_POST['nome']);
                $stmt->bindParam(':cpf', $_POST['cpf']);

                $stmt->execute();

                if ($stmt->rowCount() === 1) {
                    echo "
                        <div class='alert alert-dismissible alert-success' role='alert'>
                            Aluno criado com sucesso!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>  
                        ";
                } else {
                    echo "
                        <div class='alert alert-dismissible alert-danger' role='alert'>
                            Ocorreu algum erro ao criar o novo aluno!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>  
                        ";
                }
            }
            ?>
        </form>
    </div>
    <script src="./assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>