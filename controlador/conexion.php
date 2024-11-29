<?php
     class Cconexion
    {

        static function ConexionBD($nTabla)
        {
            
                // Establecer la conexión a la base de datos MySQL
                // mysqli_connect("servidor", "usuario", "clave", "base de datos")

                $conn = new mysqli("localhost", "root", "", "lopez_serrano");
                // Si la conexión fue exitosa, se muestra un mensaje de éxito
            
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, nombre, tipo , descripcion FROM $nTabla";
                $result = $conn->query($sql);

                $conn->close();
                return $result;
        } 




    }
?>