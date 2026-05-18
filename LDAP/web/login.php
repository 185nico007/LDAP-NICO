<?php
/**
 * Script d'autenticació contra servidor LDAP
 * Projecte: nicodaw.cat
 */

$ldap_server = "localhost";
$base_dn = "dc=nicodaw,dc=local";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // 1. Connexió al servidor
    $ldap_conn = ldap_connect($ldap_server);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // 2. Construïm el DN de l'usuari segons la teva nova estructura
    // Tots pengen de ou=users, independentment del seu grup posix
    $user_dn = "uid=$user,ou=users,$base_dn";

    // 3. Intentem l'autenticació
    if (@ldap_bind($ldap_conn, $user_dn, $pass)) {
        header("Location: success.html");
    } else {
        echo "<script>alert('Error: Usuari o contrasenya incorrectes'); window.location='index.html';</script>";
    }
    
    ldap_close($ldap_conn);
}
?>
