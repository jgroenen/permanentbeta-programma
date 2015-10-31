<?php

    // Sprekers:
    // 1) csv vanuit google docs
    // 2) http://www.convertcsv.com/csv-to-json.htm
    // 3) http://www.jsoneditoronline.org/

    $sprekersJson = file_get_contents('private/sprekers.json');
    $sprekers = json_decode($sprekersJson);
    $toezeggingen = [];
    
    foreach ($sprekers as $spreker) {
        if ($spreker->Status === "toegezegd") {
            $toezeggingen[] = (object) [
                "Naam" => $spreker->Naam,
                "Achtergrond" => $spreker->Achtergrond,
                "Titel" => $spreker->Titel
            ];
        }
    }
    
    shuffle($toezeggingen);
?>
<!DOCTYPE html>
<html>
    <head>
        
        <!--[if lt IE 9]>
        <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <![endif]-->
      
        <!--<meta name='viewport' content='width=320,initial-scale=1,user-scalable=0'>-->
        <meta charset="UTF-16">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name='viewport' content='minimal-ui,width=320,initial-scale=1,user-scalable=0'>
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex">
        <link rel='image_src' href='pb.png'/>
        <link rel='shortcut icon' type='image/png' href='pb.png'>
        <link href="reset.css" rel="stylesheet">
        <script src="jquery-2.1.4.min.js"></script>
        <style>
            html, body {
                font-size: 100%;
                text-align: center;
                font-family: Arial;
                line-height: 1.4;
                background: #333;
                color: #fff;
            }
            h1, h2, h3 {
                font-size: 4em;
            }
            header h2, em {
                color: #ee2f71;
            }
            header h3 {
                font-size: 2em;
                color: #ffc;
            }
            main {display:block} 
            .spreker {
                display: inline-block;
                margin: 2em;
                width: 300px;
                border: 1px solid gray;
                padding: 1em 0;
                background: #ee2f71;
                padding: 0.5em;
            }
            .spreker h1 {
                font-size: 2em;
            }
            .spreker h2 {
                font-size: 1.4em;
                line-height: 2em;
            }
            .spreker h3 {
                font-size: 1em;
            }
            a.button {
                display: inline-block;
                color: #fff;
                background: #2fee71;
                margin: 1em;
                padding: 0.5em 1em;
                border-radius: 0.1em;
                text-decoration: none;
            }
            main {
                background: #222;
                padding: 1em;
                text-align: left;
            }
            p {
                margin-bottom: 1em;
            }
            a {
                color: #fff;
            }
            @media only screen and (max-width: 400px) {
                header {
                    border-bottom: 1px solid gray;
                }
                .spreker {
                    margin: auto;
                    border: 0;
                    border-bottom: 1px solid gray;
                    width: 100%;
                    padding: 0;
                    margin-bottom: 0.5em;
                }
                h1, h2 {
                    font-size: 2em;
                }
                header h3 {
                    font-size: 1em;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <h2>Permanent Beta</h2>
            <h3>Meer inspiratie dan je aankan!</h3>
            <h1>Voorlopige sprekerslijst <em>PB dag #7</em> Rotterdam</h1>
            <h3>13 november 2015, 9:30 tot 20:00 uur</h3>
            <a class="button" href="http://www.meetup.com/PermanentBeta/events/222345799/">Aanmelden</a>
        </header>
        <main>
            <p>
                Het exacte programma met alle tijden wordt binnenkort vastgesteld.
            </p>
            <p>
                PB dag #7 zal plaatsvinden op:<br>
                <a href="http://www.hetlyceumrotterdam.nl/">Het Lyceum Rotterdam</a><br>
                Beukelsdijk 91, 3021 AE Rotterdam
            </p>
            <p>
                <a href="http://www.permanentbeta.nl">Meer informatie over Permanent Beta</a>.
            </p>
        </main>
        <section class="sprekers">
            <?php foreach ($toezeggingen as $toezegging) { ?>
                <section class="spreker">
                    <h2><?=$toezegging->Naam?></h2>
                    <h3><?=$toezegging->Achtergrond?></h3>
                    <h1><?=$toezegging->Titel?></h1>
                </section>
            <?php } ?>
        </section>
        <a class="button" href="http://www.meetup.com/PermanentBeta/events/222345799/">Aanmelden</a>
    </body>
</html>