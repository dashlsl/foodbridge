<?php

if (!defined('ACCESS')) {
    http_response_code(404);
    die();
}

$mainView = <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <title>{$viewInfo['title']}</title>

            <link rel="shortcut icon" type="image/png" href="$root/public/favicon.ico" />

            <link rel="stylesheet" href="$root/public/assets/css/styles.css">

HTML;

$mainView .= <<<HTML
        </head>
        <body>
HTML;

        // Render header
        $mainView .= $viewInfo['nav']['header'];

        // Render view body
        $mainView .= $viewInfo['body'];

        // Render footer
        $mainView .= $viewInfo['nav']['footer'];

        // // Include view-specific JS.
        // foreach ($viewInfo['js'] as $js) :
        //     $mainView .= <<<HTML
        //     <script src="$root/app/views/js/{$js}"></script>
        //     HTML;
        // endforeach;

echo $mainView;