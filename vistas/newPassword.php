<?php

require '../config/config.php';
require '../config/database.php';
$email = isset($_GET['email']) ? $_GET['email'] : "";
$token = isset($_GET['token']) ? $_GET['token'] : "";

$db = new Database();
$connect = $db->conectar();

if (isset($_POST["newPassword"])) {
    $password = $_POST["newPassword"];
    $email = $_POST["retrieveEmail"];
    $password = hash("sha512", $password);

    try {

        $sql = $connect->prepare("UPDATE usuarios SET contrasena_user = ? WHERE correo_user = ?");
        $sql->execute([$password, $email]);
    } catch (PDOException $e) {
        http_response_code(401);
        header("Content-Type: application/json");
        echo json_encode([
            "message" => "Hubo un error"
        ]);
        exit();
    }

    http_response_code(200);
    exit();
}

if ($email == "" || $token == "") {
    header("Location: ./login.php");
    exit();
}

$user = $connect->prepare("SELECT * FROM usuarios WHERE correo_user = ? AND token = ?");
$user->execute([$email, $token]);


if ($user->fetchColumn() <= 0) {
    header("Location: ./login.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/utils.css">
    <link rel="stylesheet" href="../assetsLogin/css/estilos.css">
</head>

<body>

    <main>
        <div class="loader"></div>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-register">
                    <button id="btn__registrarse" onclick="handleComeBack()" style="color:gray">Volver</button>
                </div>
            </div>

            <!--Formulario de Login y registro-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="formulario__login" data-form-get-password="true">
                    <h2>Escribe la nueva contraseña</h2>
                    <input type="email" hidden name="retrieveEmail" value="<?php echo $email ?>">
                    <input data-field-name="password" data-valid="false" type="password" placeholder="Nueva Contraseña" name="newPassword" required="required">
                    <button type="submit" disabled>Cambiar</button>
                </form>

    </main>

    <script src="../assetsLogin/js/script.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });
    </script>

    <script>
        const handleComeBack = () => location.href = "http://localhost/glosajeWebV2/vistas/login.php";
    </script>
    <script type="module">
        import {
            handleValidateFields,
            handleOnBlurFields
        } from "../assetsLogin/js/handleValidateFields.js";
        import {
            useFetch,
            messages
        } from "../assets/js/utils/index.js";

        const form = document.querySelector("[data-form-get-password]");

        form.addEventListener("submit", async (event) => {
            event.preventDefault();
            const data = new FormData(form);

            const {
                request
            } = await useFetch({
                method: "POST",
                url: form.action,
                useLoader: event.target,
                body: data,
                failFetchOptions: {
                    useAbortEndedTime: true,
                    maxTime: 3000
                }
            });

            if (request?.ok) {
                messages.activeGlobalMessageV2({
                    message: "¡Todo listo!",
                    useOkFunction: () => location.href = "./login.php"
                });

            }
        });

        handleValidateFields(form);

        form.querySelectorAll("[data-field-name='password']").forEach(element => {
            return handleOnBlurFields(element);
        });
    </script>
</body>

</html>