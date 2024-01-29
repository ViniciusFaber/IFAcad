<?php
require_once '../vendor/autoload.php';
require_once '../DAO/workDAO.php';
require_once '../DAO/academicDAO.php';
require_once '../DataBase/conexao.php';

use Google\Cloud\Storage\StorageClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-editar'])) {

    echo 'Chegou até aqui!';
    $t_id = $_POST['t_id'];
    $t_titulo = $_POST['t_titulo'];
    $t_data_def = $_POST['t_data_def'];
    $t_palavra_c = $_POST['t_palavra_c'];
    $t_banca = $_POST['t_banca'];
    $t_resumo = $_POST['t_resumo'];
    $t_citar = $_POST['t_citar'];
    $t_idioma = $_POST['t_idioma'];
    $t_tipo = $_POST['t_tipo'];
    $t_acad = $_POST['t_acad'];
    $t_acad2 = $_POST['t_acad2'];
    $t_prof = $_POST['t_prof'];

    $bucketUrl = "https://storage.googleapis.com/ifacad-docs/";
    $bucketName = 'ifacad-docs';

    $storage = new StorageClient([
    'keyFilePath' => './keyfile.json']);

    $bucket = $storage->bucket($bucketName);

    if ($_FILES['t_doc']['error'] === UPLOAD_ERR_OK) {
    // Caminho temporário do arquivo no servidor
    $tmpFilePath = $_FILES['t_doc']['tmp_name'];

    // Nome do arquivo no Cloud Storage (usando o mesmo nome do arquivo enviado)
    $objectName = $_FILES['t_doc']['name'];

    // Faz o upload do arquivo
    $bucket = $storage->bucket($bucketName);
    $bucket->upload(
        fopen($tmpFilePath, 'r'),
        [
        'name' => $objectName
        ]
    );

    echo 'Arquivo enviado com sucesso.';

    $fileUrl = $bucketUrl . $objectName;

    $conexao = new Conexao();
    $conn = $conexao->conectar();
    $workDAO = new WorkDAO($conn);

    $success = $workDAO->updateWork($t_id, $t_titulo, $t_data_def, $t_palavra_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $fileUrl, $t_tipo, $t_acad, $t_acad2, $t_prof);

    if ($success) {
        // Redirecionar para uma página de sucesso ou fazer algo apropriado
        header("Location: ../View/work-list.php?update"); 
        exit();
    } else {
        // Exibir uma mensagem de erro
        header("Location: ../View/work-list.php?update-erro");
        exit();
    }
    }
}
?>
