<?php

$ldap_server = "localhost";
$base_dn = "dc=nicodaw,dc=local";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Connexió al servidor
    $ldap_conn = ldap_connect($ldap_server);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // Construïm el DN de l'usuari segons la estructura
    $user_dn = "uid=$user,ou=users,$base_dn";

    //  Intentem l'autenticació
    if (@ldap_bind($ldap_conn, $user_dn, $pass)) {
        header("Location: success.html");
    } else {
        //Si l'usuari es incorrecte surt aixo
        echo "<script>alert('Error: Usuari o contrasenya incorrectes'); window.location='index.html';</script>";
    }
    
    ldap_close($ldap_conn);
}
?>
