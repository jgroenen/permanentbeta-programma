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
    </head>
    <body style="font-family: arial">
        <section class="page">
            <section class="programma">
                <?php foreach ($programma->blokken as $blokId => $blok) { ?>
                    <h2 style="line-height: 2em"><?= $blok->begintijd ?> tot <?= $blok->eindtijd ?></h2>
                    <section class="blok" data-blokid="<?= $blokId ?>">
                        <?php foreach ($programma->ruimtes as $ruimteId => $ruimte) { ?>
                            <?php if (isset($_GET["ruimteId"]) && (urldecode($_GET["ruimteId"]) !== $ruimteId)) continue; ?>
                            <section class="ruimte" data-ruimteid="<?= $ruimteId ?>"><?php
                                $presentaties = getPresentaties($blokId, $ruimteId);
                                if ($presentaties) {
                                    foreach ((array) $presentaties as $presentatieId => $presentatie) { ?>
                                        <p style="line-height: 2em">
                                            <em style="display: inline-block; width: 400px; font-weight: 900"><?= $presentatie->titel ?></em>
                                            (<?= $presentatie->naam ?>, <a href="?ruimteId=<?= urlencode($presentatie->ruimte) ?>"><?= $presentatie->ruimte ?></a>)
                                        </p>
                                    <?php }
                                }
                            ?></section>
                        <?php } ?>
                    </section>
                <?php } ?>
            </section>
        </section>
    </body>
</html>
