<!DOCTYPE html>
<html lang="en">

<head>
    <!-- DATATABLES -->
    <!--  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link href="../css/lightbox.min.css" rel="stylesheet" />
    <link href="../css/lightbox.css" rel="stylesheet" />
    <style>
        th,
        td {
            padding: 0.4rem !important;
        }       
        .padre{
        text-align: center;
        width:100%;
        
        }  
    </style>
</head>

<body>

    <?php
        include_once ("../controlador/conexion.php");
        $result =  Cconexion::ConexionBD("clothing");
       
        if ($result->num_rows > 0) {
    ?>

        <table id="tablax" style="width:100%">
            <thead>
                <th>
                    
                </th>
            </thead>
                <tbody>
                    
            
                    <?php   while($row = $result->fetch_assoc()) { ?>
                        <tr> 
                            <td>
                        
                                <div class="padre">
                                <a class="example-image-link mi-clase" href=<?php echo '../uploadc/'.$row["nombre"].'.'.$row["tipo"].' '  ?>
                                    data-lightbox="example-set" data-title=<?php echo $row["nombre"] ?>><img
                                        class="example-image" width=60% height="60%"
                                        src=<?php echo '../uploadc/'.$row["nombre"].'.'.$row["tipo"].' '  ?> alt="" /></a>
                                </div>
                                <div style="text-align: center;">
                                <strong> <?php echo str_replace("_", " ", $row["nombre"].'<br>'); ?> </strong>
                                <?php echo $row["descripcion"] ?>
                                </div> 
                         
                                        
                            </td>
                        </tr>
                    <?php } ?>
            </tbody>
                </table>
              

 <?php } 
    
    else {
        echo "0 results";
    } ?>


  


    <!-- JQUERY -->
    <script src="../js/lightbox-plus-jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
    </script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('#tablax').DataTable({
                language: {
                    processing: "Tratamiento en curso...",
                    search: "Buscar&nbsp;:",
                    lengthMenu: "Group by _MENU_ items",
                    info: "",
                    infoEmpty: "No existen datos.",
                    infoFiltered: "(filtrado de _MAX_ elementos en total)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron datos con tu busqueda",
                    emptyTable: "No hay datos disponibles en la tabla.",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Ultimo"
                    },
                    aria: {
                        sortAscending: ": active para ordenar la columna en orden ascendente",
                        sortDescending: ": active para ordenar la columna en orden descendente"
                    }
                },
                scrollY: 720,
                lengthMenu: [
                    [3, 10, -1],
                    [3, 10, "All"]
                ],
            });
        });
    </script>



</body>

</html>
