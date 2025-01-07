<?php
require_once 'vendor/autoload.php';
require_once 'app/Core/Core.php';
require_once 'lib/database/Connection.php';

require_once 'app/Controllers/HomeController.php';
require_once 'app/Controllers/ErrorController.php';
require_once 'app/Controllers/PostController.php';
require_once 'app/Model/Postagem.php';
require_once 'app/Model/Comentario.php';
$template = file_get_contents("app/Template/estrutura.html");

ob_start();
$core = new Core;
$core->start($_GET);

$saida = ob_get_contents();
ob_end_clean();

$tplPronto = str_replace('{{area_dinamica}}', $saida, $template);


echo $tplPronto;
