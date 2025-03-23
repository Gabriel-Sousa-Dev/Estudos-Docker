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
    <title>Valide seu Certificado | FAEX</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./all.css  ">
</head>

<body>
    <div class="container bg-dark-subtle border border-secondary p-4 rounded mt-5 position-relative">
        <div class="d-flex gap-1 position-absolute end-0 top-0 m-1">
            <a class="btn btn-primary" href="./novo-aluno.php">Criar aluno</a>
            <a class="btn btn-primary" href="./novo-curso.php">Criar curso</a>
            <a class="btn btn-primary" href="./novo-certificado.php">Criar certificado</a>
        </div>
        <h1 class="text-center my-2">Login</h1>
        <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="cpf-input" class="form-label">CPF:</label>
                <input type="text" required class="form-control" id="cpf-input" name="cpf" placeholder="000.000.000-00" value="<?php echo isset($_GET['cpf']) ? htmlspecialchars($_GET['cpf']) : ''; ?>">
                <div class="invalid-feedback">
                    Digite o CPF do concluinte
                </div>
            </div>
            <div class="mb-3">
                <label for="text-input" class="form-label">Chave:</label>
                <input type="text" required class="form-control" id="text-input" name="chave" placeholder="AAAAAA-AAAAAA-AAAAAA-AAAAAA-AAAAAAA" value="<?php echo isset($_GET['chave']) ? htmlspecialchars($_GET['chave']) : ''; ?>">
                <div class="invalid-feedback">
                    Digite a chave do certificado
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-evenly my-1">
                <button class="btn btn-primary">Validar</button>
                <button class="btn btn-secondary" type="reset">Limpar</button>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['cpf']) && isset($_POST['chave'])) {
                $query = 'SELECT certificado_de_conclusao.*, aluno.*, curso.nome AS curso_nome FROM certificado_de_conclusao
                              INNER JOIN aluno ON aluno.cpf=:alunoCPF
                              INNER JOIN curso ON curso.id=certificado_de_conclusao.curso_id
                              WHERE chave=:chave';

                $stmt = $conexao->prepare($query);

                $stmt->bindParam(':alunoCPF', $_POST['cpf']);
                $stmt->bindParam(':chave', $_POST['chave']);

                $stmt->execute();

                if ($stmt->rowCount() === 1) {
                    $certificacao = $stmt->fetch(PDO::FETCH_OBJ);
                    echo "
                        <div class='row g-2 border border-black p-2 rounded mt-2'>
                            <div class='col-6'>
                                <p class='m-0 fw-bold'>Titular do Documento:</p>
                                <p class='m-0'>" . $certificacao->nome . "</p>
                            </div>
                            <div class='col-6'>
                                <p class='m-0 fw-bold'>Curso:</p>
                                <p class='m-0'>" . $certificacao->curso_nome . "</p>
                            </div>
                            <div class='col-6'>
                                <p class='m-0 fw-bold'>Data de Certificação:</p>
                                <p class='m-0'>" . (new DateTime($certificacao->data))->format('d/m/y') . "</p>
                            </div>
                            <div class='col-6'>
                                <p class='m-0 fw-bold'>Instituição Responsável:</p>
                                <p class='m-0'>" . "FAEX" . "</p>
                            </div>
                            <div class='col-12 d-flex justify-content-center'>
                                <button type='button' class='btn btn-success' id='download-certificado'>
                                    Download
                                </button>
                            </div>
                        </div>
                        ";
                } else if ($stmt->rowCount() === 0) {
                    echo "
                        <div class='alert alert-dismissible alert-danger' role='alert'>
                            Nenhum certificado encontrado com essa chave e cpf!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>  
                        ";
                } else {
                    echo "
                        <div class='alert alert-dismissible alert-danger' role='alert'>
                            Erro: foram encontrados múltilplos registros!
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
    <script>
        const downloadBtn = document.getElementById('download-certificado')

        downloadBtn.addEventListener('click', () => {
            alert('O certificado será baixado com um QR Code que redireciona para este site, trazendo os campos já preenchidos.')
        })
    </script>
</body>

</html>