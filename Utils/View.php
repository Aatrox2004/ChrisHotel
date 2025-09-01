<?php
require_once __DIR__ . '/../Config.php';

/**
 * render($viewPath, $data = [])
 * - extracts $data into view scope
 * - captures view output into $content
 * - includes the layout which will echo $content
 */
function render($viewPath, $data = []) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    extract($data, EXTR_SKIP);

    // capture view output
    ob_start();
    include $viewPath;
    $content = ob_get_clean();

    // include layout (layout expects $content)
    include __DIR__ . '/../Views/Layout.php';
}