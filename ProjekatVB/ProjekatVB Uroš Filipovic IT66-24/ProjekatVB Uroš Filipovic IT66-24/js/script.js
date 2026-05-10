const stavke = ["Vrhunska dijagnostika", "Garancija na radove", "Originalni rezervni delovi"];

function transformisiTekst(txt) {
    return txt.trim().toUpperCase(); 
}

function validirajFormu(ime, mail) {
    // Kontrolna struktura (IF)
    if (ime.length > 3 && mail.includes("@")) {
        return true;
    }
    return false;
}

document.addEventListener('DOMContentLoaded', () => {
    
    // Generisanje liste na početnoj stranici
    const oNamaSekcija = document.getElementById('o-nama-sekcija');
    if (oNamaSekcija) {
        const h3 = document.createElement('h3');
        h3.style.marginTop = "20px";
        h3.innerText = transformisiTekst("Naši standardi");
        oNamaSekcija.appendChild(h3);

        const lista = document.createElement('ul');
        lista.style.padding = "15px 0";
        
        for (let i = 0; i < stavke.length; i++) {
            let li = document.createElement('li');
            li.innerHTML = `<span style="color: #3498db; margin-right: 10px;">✔</span> ${stavke[i]}`;
            li.style.listStyle = "none";
            li.style.marginBottom = "8px";
            lista.appendChild(li);
        }
        oNamaSekcija.appendChild(lista);
    }

    const forma = document.getElementById('contactForm');
    if (forma) {
        forma.addEventListener('submit', function(e) {
            e.preventDefault();
            const imeVrednost = document.getElementById('ime').value;
            const mailVrednost = document.getElementById('email').value;
            const status = document.getElementById('formStatus');

            if (validirajFormu(imeVrednost, mailVrednost)) {
                status.innerHTML = `<p style="color: green; font-weight: bold; margin-top: 15px;">Hvala Vam, ${imeVrednost}. Uspešno ste poslali poruku!</p>`;
                forma.reset();
            } else {
                status.innerHTML = `<p style="color: red; margin-top: 15px;">Greška: Proverite podatke unete u formu.</p>`;
            }
        });
    }
});