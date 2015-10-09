<?php
    $programmaJson = file_get_contents('programma.json');
    $programma = json_decode($programmaJson);
    $ordered = [];
    
    function loadProgramma() {
        global $programma, $ordered;
        foreach ($programma->presentaties as $presentatie) {
            if (empty($ordered[$presentatie->blok])) {
                $ordered[$presentatie->blok] = [];
            }
            $ordered[$presentatie->blok][$presentatie->kolom] = $presentatie;
        }
    }
    loadProgramma();
    
    function getPresentatie($blokId, $kolomId) {
        global $ordered;
        return empty($ordered[$blokId]) ? null :
               empty($ordered[$blokId][$kolomId]) ? null :
               $ordered[$blokId][$kolomId];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<meta name='viewport' content='width=320,initial-scale=1,user-scalable=0'>-->
        <meta name="mobile-web-app-capable" content="yes">
        <meta name='viewport' content='minimal-ui,width=320,initial-scale=1,user-scalable=0'>
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex">
        <link rel='image_src' href='pb.png'/>
        <link rel='shortcut icon' type='image/png' href='pb.png'>
        <link href="reset.css" rel="stylesheet">
        <script src="jquery-2.1.4.min.js"></script>
        <style>
            /* CSS by GenerateCSS.com */
            .heart_5617cae9ce5d0 {
                position: absolute;
                right: 46px;
                top: 10px;
            }
            .heart_5617cae9ce5d0:before,
            .heart_5617cae9ce5d0:after {
                position:absolute;
                content: "";
                left: 19px;
                top: 0;
                width: 19px;
                height: 32px;
                background-color: #a33;
                -moz-border-radius: 12px 12px 0 0;
                border-radius: 12px 12px 0 0;
                -webkit-transform: rotate(-45deg);
                -moz-transform: rotate(-45deg);
                -ms-transform: rotate(-45deg);
                -o-transform: rotate(-45deg);
                transform:rotate(-45deg);
                -webkit-transform-origin: 0 100%;
                -moz-transform-origin: 0 100%;
                -ms-transform-origin: 0 100%;
                -o-transform-origin: 0 100%;
                transform-origin: 0 100%;
            }
            .heart_5617cae9ce5d0.hearted:before,
            .heart_5617cae9ce5d0.hearted:after {
                background-color: #FFCC00;
            }
            .heart_5617cae9ce5d0:after {
                left: 0;
                -webkit-transform: rotate(45deg);
                -moz-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                -o-transform: rotate(45deg);
                transform: rotate(45deg);
                -webkit-transform-origin: 100% 100%;
                -moz-transform-origin: 100% 100%;
                -ms-transform-origin: 100% 100%;
                -o-transform-origin: 100% 100%;
                transform-origin: 100% 100%;
            }
        </style>
        <style>
            html, body {
                background: black;
                color: white;
                font-family: Arial;
                line-height: 1.4;
                width: 100%;
                overflow-x: hidden;
                min-width: 340px;
            }
            h1 {
                font-size: 2em;
                font-weight: 100;
                text-align: center;
            }
            h2 {
                font-weight: 900;
                text-align: center;
            }
            .blok {
                overflow-x: auto;
                white-space: nowrap;
                text-align: center;
            }
            .kolom {
                vertical-align: top;
                width: 340px;
                height: 200px;
                display: inline-block;
                background: #f66;
                margin: 10px 2px;
                white-space: normal;
                position: relative;
            }
            .kolom p {
                margin: 10px;
                height: 110px;
                overflow-y: hidden;
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <h2>Permanent Beta</h2>
        <h1>Programma 13&nbsp;november&nbsp;2015</h1>
        <section class="programma">
            <?php foreach ($programma->blokken as $blokId => $blok) { ?>
                <h2><?= $blok->begintijd ?> tot <?= $blok->eindtijd ?></h2>
                <section class="blok">
                    <?php foreach ($programma->kolommen as $kolomId => $kolom) { ?>
                        <?php $presentatie = getPresentatie($blokId, $kolomId) ?>
                        <?php if ($presentatie) { ?>
                            <section class="kolom" <?php if ($kolom->kleur) { ?>style="background: <?= $kolom->kleur ?>"<?php } ?>>
                                <div class="heart_5617cae9ce5d0" data-blokid="<?= $blokId ?>" data-kolomid="<?= $kolomId ?>"></div>
                                <h1><?= $presentatie->titel ?></h1>
                                <h2>door <?= $presentatie->naam ?></h2>
                                <p><?= $presentatie->beschrijving ?></p>
                            </section>
                        <?php } ?>
                    <?php } ?>
                </section>
            <?php } ?>
        </section>
        <script>
            var hearts = JSON.parse(localStorage.getItem("hearts")) || {};
            // Loop hearts and toggle on.
            $(".heart_5617cae9ce5d0").each(function () {
                $(this).toggleClass("hearted", (function ($el) {
                    return !!hearts[$el.data("blokid") + ',' + $el.data("kolomid")];
                })($(this)));
            });
            // Bind click to toggle on and save.
            $(".heart_5617cae9ce5d0").click(function () {
                var $el = $(this);
                $el.toggleClass("hearted");
                hearts[$el.data("blokid") + ',' + $el.data("kolomid")] = $el.hasClass("hearted");
                localStorage.setItem("hearts", JSON.stringify(hearts));
            });
        </script>
    </body>
</html>