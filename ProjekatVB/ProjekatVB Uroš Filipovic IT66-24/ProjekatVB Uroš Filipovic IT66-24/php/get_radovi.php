<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

$slug = trim($_GET['slug'] ?? '');

if (empty($slug)) {
    echo json_encode(['success' => false, 'poruka' => 'Slug nije prosledjen.']);
    exit;
}

$conn = getDB();
if (!$conn) {
    echo json_encode(['success' => false, 'poruka' => 'Baza nije dostupna.']);
    exit;
}

$stmt = $conn->prepare(
    "SELECT r.naziv, r.opis
     FROM radovi r
     INNER JOIN kategorije k ON r.kategorija_id = k.id
     WHERE k.slug = ?
     ORDER BY r.redosled ASC"
);

if (!$stmt) {
    echo json_encode(['success' => false, 'poruka' => 'Greska pri upitu.']);
    exit;
}

$stmt->bind_param('s', $slug);
$stmt->execute();
$rezultat = $stmt->get_result();

$radovi = [];
while ($red = $rezultat->fetch_assoc()) {
    $radovi[] = [
        'naziv' => $red['naziv'],
        'opis'  => $red['opis'],
    ];
}

echo json_encode(['success' => true, 'radovi' => $radovi]);
?>
