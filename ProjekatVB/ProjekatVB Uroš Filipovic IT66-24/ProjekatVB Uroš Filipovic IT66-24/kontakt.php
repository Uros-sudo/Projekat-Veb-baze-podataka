<?php
require_once 'php/config.php';
$broj_poseta = brojacPoseta();
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt | Autoservis Filipović</title>
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
        #formStatus p {
            margin-top: 15px;
            font-weight: bold;
            padding: 12px 16px;
            border-radius: 8px;
        }
        #formStatus .uspeh {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #86efac;
        }
        #formStatus .greska {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fca5a5;
        }
    </style>
</head>
<body>

    <div class="info-bar">
        <span>📅 <span id="realni-datum">...</span> &nbsp;|&nbsp; 🕐 <span id="realno-vreme">...</span></span>
        <span>👥 Ukupno poseta: <strong><?= number_format($broj_poseta) ?></strong></span>
    </div>

    <nav>
        <div class="logo">
            <img src="images/logo2.png" alt="Logo">
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">☰</label>
        <ul>
            <li><a href="index.php">Početna</a></li>
            <li><a href="usluge.php">Usluge</a></li>
            <li><a class="active" href="kontakt.php">Kontakt</a></li>
        </ul>
    </nav>

    <header class="hero">
        <h1>Kontaktirajte Nas</h1>
        <p>Pošaljite nam poruku i odgovorićemo u najkraćem roku</p>
    </header>

    <main>
        <section class="container-form">
            <div class="kontakt-sekcija">
                <h2>Online Upit</h2>
                <form id="contactForm">
                    <div class="input-group">
                        <label for="ime">Ime i prezime</label>
                        <input type="text" id="ime" name="ime" placeholder="Vaše ime" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email adresa</label>
                        <input type="email" id="email" name="email" placeholder="vas@email.com" required>
                    </div>
                    <div class="input-group">
                        <label for="poruka">Vaša poruka</label>
                        <textarea id="poruka" name="poruka" rows="6" placeholder="Opišite kvar ili uslugu koja Vam je potrebna..." required></textarea>
                    </div>
                    <button type="submit" class="posalji">Pošalji poruku</button>
                </form>
                <div id="formStatus"></div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Autoservis Filipović. Sva prava zadržana.</p>
    </footer>

    <script src="js/script.js"></script>
    <script>
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
        document.addEventListener('DOMContentLoaded', () => {
            const forma = document.getElementById('contactForm');
            if (!forma) return;

            forma.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); 

                const dugme = forma.querySelector('.posalji');
                const status = document.getElementById('formStatus');

                const ime = document.getElementById('ime').value.trim();
                const email = document.getElementById('email').value.trim();
                const poruka = document.getElementById('poruka').value.trim();

                dugme.disabled = true;
                dugme.textContent = 'Slanje...';
                status.innerHTML = '';

                const podaci = new FormData();
                podaci.append('ime', ime);
                podaci.append('email', email);
                podaci.append('poruka', poruka);

                fetch('php/kontakt_handler.php', {
                    method: 'POST',
                    body: podaci
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        status.innerHTML = `<p class="uspeh">✅ ${data.poruka}</p>`;
                        forma.reset();
                    } else {
                        status.innerHTML = `<p class="greska">❌ ${data.poruka}</p>`;
                    }
                })
                .catch(() => {
                    status.innerHTML = `<p class="greska">❌ Greška pri slanju. Proverite vezu i pokušajte ponovo.</p>`;
                })
                .finally(() => {
                    dugme.disabled = false;
                    dugme.textContent = 'Pošalji poruku';
                });
            }, true); 
        });
    </script>
</body>
</html>
