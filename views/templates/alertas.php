<!-- INICIO Iteración de alertas -->
<?php

    foreach($alertas as $key => $mensajes):
        
        foreach($mensajes as $mensaje):

?>

    <!-- INICIO Estructura HTML -->

            <div class="alerta <?php echo $key; ?>" >

                <?php echo $mensaje; ?>

            </div>

    <!-- FIN Estructura HTML -->
<!-- FIN Iteración de alertas -->
<?php
        endforeach;
        
    endforeach;

    $s = $_GET['s'] ?? null;
    $m = $_GET['m'] ?? null;

    if($s && $m){

        echo "<p class='alerta " . $s ."'>". $m ."</p>";
        
        }

?>

