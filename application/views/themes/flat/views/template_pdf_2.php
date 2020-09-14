<style>
    .font-11 {
        font-size: 11px
    }

    .tesds21 td {
        width: 100%;
    }

    .eee21 td, .tesds21 td {
        width: 100%;
    }

    .tesds21 td, .tt1 td {
        height: 8px;
    }

    .sds21 {
        height: 2px;
        width: 2px;
        background: black;
        border-radius: 100%;
    }

    .eee21 td, .tt1212 td {
        height: 8px;
    }

    .ttt21 td, .tbl21 td, .tb2 td {
        height: 8px;
        width: 25%;
    }

    .ttdf td {
        height: 6px;
        width: 100%;
    }

    .text-center, .text-center * {
        text-align: center
    }

    .tb2l td {
        height: 8px;
        width: 100%;
    }

    .ledttd td {
        min-height: 15px;
    }

    span {
        padding-left: 0;
    }

    .nopp {
        padding: 0 !important;
    }

    .noma {
        margin: 0 !important;
        border: none !important;
    }

    .tb2 {
    / / border-spacing: 1 px !important;
    }

    .ttt21 {
    / / border-spacing: 1 px !important;
    }

    .ledttd td {
    }

    .ledttdf td {
        /*    min-height: 15px;*/
    }

    .tt41 td {
        height: 8px;
    }
    td {
        min-height: 50px !important;
    }

    .tbl21 td {
        width: 25%;
    }

    .bgd {
        background: #CCFFFF;
    }

    .line {
        background-image: url(assets/images/back1.png);
        background-size: cover;
        border-collapse: collapse;
    }

    .ledttd td {
        line-height: 16px;
    }

    table td, table td * {
        vertical-align: top;
    }



    .tbd1 {
        border-collapse: collapse;
    }

    .tt1 td {
        width: 100%
    }
</style>
<page backtop="0mm" backbottom="0mm" backleft="5mm" backright="5mm">
    <h1 style="text-align: center; margin-top:0; font-size: 22px; margin-bottom: 2px"> Katzky Umzüge e. Kffr.,
        Nah-Fernumzüge &
        Logistik</h1>
    <p style="text-align: center; margin: 0">Bitterfelder Straße 12, 12681 Berlin, Tel. (030) 29 49 59 11 & (030) 55 49
        38
        00, Fax (030) 55 49 38 02</p>
    <br>
    <table style="width: 100%; ">
        <tr>
            <td style="width: 50%; padding-right: 12px" class="font-11 ledttd">
                <table style="margin: 0; width: 100%" class="tt1">
                    <tr>
                        <td class="line" style="height: 42px"><strong>Auftraggeber/Rechnungsempfänger:</strong><br> GEHAG
                            Erste
                        </td>
                    </tr>
                </table>
                <table style="margin: 0; width: 100%" class="tt1212">
                    <tr>
                        <td style="width: 40%"><strong>Name Mieter:</strong></td>
                        <td class="line" style="width: 60%" colspan="2">
                            <strong><?= $template->mieter ?></strong></td>
                    </tr>
                    <tr>
                        <td class="line" colspan="3"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><strong>Beladestelle:</strong></td>
                        <td class="line" style="width: 60%" colspan="2">
                            <strong><?= $template->strabe . ' ' . $template->nr ?></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 40%" class="line"></td>
                        <td class="line" style="width: 60%" colspan="2">
                            <strong><?= $template->plz . ' ' . $template->ort ?></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Geschoß</td>
                        <td style="width: 60%" colspan="2"><strong><?= $template->etage ?></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><strong>Entladestelle:</strong></td>
                        <td class="line" style="width: 60%" colspan="2"><?= $template->aq_strabe.' '.$template->aq_nr ?></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><strong></strong></td>
                        <td style="width: 60%" colspan="2"><?= $template->aq_zip.' '.$template->aq_ort ?></td>
                    </tr>
                    <tr>
                        <td style="width: 40%">Geschoß</td>
                        <td style="width: 40%"></td>
                        <td style="width: 20%"><img src="assets/images/phone-icon.png" style="margin-left: 5px"
                                                    width="14"/>
                        </td>
                    </tr>
                </table>
                <table class="tbl21" style="width: 100%; margin: 0">
                    <tr>
                        <td></td>
                        <td>Datum</td>
                        <td>Uhrzeit <img src="assets/images/clock.png" style="margin-left: 5px" width="14"/></td>
                        <td>Abfahrt <img src="assets/images/clock.png" style="margin-left: 5px" width="14"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td><strong>Räumhilfe:</strong></td>
                        <td style="line-height: 11px"
                            class="line"><?= date('d/m/Y', strtotime($template->beraumung)) ?></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td><strong>Demontagen:</strong></td>
                        <td class="line"><?= date('d/m/Y', strtotime($template->beraumung)) ?></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                </table>
                <table class="tesds21" style="width: 100%">
                    <tr>
                        <td>folgende Arbeit (Besonderheit):</td>
                    </tr>
                    <tr>
                        <td class="line" style="height: 60px;">
                            <strong><?= $template->fo_arbeit ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="line" style="border-top: none; border-collapse: unset">
                            <strong><u>Demontagen:</u><?= date('d/m/Y', strtotime($template->beraumung)) ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                </table>

                <table style="width: 100%" border="1" class="tbd1">
                    <tr class="text-center">
                        <td style="width: 24%; vertical-align: middle"><strong><br>Material</strong></td>
                        <td style="width: 13%"><span>bereits ange-
                                liefert</span></td>
                        <td style="width: 12%"><span>mitzu-
                                nehmen</span></td>
                        <td style="width: 13%"><span>davon ge-
                                braucht</span></td>
                        <td style="width: 12%"><span>davon zurück</span></td>
                        <td style="width: 12%"><span>noch dort</span></td>
                        <td style="width: 14%"><span>ungebr. zurück</span></td>
                    </tr>
                    <tr>
                        <td>Umzugskarton</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 0) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 0) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 0) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 0) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 0) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 0) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Bücherkarton</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 1) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 1) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 1) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 1) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 1) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 1) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Kleiderbox</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 2) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 2) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 2) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 2) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 2) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 2) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Packseide</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 3) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 3) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 3) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 3) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 3) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 3) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Stretchfolie</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 4) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 4) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 4) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 4) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 4) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 4) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Luftpolsterfolie</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 5) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 5) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 5) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 5) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 5) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 5) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Bauplanen</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 6) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 6) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 6) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 6) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 6) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 6) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Klebeband</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 7) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 7) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 7) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 7) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 7) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 7) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Matratzenhülle</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 8) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 8) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 8) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 8) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 8) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 8) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Bettensack</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 9) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 9) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 9) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 9) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 9) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 9) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Kreppband</td>
                        <td class="text-center"><strong><?= $this->srapdata(1, 10) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(2, 10) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(3, 10) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(4, 10) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(5, 10) ?></strong></td>
                        <td class="text-center"><strong><?= $this->srapdata(6, 10) ?></strong></td>
                    </tr>
                    <tr>
                        <td style="height: 8px"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <table class="tb2" style="width: 100%">
                    <tr>
                        <td><strong>Datum</strong></td>
                        <td>Abfahrt <img src="assets/images/clock.png" style="margin-left: 5px" width="14"/></td>
                        <td>Rückkehr <img src="assets/images/clock.png" style="margin-left: 5px" width="14"/></td>
                        <td>Pause Std.</td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"><?= date('d/m/Y', strtotime($template->beraumung)) ?></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"><?= date('d/m/Y', strtotime($template->beraumung)) ?></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                        <td class="line"></td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 25%"><strong>Wartezeit:</strong></td>
                        <td style="width: 12.5%;" class="line"></td>
                        <td style="width: 12.5%;"><strong>Std.</strong></td>
                        <td style="width: 12.5%;"><strong>Grund</strong></td>
                        <td style="width: 37.5%;" class="line"></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; font-size: 10px">Sonderleistungen:</td>
                        <td colspan="4" style="width: 75%" class="line"></td>
                    </tr>
                </table>
                <table style="width: 100%;" class="eee21">
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                    <tr>
                        <td class="line"></td>
                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 25%"><strong>Einpacken:</strong></td>
                        <td style="width: 12.5%;" class="line"></td>
                        <td style="width: 12.5%;">Std.</td>
                        <td style="width: 25%"><strong>Zerlegen:</strong></td>
                        <td style="width: 12.5%;" class="line"></td>
                        <td style="width: 12.5%;">Std.</td>
                    </tr>
                    <tr>
                        <td style="width: 25%"><strong>Auspacken:</strong></td>
                        <td style="width: 12.5%;" class="line"></td>
                        <td style="width: 12.5%;">Std.</td>
                        <td style="width: 25%"><strong>Aufbauen:</strong></td>
                        <td style="width: 12.5%;" class="line"></td>
                        <td style="width: 12.5%;">Std.</td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 50%">Datum:</td>
                        <td style="width: 50%">Unterschrift:</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 100%;padding-left: 8px">30/09/2019</td>
                    </tr>
                </table>
                <div style="text-align: center;margin-top: 10px; width: 100%; border-top: 0.5px black dashed">
                    <span>(Kolonnenführer)</span></div>
            </td>
            <td style="width: 50%; padding: 0 !important; " class="ledttdf">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 55%">WIE: <?= $template->wie ?>
                            <br>Projekt-Nr.: <?= $template->projeckt ?>
                        </td>
                        <td>Auftrag: <?= $template->auftrag ?> <br> Zimmer:___</td>
                    </tr>
                    <tr>
                        <td colspan="2"><h1 style="padding-top: 8px; font-size: 22px; margin: 0; color: red">
                                Arbeitsschein</h1></td>
                    </tr>
                </table>
                <table style="width: 100%; border: 1px solid #000000 ">
                    <tr bgcolor="#000" style="color: white; ">
                        <td style="padding: 2px">
                            Vom Kunden zu bestätigen:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%; padding: 3px !important;" class="font-11">
                            <span>Einsatzzeiten Personal und Möbelwagen <br>An- und Abfahrten sowie
                                Transportzeiten werden zusätzlich berechnet.
                            </span>
                            <table style="width: 100%" class="ttt21">
                                <tr>
                                    <td style="width: 25%;">Datum</td>
                                    <td style="width: 25%;">Von <img src="assets/images/clock.png"
                                                                     style="margin-left: 5px" width="14"/></td>
                                    <td style="width: 25%;">Bis <img src="assets/images/clock.png"
                                                                     style="margin-left: 5px" width="14"/></td>
                                    <td style="width: 25%;">./. Pausen Std.</td>
                                </tr>
                                <tr>
                                    <td class="line">25/11/2019</td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                    <td class="line"></td>
                                </tr>
                            </table>
                            <br>
                            <span>Zusätzlich zum Umzugsvertrag erbrachte Leistungen:</span>
                            <table style="width: 100%" class="ttdf">
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                            </table>
                            <span>Anschluss: Waschmaschine und/oder Geschirrspüler. Probelauf?</span>
                            <table style="width: 100%" class="tt41">
                                <tr>
                                    <td style="width: 4%">
                                        <img src="assets/images/un-check.png" width="15">
                                    </td>
                                    <td style="width: 6%">Ja</td>
                                    <td style="width: 4%">
                                        <img src="assets/images/un-check.png" width="15"/>
                                    </td>
                                    <td style="width: 8%">Nein</td>
                                    <td style="width:68%" class="line"></td>
                                </tr>
                                <tr>
                                    <td style="width: 100%" colspan="5" class="line"></td>
                                </tr>
                            </table>
                            <span><strong>Vorschäden am Umzugsgut -> vor Einlagerung</strong></span>
                            <table style="width: 100%" class="tb2l">
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                                <tr>
                                    <td class="line"></td>
                                </tr>
                            </table>
                            <div>Die Richtigkeit der vorstehenden Angaben wird bestätigt.</div>
                            <br>
                            <br>
                            <table border="0" style="width: 100%" class="noma nopp">
                                <tr>
                                    <td class="nopp" style="width: 50%;">07/10/2019</td>
                                    <td class="nopp" style="width: 50%"></td>
                                </tr>
                                <tr>
                                    <td class="nopp">Datum:</td>
                                    <td class="nopp">Unterschrift:</td>
                                </tr>
                            </table>
                            <div style="background-color:#bbbbbb; display: block;
                            color:#000;font-size: 20px;
                                             margin-bottom: 5px;margin-top: 3px; padding: 7px 6px">
                                Empfängerhinweis
                            </div>
                            <div style="font-weight: bold">Die Beförderung von
                                Umzugsgut ist
                                gesetzlich
                                geregelt
                                im "Vierten Abschnitt - Frachtgeschäft" des HGB und hier speziell in den
                                §§
                                451
                                bis 451h.<br>
                                <u>Schadensanzeige:</u> Um das Erlöschen von Ersatzansprüchen zu
                                verhindern,
                                ist
                                folgendes zu beachten:<br>
                                <div style="text-align:justify; line-height: 14px;">
                                    <span style="margin:0 !important">&#8226; Untersuchen Sie das Gut bei Ablieferung
                                                    auf äußerlich erkennbare Beschädigungen oder Verluste. Halten Sie
                                                    diese auf dem Ablieferungsbeleg oder einem Schadens-protokoll
                                                    spezifiziert fest oder zeigen Sie diese dem Mö-belspediteur
                                                    spätestens am Tag nach der Ablieferung an.
                                                </span><br>
                                    <span>&#8226; Äußerlich nicht erkennbare Schäden oder Verluste, die Sie erst beim
                                                    Auspacken des Umzugsgutes feststellen, müssen dem Möbelspediteur
                                                    innerhalb von 14 Tagen nach Ablieferung spezifiziert angezeigt werden.
                                                </span>
                                    <span>&#8226; Pauschale Schadensanzeigen genügen in keinem Fall.</span>
                                    <span>&#8226; Ansprüche wegen Überschreitung der Lieferfristen erlöschen, wenn der
                                                    Empfänger dem Möbelspediteur die Überschreitung nicht innerhalb von
                                                    21 Tagen nach Ablieferung anzeigt.
                                                </span><br>
                                    <span>&#8226; Wird die Anzeige nach Ablieferung erstattet, muß sie - um den
                                                    An-spruchsverlust zu verhindern - in jedem Fall in schriftlicher
                                                    Form und innerhalb der vorgesehenen Fristen erfolgen. Die
                                                    Übermittlung der Schadensanzeige kann auch mit Hilfe einer
                                                    telekommunikativen Einrichtung erfolgen. Einer Unterschrift bedarf
                                                    es nicht, wenn der Aus-steller in anderer Weise erkennbar ist.
                                                </span><br>
                                    <span>&#8226; Zur Wahrung der Fristen genügt die rechtzeitige Absendung.</span>
                                </div>
                                Der Empfang des Transportgutes wird hiermit bescheinigt. Vom
                                Empfänger-hinweis
                                habe ich Kenntnis genommen.
                                <br>
                                <br>
                                Datum: Unterschrift:
                                <br>
                                <br>
                                <div style="width: 100%;padding-left: 8px">30/09/2019</div>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <style></style>
</page>

<page backtop="0mm" backbottom="0mm" backleft="5mm" backright="5mm">
    <style>
        .next-page td {
            height: 30px;
            font-size: 18px;
            position: relative;
        }

        .next-page td, .next-page td * {
            vertical-align: bottom;
        }

        .dashedd {
            border-bottom: 1px black dashed;
            width: 100%;
            bottom: 0;
        }
    </style>
    <table class="next-page">
        <tr>
            <td><h1>Schadensprotokoll</h1><br></td>
        </tr>
        <tr>
            <td style="padding-right: 0 !important;">
                <table style="width: 100%; border: none; padding: 0 !important; margin: 0 !important;">
                    <tr>
                        <td style="width: 46%; padding: 0 !important;">
                            Welches Gut fehlt oder ist beschädigt?
                        </td>
                        <td style="width: 54%; vertical-align: bottom">
                            <div class="dashedd"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="dashedd"></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="dashedd"></div>
            </td>
        </tr>

        <tr>
            <td> Waren Vorschäden am beschädigten Gut vorhanden?

                <span style="margin-left: 60px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Ja
                        </span>
                <span style="margin-left: 80px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Nein
                        </span>
            </td>
        </tr>
        <tr>
            <td style="margin-right: 0 !important;">
                <table style="width: 100%; border: none; padding: 0 !important; margin: 0 !important;">
                    <tr>
                        <td style="width: 30%; padding: 0 !important;">
                            Falls ja, Art und Umfang:
                        </td>
                        <td style="width: 70%; vertical-align: bottom">
                            <div class="dashedd"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div class="dashedd"></div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="dashedd"></div>
            </td>
        </tr>
        <tr>
            <td>Welcher Mitarbeiter hat den Schaden verursacht? <span style="margin-left: 60px"><img
                            src="assets/images/un-check.png" style="margin-right: 5px"
                            width="18"/> Ja
                        </span>
                <span style="margin-left: 80px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Nein
                        </span>
            </td>
        </tr>
        <tr>
            <td>Von wem sind die beschädigten oder die fehlenden Gegenstände eingepackt worden?</td>
        </tr>
        <tr>
            <td>     <span style="margin-left: 150px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                           width="18"/> von Möbelpackern
                        </span>
                <span style="margin-left: 80px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> vom Auftraggeber
                        </span>
            </td>
        </tr>
        <tr>
            <td>Von wem sind die beschädigten oder die fehlenden Gegenstände ausgepackt worden?</td>
        </tr>
        <tr>
            <td> <span style="margin-left: 150px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                       width="18"/> von Möbelpackern
                        </span>
                <span style="margin-left: 80px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> vom Auftraggeber
                        </span>
            </td>
        </tr>
        <tr>
            <td>Wann wurde der Schaden entdeckt?</td>
        </tr>
        <tr>
            <td>Während des <span style="margin-left: 60px"><img
                            src="assets/images/un-check.png" style="margin-right: 5px"
                            width="18"/> Verladens
                        </span>
                <span style="margin-left: 50px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Transports
                        </span>
                <span style="margin-left: 50px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Entladens
                        </span></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>Wurden mündliche Schadensrügen durch den Empfänger erhoben?</td>
        </tr>
        <tr>
            <td><span style="margin-left: 60px"><img
                            src="assets/images/un-check.png" style="margin-right: 5px"
                            width="18"/> Ja
                        </span>
                <span style="margin-left: 80px"><img src="assets/images/un-check.png" style="margin-right: 5px"
                                                     width="18"/> Nein
                        </span></td>
        </tr>
    </table>
    <br>
    <br>
    <h4>Dieses Schadensprotokoll ist eine Tatbestandsaufnahme.</h4>
    <h4>Sie ist kein Schadensanerkenntnis des Möbelspediteurs oder des Versicherers.</h4>
</page>