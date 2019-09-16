<?php
    $programmaJson = file_get_contents('programma.json');
    $programma = json_decode($programmaJson);
    
    function getPresentaties($blokId, $ruimteId) {
        global $programma;
        return array_filter((array) $programma->presentaties, function ($presentatie) use ($blokId, $ruimteId) {
            return $presentatie->blok === $blokId && $presentatie->ruimte === $ruimteId;
        });
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-16">
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex">
        <link href="reset.css" rel="stylesheet">
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }
            td {
                padding: 4px;
            }
            .lunch,
            .diner,
            .opening {
                background: #eee;
            }
        </style>
    </head>
    <body style="font-family: arial; font-size: 11px">
        <table>
            <tr>
                <td>Tijd / Lokaal</td>
                <?php foreach ($programma->ruimtes as $ruimteId => $ruimte) { ?>
                    <td><?= $ruimteId ?></td>
                <?php } ?>
            </tr>
            <?php foreach ($programma->blokken as $blokId => $blok) { ?>
                <?php if ($blokId === "afsluiting") continue; ?>
                <tr>
                    <td><?= $blok->begintijd ?> - <?= $blok->eindtijd ?></td>
                    <?php foreach ($programma->ruimtes as $ruimteId => $ruimte) { ?>
                        <td class="<?= $blokId ?> <?= $ruimteId ?>"><?php
                            $presentaties = getPresentaties($blokId, $ruimteId);
                            if ($presentaties) {
                                foreach ((array) $presentaties as $presentatieId => $presentatie) { ?>
                                    <?= $presentatie->naam ?><br>
                                    <em style="font-weight: bold"><?= $presentatie->titel ?></em>
                                <?php }
                            }
                        ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>
