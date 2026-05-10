<?php
require_once 'php/config.php';
$broj_poseta = brojacPoseta();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usluge | Autoservis Filipović</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
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
            <li><a href="index.php">Početna</a></li>
            <li><a class="active" href="usluge.php">Usluge</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
        </ul>
    </nav>

    <div class="hero">
        <h1>Naše Usluge</h1>
        <p>Vrhunski kvalitet servisiranja za sve tipove vozila</p>
    </div>

    <section class="usluge-kontejner">

        <!-- KARTICA 1: Mehaničarski radovi -->
        <div class="kartica">
            <h3>Mehaničarski radovi</h3>
            <div class="image-wrapper">
                <img src="images/mehanicki_radovi.jpg" alt="Mehanika">
                <div class="overlay">
                    <p>Kompletna dijagnostika motora, servisiranje kočionih sistema i zamena delova vrhunskog kvaliteta.</p>
                </div>
            </div>
            <button class="btn-radovi" data-slug="mehanika" data-otvoren="0">
                Pogledaj spisak radova <span class="strelica">&#9660;</span>
            </button>
            <div class="radovi-panel" id="panel-mehanika">
                <div class="ucitavanje">Učitavanje...</div>
            </div>
        </div>

        <!-- KARTICA 2: Limarski radovi -->
        <div class="kartica">
            <h3>Limarski radovi</h3>
            <div class="image-wrapper">
                <img src="images/autolimarija-autoplastika-01a.jpg" alt="Limarija">
                <div class="overlay">
                    <p>Ispravljanje oštećenja na šasiji, popravka nakon udesa i vraćanje fabričkog izgleda Vašem vozilu.</p>
                </div>
            </div>
            <button class="btn-radovi" data-slug="limarija" data-otvoren="0">
                Pogledaj spisak radova <span class="strelica">&#9660;</span>
            </button>
            <div class="radovi-panel" id="panel-limarija">
                <div class="ucitavanje">Učitavanje...</div>
            </div>
        </div>

        <!-- KARTICA 3: Farbarski radovi -->
        <div class="kartica">
            <h3>Farbarski radovi</h3>
            <div class="image-wrapper">
                <img src="images/lakirerski_radovi.jpg" alt="Farbanje">
                <div class="overlay">
                    <p>Precizno farbanje najkvalitetnijim bojama u profesionalnim komorama za savršen sjaj.</p>
                </div>
            </div>
            <button class="btn-radovi" data-slug="farbanje" data-otvoren="0">
                Pogledaj spisak radova <span class="strelica">&#9660;</span>
            </button>
            <div class="radovi-panel" id="panel-farbanje">
                <div class="ucitavanje">Učitavanje...</div>
            </div>
        </div>

    </section>

    <footer>
        <p>&copy; <?= date('Y') ?> Autoservis Filipović. Sva prava zadržana.</p>
    </footer>

    <script src="js/script.js"></script>
    <script>
        // Realno vreme
        function updateVreme() {
            const now = new Date();
            const dani = ['Nedelja','Ponedeljak','Utorak','Sreda','Četvrtak','Petak','Subota'];
            const meseci = ['januara','februara','marta','aprila','maja','juna','jula','avgusta','septembra','oktobra','novembra','decembra'];
            document.getElementById('realni-datum').textContent =
                `${dani[now.getDay()]}, ${now.getDate()}. ${meseci[now.getMonth()]} ${now.getFullYear()}.`;
            document.getElementById('realno-vreme').textContent =
                `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')}`;
        }
        updateVreme();
        setInterval(updateVreme, 1000);

        // ============================================
        // LOGIKA ZA PRIKAZ RADOVA IZ BAZE
        // ============================================
        const ucitani = {}; // Kes vec ucitanih radova

        document.querySelectorAll('.btn-radovi').forEach(function(dugme) {
            dugme.addEventListener('click', function() {
                const slug    = this.dataset.slug;
                const panel   = document.getElementById('panel-' + slug);
                const otvoren = this.dataset.otvoren === '1';

                if (otvoren) {
                    // --- ZATVORI ---
                    panel.classList.remove('otvoren');
                    this.dataset.otvoren = '0';
                    this.classList.remove('aktivan');
                    this.innerHTML = 'Pogledaj spisak radova <span class="strelica">&#9660;</span>';
                    return;
                }

                // --- OTVORI ---
                panel.classList.add('otvoren');
                this.dataset.otvoren = '1';
                this.classList.add('aktivan');
                this.innerHTML = 'Sakrij spisak radova <span class="strelica">&#9660;</span>';

                // Ako su radovi vec ucitani, samo prikazi
                if (ucitani[slug]) return;

                // Prikazi spinner dok ucitava
                panel.innerHTML = '<div class="ucitavanje">⏳ Učitavanje radova...</div>';

                // Dohvati radove iz baze (AJAX)
                fetch('php/get_radovi.php?slug=' + slug)
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data.success && data.radovi.length > 0) {
                            let html = '<ul>';
                            data.radovi.forEach(function(rad) {
                                html += '<li>';
                                html += '<span class="ikona">&#10003;</span>';
                                html += '<div>';
                                html += '<div class="naziv">' + rad.naziv + '</div>';
                                if (rad.opis) {
                                    html += '<div class="opis">' + rad.opis + '</div>';
                                }
                                html += '</div></li>';
                            });
                            html += '</ul>';
                            panel.innerHTML = html;
                            ucitani[slug] = true; // Postavi flag tek nakon uspesnog ucitavanja
                        } else {
                            panel.innerHTML = '<div class="ucitavanje">Nema dostupnih radova.</div>';
                        }
                    })
                    .catch(function() {
                        panel.innerHTML = '<div class="ucitavanje"> Greška pri učitavanju. Proverite bazu podataka.</div>';
                    });
            });
        });
    </script>
</body>
</html>
