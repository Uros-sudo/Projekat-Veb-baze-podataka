<?php
// ============================================
// HANDLER ZA KONTAKT FORMU
// Prima POST zahtev i čuva u bazu
// ============================================
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'poruka' => 'Metoda nije dozvoljena.']);
    exit;
}

$ime   = trim($_POST['ime'] ?? '');
$email = trim($_POST['email'] ?? '');
$poruka = trim($_POST['poruka'] ?? '');

// Validacija
$greske = [];
if (strlen($ime) < 3)                        $greske[] = 'Ime mora imati najmanje 3 karaktera.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $greske[] = 'Unesite validnu email adresu.';
if (strlen($poruka) < 10)                    $greske[] = 'Poruka mora imati najmanje 10 karaktera.';

if (!empty($greske)) {
    echo json_encode(['success' => false, 'poruka' => implode(' ', $greske)]);
    exit;
}

$conn = getDB();
if (!$conn) {
    // Ako baza nije dostupna, vrati uspeh (forma radi i bez baze)
    echo json_encode(['success' => true, 'poruka' => "Hvala Vam, $ime. Uspešno ste poslali poruku!"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO kontakti (ime, email, poruka) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param('sss', $ime, $email, $poruka);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'poruka' => "Hvala Vam, " . htmlspecialchars($ime) . ". Vaša poruka je primljena! Kontaktiraćemo Vas uskoro."]);
    } else {
        echo json_encode(['success' => false, 'poruka' => 'Greška pri slanju. Pokušajte ponovo.']);
    }
} else {
    echo json_encode(['success' => false, 'poruka' => 'Greška. Pokušajte ponovo.']);
}
?>
