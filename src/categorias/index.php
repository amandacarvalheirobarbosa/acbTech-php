<?php

include_once("../../db/connection.php");
include_once("../../api/categoria/query.php");
include_once("../../api/categoria/insert.php");
include_once("../../api/categoria/delete.php");

try {
  $sql = "SELECT * FROM tab_categoria";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

} catch (Exception $e) {
  $erro = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title>Categorias</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="/src/assets/css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
      <div class="container-fluid">
        <a class="navbar-brand" href=".."><img src="../assets/images/logo.png" alt="logo" width="100px"
            height="100%" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-collapse"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse d-sm-inline-flex justify-content-between">
          <ul class="navbar-nav flex-grow-1">
            <li class="nav-item">
              <a class="nav-link text-dark" href="../categorias/index.php">Categoria</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="../produtos/index.php">Produto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="container">
    <main role="main" class="pb-3">
      <div class="row">
        <div class="col-4">
          <a class="btn" onclick="AdicionarCategoria();" style="background-color: #ed233d !important; color: white;"><i
              class="fas fa-plus"></i>
            Adicionar</a>
        </div>
      </div>
      <div class="row">
        <table class="table">
          <thead>
            <tr>
              <th class="hidden-md hidden-lg"></th>
              <th class="hidden-xs hidden-sm">Id</th>
              <th class="hidden-xs hidden-sm">Nome</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              for ($i = 0; $i < $result->num_rows; $i++) {
                $row = $result->fetch_assoc();
                echo '<tr>
                        <td class="hidden-xs hidden-sm">' . $row["id_categoria"] . '</td>
                        <td class="hidden-xs hidden-sm">' . $row["nome"] . '</td>
        
                        <td>
                          <a class="btn btn-primary" title="Editar" onclick="Editar(' . $row["id_categoria"] . ')"><i class="fas fa-edit"></i></a>
                          <a class="btn btn-danger" title="Excluir" onclick="Excluir(' . $row["id_categoria"] . ')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                      </tr>';
              }
            }

            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <div id="ModalAdicionar" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; color:white; border-radius:5px 5px 0px 0px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Adicionar Categoria</h4>
        </div>
        <div class="modal-body">
          <form method='POST' id="modalform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group form-group-sm col-sm-2">
                <label class="control-label">Id</label>
                <input class="form-control" id="eId" name="eId" disabled required />
              </div>
              <div class="form-group form-group-sm col-sm-4">
                <label class="control-label">Nome</label>
                <input type="text" class="form-control" id="eNome" name="eNome" value="<?php if (isset($row["nome"]))
                  echo $row["nome"]; ?>" required />
              </div>
            </div>
            <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
              <button type="button" class="btn btn-success" onclick="AdicionarCategoria();">Salvar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="ModalExcluir" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ed233d; color:white; border-radius:5px 5px 0px 0px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Atenção</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group form-group-sm col-sm-12">
              <input name="IdExclude" id="IdExclude" style="display:none" />
              <h4>Deseja realmente excluir esta categoria?</h4>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #ed233d; border-radius:0px 0px 5px 5px;">
          <button type="button" class="btn btn-success" onclick="ExcluirCategoria();">Excluir</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="container-fluid text-center border-top footer text-muted"
    style="position: fixed; bottom: 0px !important; width: 100%; height: 30px;">
    <div class="container">
      &copy; 2023 - Amanda Carvalheiro Barbosa
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="../assets/js/script.js"></script>
</body>

</html>