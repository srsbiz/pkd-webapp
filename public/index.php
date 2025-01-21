<?php

/*
 * This file is part of the PolishNaceCodes package.
 *
 * (c) Radosław Kowalewski <git@srsbiz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$pkd = isset($_REQUEST['pkd']) ? trim($_REQUEST['pkd']) : '';

?><!doctype html>
<html lang="pl" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="dark">
        <title>PKD 2007-2025</title>
        <link rel="icon" href="assets/favicon.ico" />
        <link type="text/css" rel="stylesheet" href="assets/main.css" />
        <script src="assets/main.js"></script>
        <link type="text/css" rel="stylesheet" crossorigin="anonymous"
              href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.classless.purple.min.css"
              integrity="sha384-wR/kNSnBPEA4Ek19aboz556DIhB1Hw7UwC0po3P7ADmUhkx4h3NOex4lWSExfB0a"
              onerror="localFallback(this, 'href', 'assets/pico.classless.purple.min.css')"
        />
        <script crossorigin="anonymous" type="text/javascript"
                src="https://unpkg.com/htmx.org@2.0.4/dist/htmx.min.js"
                integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+"
                onerror="localFallback(this, 'src', 'assets/htmx.min.js')"
        ></script>
    </head>
    <body>
        <main>
            <h1 class="text-center">Sprawdź PKD w wersjach 2007 oraz 2025</h1>
            <form method="post" hx-post="/pkd.php" hx-target="#result" hx-swap="innerHTML" hx-trigger="keyup[target.value.length > 2] delay:500ms changed">
                <fieldset role="group">
                    <input type="text" name="pkd" placeholder="00.00.X lub fragment opisu"
                           class="text-center" value="<?= htmlspecialchars($pkd); ?>" aria-label="PKD" id="pkd"
                    />
                    <button type="submit" name="action" value="submit">
                        <span class="htmx-indicator" aria-busy="true"> Sprawdzam</span>
                        <span class="htmx-reverse-indicator">Sprawdź</span>
                    </button>
                </fieldset>
            </form>
            <div id="result"><?php if ($pkd) { include __DIR__ . '/pkd.php'; } ?></div>
        </main>
        <footer>
            <noscript>
                <div class="text-center alert">
                Masz wyłączony JavaScript w przeglądarce? Nie szkodzi, strona i tak będzie działać 😎
                </div>
            </noscript>
            <div class="text-center ">
                <small>
                    Stworzone przy pomocy:
                    <a href="https://picocss.com/" target="_blank">Pico CSS</a>,
                    <a href="https://htmx.org/" target="_blank">htmx</a>
                    oraz <a href="https://packagist.org/packages/srsbiz/polish-nace-codes" target="_blank">Polish NACE codes</a>
                </small>
            </div>
        </footer>
    </body>
</html>
