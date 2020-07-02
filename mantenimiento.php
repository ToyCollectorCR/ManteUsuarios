<?php
 //iniciar la sessión
 session_start();

 // Acciones del metodo POST
 if(isset($_POST['accion'])){
     switch ($_POST['accion'])
     {
         case 'Guardar':
                guardarUsuario();
                header('location:index.php');
                break;
         case 'Guardar Cambios':
                guardarEditar();
                header('location:index.php');
                break;
     }  
 }
 
  // Acciones del metodo GET
 if(isset($_GET['accion'])){  
     switch ($_GET['accion'])
     {
         case 'Eliminar':
                eliminarUsuario();
                header('location:index.php');
                break;
         case 'EliminarSesion':    
                eliminarSesion();
                header('location:index.php');
                break;
         case 'Editar':
                editarUsuario();
                header('location:index.php');
                break;
     }  
 }
 
     
 // Sección de funciones
 
  // Validar si ya existe la lista en la sessión
 // si no, la creamos y la subimos a la sessión
 function obtenerListaUsuarios(){
    if(isset($_SESSION['listaUsuarios'])){
       $listaUsuarios = $_SESSION['listaUsuarios'];
    }else{
       $listaUsuarios = array();     
       $_SESSION['listaUsuarios'] = $listaUsuarios;
    }   
    return $listaUsuarios;
 }

 function guardarUsuario(){
     $nombre = $_POST['nombre'];
     $correo = $_POST['correo'];
     $direccion = $_POST['direccion'];
     $telefono = $_POST['telefono'];
     
     $usuario = array("nombre"=>$nombre,"correo"=>$correo,"direccion"=>$direccion,"telefono"=>$telefono);
     $lista = obtenerListaUsuarios();
     array_push($lista,$usuario);
     $_SESSION['listaUsuarios'] = $lista;     
 }
 
 function obtenerUsuarioEditar(){
     if(isset($_SESSION['usuarioEditar'])){
       $usuarioEditar = $_SESSION['usuarioEditar'];
    }else{
       $usuarioEditar = array();     
       $_SESSION['usuarioEditar'] = $usuarioEditar;
    }   
    return $usuarioEditar;
 }
 
 function editarUsuario(){
     $posicion = $_GET['posicion'];
     $lista = obtenerListaUsuarios();
     $usuarioEditar = $_SESSION['usuarioEditar'];
     $usuarioEditar = $lista[$_GET['posicion']];
     array_push($usuarioEditar, $_GET ['posicion']); //Me incluye una ultima pocision en el arreglo y tiene el valor de donde esta!
     $_SESSION['usuarioEditar'] = $usuarioEditar;
     //var_dump($usuarioEditar);
 }
 
 function guardarEditar(){
     $nombre = $_POST['nombre'];
     $correo = $_POST['correo'];
     $direccion = $_POST['direccion'];
     $telefono = $_POST['telefono'];
     
     $lista = obtenerListaUsuarios();
     $posicionUsuario = obtenerUsuarioEditar();
     
     //$usuario = array("nombre"=>$nombre,"correo"=>$correo,"direccion"=>$direccion,"telefono"=>$telefono);
     //array_replace($lista[$posicionUsuario['0']],$usuario);
    
     
     $lista[$posicionUsuario[0]]['nombre'] = $nombre;
     $lista[$posicionUsuario[0]]['correo']  = $correo;
     $lista[$posicionUsuario[0]]['direccion']  = $direccion;
     $lista[$posicionUsuario[0]]['telefono']  = $telefono;
     $_SESSION['listaUsuarios'] = $lista;
     
     unset($_SESSION['usuarioEditar']);
 }



 function eliminarUsuario(){
     $posicion = $_GET['posicion'];
     $lista = obtenerListaUsuarios();
     unset($lista[$posicion]);
     $_SESSION['listaUsuarios'] = $lista;
 }


 function eliminarSesion(){
     unset($_SESSION['listaUsuarios']);
     session_unset();
     session_destroy();
 }

?>