<?php
// Generate password hash yang benar
$password = "admin12345";
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Password Hash Generator</h2>";
echo "<p><strong>Password:</strong> $password </p>";
echo "<p><strong>Hash:</strong> $hash</p>";
echo "<hr>";

// Test verify
echo "<h3>Test Verification:</h3>";
$test_hash = '$2y$10$EqLpxaHQXxBR8xKHXZbDW.qPZPITfFJXBDiZQvLLVjqBhPmNGCPb.';
if (password_verify("12345", $test_hash)) {
    echo "<p style='color: green;'>✓ Hash VALID - password 12345 cocok!</p>";
} else {
    echo "<p style='color: red;'>✗ Hash TIDAK VALID - gunakan hash baru di atas!</p>";
}
?>