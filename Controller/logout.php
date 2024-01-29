<?php
session_start();
session_destroy();
header("Location: ../index.php"); // Redirecione para a página inicial após o logout
exit();
?>
