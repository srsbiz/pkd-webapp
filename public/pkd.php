<?php

/*
 * This file is part of the PolishNaceCodes package.
 *
 * (c) Radosław Kowalewski <git@srsbiz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use SrsBiz\PolishNaceCodes\{Pkd, Version};

if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';

$pkd = strtoupper(trim($_POST['pkd']));

$checkSubstitutes = function (&$revision1, $revision2, &$migrateContent, Version $fromVersion, Version $toVersion) use($pkd) {
    if ($revision1 && is_array($substitutes = Pkd::migrate($pkd, $fromVersion, $toVersion))) {
        $migrateContent = '<ul>';
        foreach ($substitutes as $substitute) {
            $migrateContent .= '<li><b>' . $substitute . '</b> - ' . Pkd::getDescription($substitute, $toVersion) . '</li>';
        }
        $migrateContent .= '</ul>';
        if ($revision2) {
            $revision1 = str_replace('alert-success', 'alert-warning', $revision1);
        }
    }
};

if (!preg_match('/^\d{2}\.\d{2}\.[A-Z]$/', $pkd)) {
    echo <<<EOHTML
<div class="alert alert-error">Niepoprawny format kodu PKD!</div>
EOHTML;
} else {
    $notExists = '<div class="alert alert-error text-center"><b>❌ BRAK</b></div>';
    $migrate2025 = $migrate2007 = '<div class="text-center">&ndash;</div>';

    $pkd2007 = $pkd2025 = null;
    if (Pkd::isValid($pkd, Version::Pkd2007)) {
        $pkd2007 = '<div class="alert alert-success"><b>'.$pkd.'</b> - '.Pkd::getDescription($pkd, Version::Pkd2007).'</div>';
    }

    if (Pkd::isValid($pkd, Version::Pkd2025)) {
        $pkd2025 = '<div class="alert alert-success"><b>'.$pkd.'</b> - '.Pkd::getDescription($pkd, Version::Pkd2025).'</div>';
    }

    $checkSubstitutes($pkd2007, $pkd2025, $migrate2025, Version::Pkd2007, Version::Pkd2025);
    $checkSubstitutes($pkd2025, $pkd2007, $migrate2007, Version::Pkd2025, Version::Pkd2007);

    $pkd2007 = $pkd2007 ?: $notExists;
    $pkd2025 = $pkd2025 ?: $notExists;

    echo <<<EOHTML
<table class="table-50">
    <thead>
        <tr>
            <th class="text-center">2007</th>
            <th class="text-center">2025</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{$pkd2007}</td>
            <td>{$pkd2025}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <th class="text-center">Substytuty dla PKD z 2025</th>
            <th class="text-center">Substytuty dla PKD z 2007</th>
        </tr>
        <tr>
            <td>{$migrate2007}</td>
            <td>{$migrate2025}</td>
        </tr>
    </tbody>
</table>
EOHTML;
}
