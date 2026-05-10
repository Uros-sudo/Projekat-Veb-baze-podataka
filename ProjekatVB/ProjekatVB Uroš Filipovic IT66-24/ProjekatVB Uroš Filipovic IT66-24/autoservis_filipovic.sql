CREATE DATABASE IF NOT EXISTS autoservis_filipovic
USE autoservis_filipovic;
DROP TABLE IF EXISTS posete;
CREATE TABLE posete (
    id          INT          NOT NULL AUTO_INCREMENT,
    ip_adresa   VARCHAR(45)  DEFAULT NULL,
    datum_posete DATETIME    DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS kontakti;
CREATE TABLE kontakti (
    id           INT          NOT NULL AUTO_INCREMENT,
    ime          VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL,
    poruka       TEXT         NOT NULL,
    datum_slanja DATETIME     DEFAULT CURRENT_TIMESTAMP,
    procitano    TINYINT(1)   DEFAULT 0,
    PRIMARY KEY (id)
);
DROP TABLE IF EXISTS kategorije;
CREATE TABLE kategorije (
    id       INT          NOT NULL AUTO_INCREMENT,
    naziv    VARCHAR(100) NOT NULL,
    slug     VARCHAR(100) NOT NULL,
    redosled INT          DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uq_slug (slug)
);
DROP TABLE IF EXISTS radovi;
CREATE TABLE radovi (
    id             INT          NOT NULL AUTO_INCREMENT,
    kategorija_id  INT          NOT NULL,
    naziv          VARCHAR(200) NOT NULL,
    opis           VARCHAR(255) DEFAULT NULL,
    redosled       INT          DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT fk_radovi_kategorija
        FOREIGN KEY (kategorija_id) REFERENCES kategorije (id)
        ON DELETE CASCADE
);
SET FOREIGN_KEY_CHECKS = 1;
INSERT INTO kategorije (id, naziv, slug, redosled) VALUES
(1, 'Mehanički radovi', 'mehanika', 1),
(2, 'Limarski radovi',  'limarija', 2),
(3, 'Farbarski radovi', 'farbanje', 3);
INSERT INTO radovi (id, kategorija_id, naziv, opis, redosled) VALUES
(1,  1, 'Dijagnostika motora',           'Kompjuterska dijagnostika svih sistema vozila', 1),
(2,  1, 'Servis i zamena ulja',           'Zamena motornog ulja i filtera ulja', 2),
(3,  1, 'Popravka kočionog sistema',      'Zamena pločica, diskova, bubnjeva i kočionih creva', 3),
(4,  1, 'Servis menjača',                 'Popravka i zamena manualne i automatske menjačke kutije', 4),
(5,  1, 'Zamena amortizera i opruga',     'Servis oslanjanja i geometrija trapa', 5),
(6,  1, 'Servis sistema hlađenja',        'Zamena rashladne tečnosti, termostata i radijatora', 6),
(7,  1, 'Popravka sistema paljenja',      'Zamena svećica, kablova i razdelnika', 7),
(8,  1, 'Servis klima uređaja',           'Punjenje i popravka auto klime', 8),
(9,  1, 'Zamena remena i lanca razvoda',  'Preventivna zamena pre kvara', 9),
(10, 1, 'Popravka sistema upravljanja',   'Servis volan pumpe i upravljačke šipke', 10);
INSERT INTO radovi (id, kategorija_id, naziv, opis, redosled) VALUES
(11, 2, 'Ispravljanje branika',               'Popravka plastičnih i metalnih branika', 1),
(12, 2, 'Sanacija udubljenja (dent)',          'Uklanjanje udubljenja bez farbanja — PDR metoda', 2),
(13, 2, 'Popravka krila i vrata',             'Vraćanje oblika karoserijskih panela', 3),
(14, 2, 'Zavarivanje šasije',                 'MIG/MAG zavarivanje oštećenih delova šasije', 4),
(15, 2, 'Zamena stakla i brisača',            'Zamena vetrobranskog i bočnih stakala', 5),
(16, 2, 'Antikorozivna zaštita',              'Nano premaz i zaštita dna vozila od rđe', 6),
(17, 2, 'Popravka nakon saobraćajne nezgode', 'Kompletna restauracija karoserije', 7),
(18, 2, 'Zamena pragova i luka točkova',      'Popravka ili zamena oštećenih pragova', 8);
INSERT INTO radovi (id, kategorija_id, naziv, opis, redosled) VALUES
(19, 3, 'Parcijalno farbanje',            'Farbanje pojedinih delova u originalnoj boji', 1),
(20, 3, 'Kompletno farbanje vozila',      'Nanošenje boje na celokupnu površinu auta', 2),
(21, 3, 'Poliranje i voskanje',           'Obnavljanje sjaja laka i zaštita površine', 3),
(22, 3, 'Uklanjanje ogrebotina',          'Popravka površinskih i dubokih ogrebotina', 4),
(23, 3, 'Keramička zaštita laka',         'Dugotrajna nano-keramička zaštita za sjaj', 5),
(24, 3, 'Farbanje felni',                 'Obnavljanje i promena boje aluminijumskih felni', 6),
(25, 3, 'Priprema površine (kitovanje)',  'Brušenje, kitovanje i grundiranje pre farbanja', 7),
(26, 3, 'Wrap folija',                    'Promena izgleda vozila folijom bez farbanja', 8);
