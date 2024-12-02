<?php 

/**
 * Inicia la sesión de usuario y requiere la conexión a la base de datos. 
 * Verifica si las variables de sesión username y password están vacías, 
 * en cuyo caso redirige a la página de inicio con un parámetro de alerta.
 */
session_start();
require "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<script>
            alert('Token de sesión inválido, serás redirigido al inicio de sesión');
            setTimeout(function() {
                window.location.href = '../../login.html';
            }, 1500);
          </script>";
    exit();
} else{
    /**
     * Comprueba si se ha enviado el formulario para cambiar la contraseña, 
     * obtiene las contraseñas antigua, nueva y de confirmación, las encripta con MD5,
     * obtiene el ID de usuario de la sesión, consulta la contraseña actual de la BD,
     * compara con la ingresada, si no coincide redirecciona con mensaje de error,
     * si coincide, compara las nuevas contraseñas, si no coinciden redirecciona con error,
     * si todo está correcto, actualiza la contraseña en la BD y redirecciona con mensaje de éxito.
     */
    if (isset($_POST['Guardar'])) {
        if (isset($_SESSION['id_user'])) {
            $old_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['old_pass'])));
            $new_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['new_pass'])));
            $retype_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['retype_pass'])));

            $id_user = $_SESSION['id_user'];

            $sql = mysqli_query($mysqli, "SELECT password FROM usuarios WHERE id_user=$id_user")
                or die('error' . mysli_error($mysqli));
            $data = mysqli_fetch_assoc($sql);

            if ($old_pass != $data['password']) {
                header("Location: reset.php?alert=1");
            } else {
                if ($new_pass != $retype_pass) {
                    header("Location: reset.php?alert=2");
                } else {
                    $query = mysqli_query($mysqli, "UPDATE usuarios SET password = '$new_pass' WHERE id_user='$id_user'")
                        or die('error' . mysqli_error($mysqli));
                    if ($query) {
                        header("Location: reset.php?alert=3");
                    }
                }
            }
        }
    }
    }
?>