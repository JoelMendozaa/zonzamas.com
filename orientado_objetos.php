<?php

    require_once "general.php";

    ob_start();

    $form = Form::getInstance();

    echo Plantilla::header("CIFP Zonzamas");

    define('TEXTO_ERROR', '<em class="error_campo_texto">El campo es invalido</em> <br />');
    define('LIMITE_SCROLL', '5');

    $html_salida = '';
    $oper = $_REQUEST['oper'];
    $errores = [];

    function resultados_busqueda(){
        $form = Form::getInstance();

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
        $resultado = BBDD::query($sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $listado_usuarios .= "
                    <tr>
                        <th scope=\"row\">
                            <a href=\"./orientado_objetos.php?oper=update&id={$fila['id']}\" class=\"btn btn-primary\">Actualizar</a>
                            <a onclick=\"if(confirm('Cuidado, estás tratando de eliminar el usuario: {$fila['nombre']}')) location.href = './orientado_objetos.php?oper=delete&id={$fila['id']}';\" class=\"btn btn-danger\">Eliminar</a>
                        </th>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['email']}</td>
                        <td>{$fila['edad']}</td>
                    </tr>
                ";
            }
        } 
        else {
            $listado_usuarios = '<tr><td colspan="5">No hay resultados</td></tr>';
        }

        if($pagina){
            $pagina_anterior = '<li class="page-item"><a class="page-link" href="./orientado_objetos.php?pagina='. ($pagina - 1) .'"">Anterior</a></li>';
        }
        $listado_usuarios .= '
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    '. $pagina_anterior .'
                    <li class="page-item"><a class="page-link" href="./orientado_objetos.php?pagina='. ($pagina + 1) .'">Siguiente</a></li>
                </ul>
            </nav>
            <div class="alta">
                <a href="./orientado_objetos.php?oper=create" class="btn btn-success">Alta de usuarios</a>
            </div>
        ';

        return $listado_usuarios;
    }


    function recuperar(){
        $form = Form::getInstance();

        $id =  $form->val['id'];

        $sql = "
            SELECT * 
            FROM   usuarios
            WHERE  id = '{$id}'
        ";

        $resultado = BBDD::query($sql);


        if ($resultado && $fila = $resultado->fetch_assoc()){
            $form->elementos['nombre']->value = $fila['nombre'];
            $form->elementos['email']->value = $fila['email'];
            $form->elementos['edad']->value = $fila['edad'];
        }
    }


    switch($oper)
    {
        case 'create':


            if (!empty($form->val['paso']))
            {
                $errores = $form->validar();



                if(!$form->cantidad_errores)
                {
                    if(!existeUsuario())
                    {
                        insertar();
                        $form->activeDisable();
                    }
                    else
                    {
                        $form->duplicado = True;
                    }

                }
            }

            $html_salida .= cabecera('alta');
            $html_salida .= formulario($oper,$errores);

        break;
        case 'update':

            inicializar();


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

            ob_clean();

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


    function inicializar(){
        $form = Form::getInstance();
     
     
        $form->accion('orientado_objetos.php');
     
     
        $paso = new Hidden('paso');
        $paso->value = 1;
     
     
        $oper = new Hidden('oper');
        $id = new Hidden('id');       
     
     
        $nombre = new Input('nombre', ['placeholder' => 'Nombre del usuario...', 'validar' => true, 'ereg' => EREG_TEXTO_100_OBLIGATORIO]);
        $email = new Input('email', ['placeholder' => 'Email del usuario...', 'validar' => true]);
        $edad = new Input('edad', ['placeholder' => 'Edad del usuario', 'validar' => true, 'ereg' => EREG_TEXTO_150_OBLIGATORIO]);
     
     
        $form->cargar($paso);
        $form->cargar($oper);
        $form->cargar($id);
        $form->cargar($nombre);
        $form->cargar($email);
        $form->cargar($edad);
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


    function formulario($oper,$errores = []) {

        $form = Form::getInstance();

        $id = $form->val['id'];

        $botones_extra = '';
        $mensaje_exito = False;
        if($form->val['paso'] && $form->cantidad_errores == 0){
            $mensaje_exito = True;
            $botones_extra = '<a href="./orientado_objetos.php?oper=create" class="btn btn-primary">Nuevo usuario</a>';

            if($oper == 'update')
                $botones_extra .= ' <a href="./orientado_objetos.php?oper=update&id='. $id .'" class="btn btn-primary">Editar</a>';
        
        }

        $html_formulario = $form->pintar(['botones_extra' => $botones_extra,'exito' =>  $mensaje_exito]);

        return $html_formulario;
    }
    
    function existeUsuario($id='') {
        $form = Form::getInstance();


        if (   !empty($form->val['nombre']) 
            && !empty($form->val['email'])
            && !empty($form->val['edad'])
        )
        {
            $andid = '';
            if (!empty($id))
                $andid = "AND id <> '{$id}' ";


            $sql = "
                SELECT nombre
                FROM   usuarios
                WHERE  nombre      = '{$form->val['nombre']}'
                AND    email = '{$form->val['email']}'
                AND    edad       = '{$form->val['edad']}'
                {$andid}
            ";

            $resultado = BBDD::query($sql);
        }

        return $resultado->num_rows;
    }


    function eliminar(){

        $id = Form::getInstance()->val['id'];

        if (!empty($id)){
            $sql = "
                DELETE FROM usuarios
                WHERE id = '{$id}'
            ";
            $resultado = BBDD::query($sql);
        }
    }





    function actualizar(){

        $form = Form::getInstance();

        if (!empty($form->val['id']))
        {
            $sql = "
                UPDATE usuarios

                SET  nombre      = '{$form->val['nombre']}'
                    ,email = '{$form->val['email']}'
                    ,edad       = '{$form->val['edad']}'

                    ,ip_ult_mod   = '{$_SERVER['REMOTE_ADDR']}'
                    ,fecha_ult_mod = CURRENT_TIMESTAMP

                WHERE id = '{$form->val['id']}'

            ";
            $resultado = BBDD::query($sql);
        }
    }
    


    function insertar(){
        $form = Form::getInstance();


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

        $resultado = BBDD::query($sql);
    }
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