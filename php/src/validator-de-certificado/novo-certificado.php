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
    include_once("./utils/gerarChave.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar um novo Curso | FAEX</title>
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./all.css  ">
</head>

<body>
    <div class="container bg-dark-subtle border border-secondary p-4 rounded mt-5 position-relative">
        <div class="d-flex gap-1 position-absolute start-0 top-0 m-1">
            <a class="btn btn-primary" href="./index.php">Voltar</a>
        </div>
        <h1 class="text-center my-2">Novo certificado</h1>
        <form method="POST" class="needs-validation" novalidate>
            <div class="d-flex gap-2 mb-3">
                <div class="flex-grow-1">
                    <label for="aluno-input" class="form-label">Aluno:</label>
                    <select required name='aluno' class="form-select" id="aluno-input">
                        <option selected>Selecione um aluno</option>
                        <?php 
                            $queryTodosAlunos = "SELECT * FROM aluno";
                            $stmtTodosAlunos = $conexao->prepare($queryTodosAlunos);
                            $stmtTodosAlunos->execute();
                            
                            while($show = $stmtTodosAlunos->fetch(PDO::FETCH_OBJ)){
                                echo "<option value=".$show->id.">".$show->nome."</option>";
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Escolha um aluno
                    </div>
                </div>

                <div class="flex-grow-1">
                    <label for="curso-input" class="form-label">Curso:</label>
                    <select required name='curso' class="form-select" id="curso-input">
                        <option selected>Selecione um curso</option>    
                        <?php 
                            $queryTodosCursos = "SELECT * FROM curso";
                            $stmtTodosCursos = $conexao->prepare($queryTodosCursos);
                            $stmtTodosCursos->execute();
                            
                            while($show = $stmtTodosCursos->fetch(PDO::FETCH_OBJ)){
                                echo "<option value=".$show->id.">".$show->nome."</option>";
                            }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Escolha um aluno
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-evenly my-1">
                <button class="btn btn-primary">Criar</button>
                <button class="btn btn-secondary" type="reset">Limpar</button>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['curso']) && isset($_POST['aluno'])) {                
                // Gerando a chave do certificado
                do {
                    $chave = gerarChave();

                    $stmtChave = $conexao->prepare("SELECT COUNT(*) FROM certificado_de_conclusao WHERE chave = :chave");
                    $stmtChave->bindParam(':chave', $chave);

                    $stmtChave->execute();

                    $chave_existe = $stmtChave->fetchColumn();
                    
                } while($chave_existe > 0);

                $query = "INSERT INTO certificado_de_conclusao (aluno_id, curso_id, chave) VALUES (:alunoID, :cursoID, :chave)";

                $stmt = $conexao->prepare($query);

                $stmt->bindParam(':alunoID', $_POST['aluno']);
                $stmt->bindParam(':cursoID', $_POST['curso']);
                $stmt->bindParam(':chave', $chave);

                if ($stmt->execute()) {
                    $certificacao = $stmt->fetch(PDO::FETCH_OBJ);
                    echo "
                        <div class='alert alert-dismissible alert-success' role='alert'>
                            Certificado criado com sucesso! <br>
                            <strong>Chave:</strong> $chave
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>  
                        ";
                } else {
                    echo "
                        <div class='alert alert-dismissible alert-danger' role='alert'>
                            Ocorreu algum erro ao criar o novo certificado!
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