<?php

/**
 * Punto de entrada cuando el hosting no permite apuntar el dominio solo a /public.
 * Lo ideal en producción es configurar el DocumentRoot en public/.
 */

require __DIR__.'/public/index.php';
