<?php
// session_start();
// require '../vendor/autoload.php';
// require '../src/routes.php';

// $router->run( $router->routes ); ?>
<?php include'../src/views/partials/header.php'; ?>
<body class="sb-nav-fixed">
    <?php include'../src/views/partials/sideBar.php'; ?>
    <?php
        // Recupera a página da URL ou define uma padrão
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'pages/home';

        // Sanitiza o caminho (evita injeções ou path traversal)
        $pagina = preg_replace('/[^a-zA-Z0-9_\/-]/', '', $pagina);

        // Define o caminho absoluto do arquivo
        $caminho = __DIR__ . '/../src/views/' . $pagina . '.php';

        // Verifica se o arquivo existe
        if (file_exists($caminho)) {
            include $caminho;
        } else {
            include __DIR__ . '/../src/views/pages/404.php';
        }
    ?>

<?php include'../src/views/partials/footer.php'; ?>
