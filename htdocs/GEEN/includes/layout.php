<?php

function render_layout(string $title, string $content, bool $showSidebar = true): void
{
    $baseUrl = '/school_management';
    $content = trim($content);

    echo '<!DOCTYPE html>' . PHP_EOL;
    echo '<html lang="en">' . PHP_EOL;
    echo '<head>' . PHP_EOL;
    echo '    <meta charset="UTF-8">' . PHP_EOL;
    echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">' . PHP_EOL;
    echo '    <title>' . htmlspecialchars($title) . '</title>' . PHP_EOL;
    echo '    <link rel="stylesheet" href="' . htmlspecialchars($baseUrl) . '/css/style.css">' . PHP_EOL;
    echo '</head>' . PHP_EOL;
    echo '<body>' . PHP_EOL;

    if ($showSidebar) {
        include __DIR__ . '/sidebar.php';
    }

    echo '<main class="main">' . PHP_EOL;
    echo '    <div class="page-content">' . PHP_EOL;
    echo $content . PHP_EOL;
    echo '    </div>' . PHP_EOL;
    echo '</main>' . PHP_EOL;
    echo '</body>' . PHP_EOL;
    echo '</html>' . PHP_EOL;
}
