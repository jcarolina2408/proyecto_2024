<?php
include "../modelo/modelo_talleres.php";
$instancia = new talleres();
$r=$instancia->registro($_POST);

if($r===1){
    echo "<script>
                  location.href='admi_consultar_talleres.php'  
    </script>";
}

else if (Str_Contains("$r",1045)) {
    echo "se desconecto el servidor, comuniquese con el admin";

}
else if(str_Contains ("$r",1062)){
    echo "el nombre del producto ya existe, modifiquelo";
}

else if(str_Contains ("$r",2002)){
    echo "La conexion cayo";
}

else{
    echo $r;
}


?>