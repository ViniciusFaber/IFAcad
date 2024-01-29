<?php
require_once '../vendor/autoload.php';
require_once '../DAO/workDAO.php';
require_once '../DAO/academicDAO.php';
require_once '../DataBase/conexao.php';

use Google\Cloud\Storage\StorageClient;

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bnt-cadastrar'])) {

    echo 'Chegou até aqui!';
    $t_titulo = $_POST['t_titulo'];
    $t_data_def = $_POST['t_data_def']; 
    $t_palavra_c = $_POST['t_palavra_c'];
    $t_banca01 = $_POST['t_banca01'];
    $t_banca02 = $_POST['t_banca02']; 
    $t_banca03 = $_POST['t_banca03']; 
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

    // Cria uma instância do WorkModel
    $workModel = new WorkModel();

    $t_banca = $t_banca01 . ', ' .$t_banca02 . ', ' .$t_banca03;
    
    $result = $workModel->insertWork($t_titulo, $t_data_def, $t_palavra_c, $t_banca, $t_resumo, $t_citar, $t_idioma, $fileUrl, $t_tipo, $t_acad, $t_acad2, $t_prof);

    if ($result) {
        header("Location: ../View/work-list.php?sucesso");
        exit();
    } else {
        header("Location: ../View/work-list.php?erro");
        exit();
    }
    }
    //validar o arquivo do formulário
    /*if ($_FILES['t_doc']['error'] === UPLOAD_ERR_OK){
        $tmpfilepath = $_FILES['t_doc']['tmp_name'];
        $filename = $_FILES['t_doc']['name'];

        $workDAO = new WorkDAO();

        $filepath = $workDAO->fileUpload($tmpfilepath, $filename);


        }else{
            echo "Documento com erro";
        }
}*/  
    }
?>