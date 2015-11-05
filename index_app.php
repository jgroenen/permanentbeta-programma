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
        <!--<meta name='viewport' content='width=320,initial-scale=1,user-scalable=0'>-->
        <meta name="mobile-web-app-capable" content="yes">
        <meta name='viewport' content='minimal-ui,width=320,initial-scale=1,user-scalable=0'>
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex">
        <link rel='image_src' href='pb.png'/>
        <link rel='shortcut icon' type='image/png' href='pb.png'>
        <link href="reset.css" rel="stylesheet">
        <script src="jquery-2.1.4.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style_app.css">
    </head>
    <body>
        <section class="details"></section>
        <section class="page">
            <h2>Permanent Beta</h2>
            <h1>Programma 13&nbsp;november&nbsp;2015</h1>
            <p>Het Lyceum Rotterdam</p>
            <p><a href="http://www.permanentbeta.nl/events/pb-dag/">meer informatie</a></p>
            <p style="margin-top: 15px">Klik op <span style="color: #711; font-size: 2em">&#9829;</span> om je voorkeur aan te geven.</p>
            <section class="programma">
                <?php foreach ($programma->blokken as $blokId => $blok) { ?>
                    <h2><?= $blok->begintijd ?> tot <?= $blok->eindtijd ?></h2>
                    <section class="blok" data-blokid="<?= $blokId ?>">
                        <?php foreach ($programma->ruimtes as $ruimteId => $ruimte) { ?>
                            <section class="ruimte" data-ruimteid="<?= $ruimteId ?>"><?php
                                $presentaties = getPresentaties($blokId, $ruimteId);
                                if ($presentaties) {
                                    foreach ((array) $presentaties as $presentatieId => $presentatie) { ?>
                                        <!--http://www.html5rocks.com/en/tutorials/dnd/basics/-->
                                        <section class="presentatie <?= $presentatie->thema ?>" data-presentatieId="<?= $presentatieId ?>">
                                            <div class="indicator" data-presentatieId="<?= $presentatieId ?>">
                                                <div class="heart_5617cae9ce5d0" data-presentatieId="<?= $presentatieId ?>"></div>
                                                <div class="bar" data-presentatieId="<?= $presentatieId ?>" data-capaciteit="<?= $ruimte->capaciteit ?>"><div class="fill"></div></div>
                                            </div>
                                            <h1><?= $presentatie->ruimte ?>: <?= $presentatie->titel ?></h1>
                                            <h2>door <?= $presentatie->naam ?></h2>
                                            <p><?= $presentatie->beschrijving ?></p>
                                        </section>
                                    <?php }
                                } else {
                                    ?>
                                        <section class="placeholder"><?= $ruimteId ?></section>
                                    <?php
                                }
                            ?></section>
                        <?php } ?>
                    </section>
                <?php } ?>
            </section>
        </section>
        <script src="programma.js"></script>
    </body>
</html>