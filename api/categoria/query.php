<?php
include_once("../../db/connection.php");

try {
  if (isset($_POST["Id"])) {
    $Id = mysqli_real_escape_string($conn, $_POST["Id"]);

    $sql = "SELECT * FROM tab_categoria WHERE id_categoria=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode($row);
  } else {
    echo "Não foi possível trazer as informações de categorias.";
  }

  // $stmt->close();
} catch (Exception $e) {
  $erro = $e->getMessage();
  echo json_encode($erro);
}

?>