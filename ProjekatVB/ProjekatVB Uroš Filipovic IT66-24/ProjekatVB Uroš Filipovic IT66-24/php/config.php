<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      
define('DB_PASS', '');          
define('DB_NAME', 'autoservis_filipovic');

function getDB() {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            return null;
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
function brojacPoseta() {
    $conn = getDB();
    if (!$conn) return 0;

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $check = $conn->prepare("SELECT id FROM posete WHERE ip_adresa = ? AND datum_posete > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    if ($check) {
        $check->bind_param('s', $ip);
        $check->execute();
        if ($check->get_result()->num_rows === 0) {
            $ins = $conn->prepare("INSERT INTO posete (ip_adresa) VALUES (?)");
            if ($ins) { $ins->bind_param('s', $ip); $ins->execute(); }
        }
    }

    $res = $conn->query("SELECT COUNT(*) as ukupno FROM posete");
    if ($res) {
        return $res->fetch_assoc()['ukupno'] ?? 0;
    }
    return 0;
}

function sanitize($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}
?>
