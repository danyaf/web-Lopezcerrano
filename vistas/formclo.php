<?php
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
include('../controlador/db.php');

// Cargar la lista de imagenes traidas desde la tabla clothing
$sql = "SELECT * FROM clothing ";
$result = $conn->query($sql);


// Crear imagen 
if (isset($_POST['create'])) {
   $descripcion= $_POST['descripcion'];

        if (subirImg() === true) {
            $sql = "INSERT INTO clothing (nombre, descripcion, tipo) VALUES ('$fileNom', '$descripcion', '$fileExt')";
            if($conn->query($sql) === TRUE){
                echo "<div class='alert alert-success'>New record created successfully.</div>";
                //Recargar la lista ya sin los elementos eliminados
                $sql = "SELECT * FROM clothing ";
                $result = $conn->query($sql);
                reiniValor();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                reiniValor();
            }
        } 

}

//Metodo para subir imagen a la carpeta uploadc
function subirImg(){
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    global $fileExt;
    global $fileNom;

    // Obtener la extensión del archivo
    $fileExt = strtolower(end(explode('.', $fileName)));
    $arrayName = (explode('.', $fileName));
    $fileNom = $arrayName[0];
    // Tipos de archivos permitidos (puedes agregar más)
    $allowed = array('jpg', 'jpeg', 'png');

    // Verificar si el tipo de archivo es permitido
    if (in_array($fileExt, $allowed)) {
        // Verificar si no hubo errores al subir el archivo
        if ($fileError === 0) {
            // Crear un nombre único para la imagen
            $fileDestination = '../uploadc/'  . $fileName;

            // Mover la imagen desde el directorio temporal al destino final
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                echo "<div class='alert alert-success'>La imagen se ha subido correctamente.</div>";
                return true;
            } else {
                reiniValor();
                echo "<div class='alert alert-danger'>Hubo un error al mover la imagen.</div>";
            }
        } else {
            reiniValor();
            echo "<div class='alert alert-danger'>Hubo un error al subir la imagen.</div>";
        }
    } else {
        reiniValor();
        echo "<div class='alert alert-danger'>Tipo de archivo no permitido. Solo se aceptan imágenes JPG, JPEG, PNG.</div>";
    }
    return false;
}



// Eliminar
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
        if(eliminarImg() === true){
            $sql = "DELETE FROM clothing WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>Record deleted successfully</div>";
                //Recargar la lista ya sin los elementos eliminados
                $sql = "SELECT * FROM clothing ";
                $result = $conn->query($sql);
                reiniValor();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                reiniValor();
            }
        }
}

function eliminarImg(){
    $imageToDelete = $_GET['nomimg'];
    $imagePath = '../uploadc/' . $imageToDelete;

    // Verificar si el archivo existe
    if (file_exists($imagePath)) {
        // Eliminar el archivo
        if (unlink($imagePath)) {
            echo "<div class='alert alert-success'>La imagen se ha eliminado correctamente.</div>";
            return true;
        } else {
            echo "<div class='alert alert-danger'>Hubo un problema al eliminar la imagen.</div>";
            reiniValor();
            return false;
        }
    } else {
        echo "<div class='alert alert-danger'>La imagen no existe.</div>";
        reiniValor();
        return false;
    }
}

function reiniValor(){

    $_POST = [];
    $_GET = [];
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD FOTOS</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <h2 class="my-4">SUBIR IMAGEN</h2>
    



    <!-- Formulario para crear o actualizar imagen en clothing -->
    <form action="" method="POST" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="image">Seleccionar imagen:</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>

        <div class="form-group">
            <label for="descripcion">descripcion:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>

        <button type="submit" class="btn btn-primary" name="create">Crear Imagen</button>
    </form>

    <hr>

    <h3>Lista de la tabla </h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>IMG</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>TIPO</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src=<?php echo '../uploadc/'.$row["nombre"].'.'.$row["tipo"].' '  ?> width="40" height="40"></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td>
                        <a href="formclo.php?delete=<?php echo $row['id']; ?>&nomimg=<?php echo $row['nombre'].".".$row['tipo']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
