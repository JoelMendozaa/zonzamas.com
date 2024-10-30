<?php

    require_once "general.php";


    $servidor   = 'localhost';
    $usuario    = 'joel';
    $contrasena = 'Jomedama2024!';
    $base_datos = 'gestion_usuarios';

    $conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

    if (!$conexion){
        die("Error de conexión: " . mysqli_connect_error());
    }

    echo Plantilla::header("CIFP Zonzamas");


    define('TEXTO_ERROR', '<em class="error_campo_texto">El campo es invalido</em> <br />');
    define('LIMITE_SCROLL', '5');

    $html_salida = '';

    $oper = $_REQUEST['oper'];

    $errores = [];

    switch($oper)
    {
        case 'create':

            if (!empty($_POST['paso']))
            {
                $errores = validar_campos();

                if(count($errores) == 0)
                {
                    insertar();
                }
            }


            $html_salida .= cabecera('alta');
            $html_salida .= formulario($oper,$errores);

        break;
        case 'update':

            if (empty($_POST['paso']))
            {
                //Cargar los datos
                recuperar();
            }
            else
            {
                $errores = validar_campos();

                if(count($errores) == 0)
                {
                    actualizar();
                }
            }

            $html_salida .= cabecera('actualizar');
            $html_salida .= formulario($oper,$errores);

        break;
        case 'delete':
            eliminar();

            header("location: ./orientado_objetos.php");
            exit(0);

        break;
        default:

            $html_salida .= cabecera();

            $html_salida .= resultados_busqueda();
            

        break;
    }


    function validar_campos()
    {
        $errores = [];

        $campos = ['nombre', 'email', 'edad'];


        foreach($campos as $campo)
        {
            if(empty($_POST[$campo]))
            {
                $errores[$campo]['error']       = True;
                $errores[$campo]['desc_error']  = TEXTO_ERROR;
                $errores[$campo]['class_error'] = 'error_campo_texto';
            }
        }



        return $errores;

    }


    function cabecera($usuarios_seccion='')
    {
        if(empty($usuarios_seccion))
        {
            $breadcrumb = "<li class=\"breadcrumb-item\">usuarios</li>";
        }
        else
        {
            $breadcrumb = "
                <li class=\"breadcrumb-item\"><a href=\"./orientado_objetos.php\">orientado_objetos</a></li>
                <li class=\"breadcrumb-item active\" aria-current=\"page\">{$usuarios_seccion}</li>
            ";
        }


        return "
            <nav aria-label=\"breadcrumb\">
                <ol class=\"breadcrumb\">
                    <li class=\"breadcrumb-item\"><a href=\"/\">Zonzamas</a></li>
                    {$breadcrumb}
                </ol>
            </nav>
        ";
    }


    function formulario($oper,$errores = [])
    {


        $id = $_REQUEST['id'];

        $mensaje_exito = $botones_extra = $disabled = '';
        if($_POST['paso'] && count($errores) == 0)
        {
            $mensaje_exito = '<div class="exito">Operación realizada con éxito</div>';
            $disabled = 'disabled';
            $botones_extra = '<a href="./orientado_objetos.php?oper=create" class="btn btn-primary">Nuevo libro</a>';

            if($oper == 'update')
                $botones_extra .= ' <a href="./orientado_objetos.php?oper=update&id='. $id .'" class="btn btn-primary">Editar</a>';
        
        }


        $html_formulario = "

            <form method=\"POST\" action=\"orientado_objetos.php\">
                <input type=\"hidden\" name=\"paso\" value=\"1\" />
                <input type=\"hidden\" name=\"oper\" value=\"{$oper}\" />
                <input type=\"hidden\" name=\"id\" value=\"{$id}\" />

                {$mensaje_exito}

                <label class=\"". $errores['nombre']['class_error'] ." form-label\" for=\"nombre\">Nombre:</label>
                <input {$disabled} class=\"form-control\" type=\"text\" id=\"nombre\" name=\"nombre\" value=\"{$_POST['nombre']}\" placeholder=\"Nombre del libro...\">
                ". $errores['nombre']['desc_error'] ."
                <br />

                <label class=\"". $errores['email']['class_error'] ." form-label\" for=\"email\">Descripción:</label>
                <textarea {$disabled} class=\"form-control\" id=\"email\" email=\"email\" placeholder=\"Descripción del libro...\">{$_POST['email']}</textarea>
                ". $errores['email']['desc_error'] ."
                <br />

                <label class=\"". $errores['edad']['class_error'] ." form-label\" for=\"edad\">edad:</label>
                <input {$disabled} class=\"form-control\" type=\"text\" id=\"edad\" number=\"edad\" value=\"{$_POST['edad']}\" placeholder=\"edad del libro...\"> 
                ". $errores['edad']['desc_error'] ."
                <br />
                <div style=\"text-align:right\">
                    {$botones_extra}
                    <input {$disabled} type=\"submit\" class=\"btn btn-primary\" value=\"Enviar\" />
                </div>
                

            </form>
        
        ";

        return $html_formulario;

    }

    function eliminar()
    {
        global $conexion;

        if (!empty($_GET['id']))
        {
            $sql = "
                DELETE FROM usuarios
                WHERE id = '{$_GET['id']}'
            ";
            $resultado = $conexion->query($sql);
        }
    }

    function recuperar()
    {
        global $conexion;

        $id =  $_REQUEST['id'];

        $sql = "
            SELECT * 
            FROM   usuarios
            WHERE  id = '{$id}'
        ";

        $resultado = $conexion->query($sql);


        $fila = $resultado->fetch_assoc();


        $_POST['nombre']      = $fila['nombre'];
        $_POST['email'] = $fila['email'];
        $_POST['edad']       = $fila['edad'];

    }

    function actualizar()
    {
        global $conexion;

        if (!empty($_POST['id']))
        {
            $sql = "
                UPDATE usuarios

                SET    nombre      = '{$_POST['nombre']}'
                    ,email = '{$_POST['email']}'
                    ,edad       = '{$_POST['edad']}'

                WHERE id = '{$_POST['id']}'

            ";
            $resultado = $conexion->query($sql);
        }
    }


    function insertar()
    {
        global $conexion;


        $sql = "
            INSERT INTO usuarios
            (
                nombre
               ,email
               ,edad

            )
            VALUES
            (   
                 '". $_POST['nombre'] ."'
                ,'". $_POST['email'] ."'
                ,'". $_POST['edad'] ."'

                ,'". $_SERVER['REMOTE_ADDR'] ."'
            );
        ";

        $resultado = $conexion->query($sql);
    }



    function resultados_busqueda()
    {
        global $conexion;


        $listado_usuarios = '
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Edad</th>
                </tr>
            </thead>
            <tbody>
        
        ';

        $limite = LIMITE_SCROLL;

        $pagina = $_GET['pagina'];

        $offset = $pagina * $limite;

        $sql = "SELECT * FROM usuarios LIMIT {$limite} OFFSET {$offset}";

        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) 
        {
            while ($fila = $resultado->fetch_assoc()) 
            {

                $listado_usuarios .= "
                    <tr>
                        <th scope=\"row\">
                            <a href=\"./orientado_objetos.php?oper=update&id={$fila['id']}\" class=\"btn btn-primary\">Actualizar</a>
                            <a onclick=\"if(confirm('Cuidado, estás tratando de eliminar el libro: {$fila['nombre']}')) location.href = '.orientado_objetos.php?oper=delete&id={$fila['id']}';\" class=\"btn btn-danger\">Eliminar</a>
                        </th>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['email']}</td>
                        <td>{$fila['edad']}</td>
                    </tr>
                ";
            }
        } 
        else 
        {
            $listado_usuarios = '<tr><td colspan="5">No hay resultados</td></tr>';
        }

        if($pagina)
            $pagina_anterior = '<li class="page-item"><a class="page-link" href="./orientado_objetos.php?pagina='. ($pagina - 1) .'"">Anterior</a></li>';

        $listado_usuarios .= '
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    '. $pagina_anterior .'
                    <li class="page-item"><a class="page-link" href="./orientado_objetos.php?pagina='. ($pagina + 1) .'">Siguiente</a></li>
                </ul>
            </nav>
        ';


        return $listado_usuarios;


    }


    $conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <title>Usuarios</title>
</head>
<body>
    <?php echo $html_salida; ?>
</body>
</html>

<?php

    echo Plantilla::footer();

?>