<?php
require_once 'php/config.php';
$broj_poseta = brojacPoseta();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoservis Filipović | Početna</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* ---- INFO BAR ---- */
        .info-bar {
            background: #3498db;
            color: white;
            font-size: 0.85rem;
            padding: 7px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }
        .info-bar span { display: flex; align-items: center; gap: 6px; }
        .akcije-naslov {
            text-align: center;
            padding: 40px 20px 10px;
            background: #f0f6fc;
        }
        .akcije-naslov h2 {
            color: #002147;
            font-size: 1.8rem;
            border: none;
            padding: 0;
            margin-bottom: 6px;
        }
        .akcije-naslov p {
            color: #555;
            font-size: 0.97rem;
        }
        .akcije-naslov .linija {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #002147);
            border-radius: 2px;
            margin: 12px auto 0;
        }
        .akcije-wrapper {
            background: #f0f6fc;
            padding: 28px 0 48px;
            position: relative;
            overflow: hidden;
        }

        .slajder-outer {
            position: relative;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 60px;
        }
        .slajder-traka {
            display: flex;
            transition: transform 0.55s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 24px;
        }
        .akcija-kartica {
            min-width: calc(33.333% - 16px);
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,33,71,0.10);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid #dce8f5;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .akcija-kartica:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 32px rgba(52,152,219,0.18);
        }
        .akcija-bedz {
            position: absolute;
            top: 14px;
            right: 14px;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 4px 11px;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(231,76,60,0.35);
            z-index: 2;
        }
        .akcija-bedz.sezonski { background: linear-gradient(135deg, #f39c12, #e67e22); }
        .akcija-bedz.novo     { background: linear-gradient(135deg, #27ae60, #1e8449); }
        .akcija-vrh {
            padding: 32px 24px 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            border-bottom: 2px solid #f0f6fc;
        }
        .akcija-ikona {
            width: 62px;
            height: 62px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            flex-shrink: 0;
        }
        .boja-plava   { background: linear-gradient(135deg, #dbeeff, #b3d9ff); }
        .boja-tamna   { background: linear-gradient(135deg, #cfd8e8, #b0bfd3); }
        .boja-crvena  { background: linear-gradient(135deg, #ffe0de, #ffbbb7); }
        .boja-zelena  { background: linear-gradient(135deg, #d4f5e2, #a8e6c2); }
        .boja-zuta    { background: linear-gradient(135deg, #fff3cc, #ffe080); }
        .boja-ljubic  { background: linear-gradient(135deg, #e8deff, #d0bcff); }

        .akcija-vrh-tekst h3 {
            color: #002147;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .akcija-vrh-tekst .kategorija-tag {
            font-size: 0.75rem;
            color: #3498db;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .akcija-telo {
            padding: 18px 24px 20px;
            flex: 1;
        }
        .akcija-telo p {
            color: #555;
            font-size: 0.88rem;
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .akcija-cena {
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }
        .cena-stara {
            font-size: 0.9rem;
            color: #aaa;
            text-decoration: line-through;
        }
        .cena-nova {
            font-size: 1.5rem;
            font-weight: 800;
            color: #002147;
        }
        .cena-popust {
            background: linear-gradient(135deg, #3498db, #2176ae);
            color: white;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 12px;
        }
        .akcija-footer {
            padding: 12px 24px 18px;
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            color: #888;
            border-top: 1px solid #f0f6fc;
        }
        .akcija-footer strong { color: #002147; }
        .btn-zakazi {
            display: block;
            margin: 0 24px 20px;
            padding: 11px;
            background: linear-gradient(135deg, #002147, #003575);
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.88rem;
            letter-spacing: 0.03em;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-zakazi:hover {
            background: linear-gradient(135deg, #3498db, #2176ae);
            transform: translateY(-1px);
        }
        .slajder-strelica {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid #dce8f5;
            color: #002147;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 10;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,33,71,0.12);
        }
        .slajder-strelica:hover {
            background: #3498db;
            border-color: #3498db;
            color: white;
        }
        .slajder-strelica.levo  { left: 4px; }
        .slajder-strelica.desno { right: 4px; }
        .slajder-strelica:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }
        .slajder-tacke {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }
        .tacka {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #c5d9ed;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            padding: 0;
        }
        .tacka.aktivna {
            background: #3498db;
            width: 24px;
            border-radius: 4px;
        }
        @media (max-width: 900px) {
            .akcija-kartica { min-width: calc(50% - 12px); }
        }
        @media (max-width: 600px) {
            .akcija-kartica { min-width: 100%; }
            .slajder-outer { padding: 0 48px; }
        }
    </style>
</head>
<body>
    <div class="info-bar">
        <span> <span id="realni-datum">...</span> &nbsp;|&nbsp;  <span id="realno-vreme">...</span></span>
        <span> Ukupno poseta: <strong><?= number_format($broj_poseta) ?></strong></span>
    </div>

    <nav>
        <div class="logo">
            <img src="images/logo2.png" alt="Logo">
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">☰</label>
        <ul>
            <li><a class="active" href="index.php">Početna</a></li>
            <li><a href="usluge.php">Usluge</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Dobrodošli u Autoservis Filipović</h1>
            <p>Vaš pouzdan partner za održavanje i popravku vozila.</p>
        </div>
    </header>
    <main class="container-text">
        <section class="o-nama" id="o-nama-sekcija">
            <h2>O Nama</h2>
            <p>Autoservis Filipović radi od 2009. godine. Kroz naše ruke prošlo je na hiljade vozila — jedni dolaze redovno na servis, drugi posle udesa ili kvara koji ih je zatekao. U svakom slučaju, trudimo se da auto vrate na put što pre i u što boljem stanju.</p>
            <p>Radionica pokriva mehaniku, limariju i farbarstvo. Nema potrebe da nosite auto na više mesta — sve se radi ovde, od dijagnostike do završnog laka.</p>

            <h3>Zašto klijenti biraju nas:</h3>
            <ul class="standardi">
                <li>&#10003; Garancija na sve radove</li>
                <li>&#10003; Originalni i provereni delovi</li>
                <li>&#10003; Kompjuterska dijagnostika</li>
                <li>&#10003; Poštovanje dogovorenih rokova</li>
                <li>&#10003; Transparentne cene bez skrivenih troškova</li>
                <li>&#10003; Sopstvena kabina za farbanje</li>
            </ul>

            <div class="animacija">
                <div class="pomeranje-kola">
                    <img src="images/doodlecar-removebg-preview.png" alt="">
                    
                </div>
            </div>
        </section>
    </main>
    <div class="akcije-naslov">
        <h2>Aktuelne akcije</h2>
        <p>Promotivne ponude ograničenog trajanja — zakažite termin na vreme.</p>
        <div class="linija"></div>
    </div>

    <div class="akcije-wrapper">
        <div class="slajder-outer">

            <button class="slajder-strelica levo" id="btn-levo">&#8249;</button>
            <button class="slajder-strelica desno" id="btn-desno">&#8250;</button>

            <div style="overflow:hidden; border-radius: 14px;">
                <div class="slajder-traka" id="slajder-traka">
                    <div class="akcija-kartica">
                        <span class="akcija-bedz">AKCIJA</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-plava"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Mehanički radovi</div>
                                <h3>Kompletan servis ulja i filtera</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Zamena motornog ulja, filtera ulja, filtera vazduha i filtera kabine. Uključena i kompjuterska dijagnostika grešaka.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">6.500 RSD</span>
                                <span class="cena-nova">4.990 RSD</span>
                                <span class="cena-popust">-23%</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                             Važi do: <strong>31. maj 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>
                    <div class="akcija-kartica">
                        <span class="akcija-bedz sezonski">SEZONSKI</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-zuta"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Letnja priprema</div>
                                <h3>Prelaz na letnje gume + balansiranje</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Zamena zimskih guma letnima, balansiranje sva 4 točka i provera pritiska. Besplatna kontrola kočnica u paketu.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">4.200 RSD</span>
                                <span class="cena-nova">2.900 RSD</span>
                                <span class="cena-popust">-31%</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                            Važi do: <strong>15. jun 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>
                    <div class="akcija-kartica">
                        <span class="akcija-bedz" style="background:linear-gradient(135deg,#8e44ad,#6c3483);">PREMIUM</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-ljubic"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Farbarski radovi</div>
                                <h3>Poliranje + keramička zaštita laka</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Mašinsko poliranje celog vozila, uklanjanje mikroogrebotina i nanošenje keramičke zaštite. Trajnost do 12 meseci.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">18.000 RSD</span>
                                <span class="cena-nova">13.500 RSD</span>
                                <span class="cena-popust">-25%</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                             Važi do: <strong>30. jun 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>
                    <div class="akcija-kartica">
                        <span class="akcija-bedz novo">NOVO</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-zelena"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Klima uređaj</div>
                                <h3>Punjenje i dezinfekcija klime</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Dopuna rashladnog sredstva, provera curenja, zamena filtera kabine i ozonska dezinfekcija unutrašnjosti vozila.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">5.800 RSD</span>
                                <span class="cena-nova">3.990 RSD</span>
                                <span class="cena-popust">-31%</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                             Važi do: <strong>31. jul 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>
                    <div class="akcija-kartica">
                        <span class="akcija-bedz">AKCIJA</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-crvena"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Bezbednost</div>
                                <h3>Kompletna kontrola kočionog sistema</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Pregled i merenje debljine pločica i diskova, provera kočionih creva, stezaljki i nivoa kočione tečnosti.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">3.200 RSD</span>
                                <span class="cena-nova">BESPLATNO</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                             Važi do: <strong>20. maj 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>
                    <div class="akcija-kartica">
                        <span class="akcija-bedz sezonski">PAKET</span>
                        <div class="akcija-vrh">
                            <div class="akcija-ikona boja-tamna"></div>
                            <div class="akcija-vrh-tekst">
                                <div class="kategorija-tag">Limarski radovi</div>
                                <h3>Sanacija udubljenja PDR metodom</h3>
                            </div>
                        </div>
                        <div class="akcija-telo">
                            <p>Uklanjanje udubljenja bez farbanja specijalnim alatom. Do 3 manja udubljenja po akcijskoj ceni, bez oštećenja originalnog laka.</p>
                            <div class="akcija-cena">
                                <span class="cena-stara">9.000 RSD</span>
                                <span class="cena-nova">5.990 RSD</span>
                                <span class="cena-popust">-33%</span>
                            </div>
                        </div>
                        <div class="akcija-footer">
                             Važi do: <strong>30. jun 2026.</strong>
                        </div>
                        <a href="kontakt.php" class="btn-zakazi">Zakaži termin →</a>
                    </div>

                </div>
            </div>

            <div class="slajder-tacke" id="slajder-tacke"></div>

        </div>
    </div>

    <footer>
        <p>&copy; <?= date('Y') ?> Autoservis Filipović. Sva prava zadržana.</p>
    </footer>

    <script src="js/script.js"></script>
    <script>
        function updateVreme() {
            const now = new Date();
            const dani   = ['Nedelja','Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota'];
            const meseci = ['januara','februara','marta','aprila','maja','juna','jula','avgusta','septembra','oktobra','novembra','decembra'];
            document.getElementById('realni-datum').textContent =
                `${dani[now.getDay()]}, ${now.getDate()}. ${meseci[now.getMonth()]} ${now.getFullYear()}.`;
            document.getElementById('realno-vreme').textContent =
                `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
        }
        updateVreme();
        setInterval(updateVreme, 1000);
        (function() {
            const traka      = document.getElementById('slajder-traka');
            const btnLevo    = document.getElementById('btn-levo');
            const btnDesno   = document.getElementById('btn-desno');
            const tackeWrap  = document.getElementById('slajder-tacke');
            const kartice    = traka.querySelectorAll('.akcija-kartica');
            function vidljive() {
                if (window.innerWidth <= 600) return 1;
                if (window.innerWidth <= 900) return 2;
                return 3;
            }

            let trenutni = 0;
            let auto;

            function ukupnoSlajdova() {
                return kartice.length - vidljive() + 1;
            }
            function napraviTacke() {
                tackeWrap.innerHTML = '';
                const n = ukupnoSlajdova();
                for (let i = 0; i < n; i++) {
                    const t = document.createElement('button');
                    t.className = 'tacka' + (i === trenutni ? ' aktivna' : '');
                    t.setAttribute('aria-label', 'Slajd ' + (i+1));
                    t.addEventListener('click', function() { idi(i); resetAuto(); });
                    tackeWrap.appendChild(t);
                }
            }
            function idi(n) {
                const maks = ukupnoSlajdova() - 1;
                trenutni = Math.max(0, Math.min(n, maks));
                const kartica    = kartice[0];
                const sirina     = kartica.offsetWidth + 24; // 24 = gap
                traka.style.transform = `translateX(-${trenutni * sirina}px)`;
                tackeWrap.querySelectorAll('.tacka').forEach(function(t, i) {
                    t.classList.toggle('aktivna', i === trenutni);
                });
                btnLevo.disabled  = trenutni === 0;
                btnDesno.disabled = trenutni >= maks;
            }

            function resetAuto() {
                clearInterval(auto);
                auto = setInterval(function() {
                    const sledeci = trenutni + 1 >= ukupnoSlajdova() ? 0 : trenutni + 1;
                    idi(sledeci);
                }, 4500);
            }
            btnLevo.addEventListener('click',  function() { idi(trenutni - 1); resetAuto(); });
            btnDesno.addEventListener('click', function() { idi(trenutni + 1); resetAuto(); });
            let touchX = 0;
            traka.addEventListener('touchstart', function(e) { touchX = e.touches[0].clientX; }, {passive:true});
            traka.addEventListener('touchend',   function(e) {
                const diff = touchX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 40) { idi(diff > 0 ? trenutni+1 : trenutni-1); resetAuto(); }
            }, {passive:true});
            napraviTacke();
            idi(0);
            resetAuto();
            let rezajmTimer;
            window.addEventListener('resize', function() {
                clearTimeout(rezajmTimer);
                rezajmTimer = setTimeout(function() { napraviTacke(); idi(0); }, 200);
            });
        })();
    </script>
</body>
</html>
