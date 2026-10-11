<?php

/*
|--------------------------------------------------------------------------
| Contenido del sitio — Arquitectura y Construcciones WE
|--------------------------------------------------------------------------
|
| Todo el texto, contactos y obras de la página principal viven aquí.
| Para agregar una obra nueva: copia su foto en public/images/obras y
| agrega un elemento al arreglo 'obras' con la categoría correspondiente.
|
*/

return [

    /*
    | Monograma WE (favicon, barra, pie y datos estructurados). Cambia solo aquí.
    */
    'marca' => [
        // PNG con fondo transparente (monograma 3D aislado)
        'monograma' => 'images/logo-monograma-we.png',
        'monograma_alt' => 'Monograma WE — Arquitectura y Construcciones',
        // Opacidad marca de agua (0–1). Variables CSS --ma-* en app.css
        'agua_centro' => 0.11,
        'agua_esquina' => 0.085,
        'agua_esquina_oscuro' => 0.12,
    ],

    'empresa' => [
        'nombre' => 'Arquitectura y Construcciones WE',
        'eslogan' => 'Diseño, construcción e interventoría de obras en Medellín y Antioquia.',
        'ciudad' => 'Medellín, Antioquia',
        'nit' => '901.782.903-9',
        'email' => env('SITIO_EMAIL', 'arquitecturayconstruccioneswe@gmail.com'),
        'telefono' => '+573168744870',
        'telefono_visible' => '316 874 4870',
        'direccion' => 'Calle 41 #80D-31',
        'mapa' => 'https://www.google.com/maps/search/?api=1&query=Calle+41+%2380D-31+Medell%C3%ADn',
        'whatsapp' => '573168744870',
    ],

    'seo' => [
        'titulo' => 'Arquitectura y Construcciones WE | Diseño, construcción e interventoría en Antioquia',
        'descripcion' => 'Arquitectura y Construcciones WE: diseño arquitectónico, construcción e interventoría de obras civiles, redes de acueducto y alcantarillado, casas de campo y fachadas en Medellín y Antioquia.',
        'og_descripcion' => 'Diseño, construcción e interventoría de obras en Antioquia.',
        'imagen' => 'images/og-we.jpg',
        'color' => '#0e1b3d',
        'especialidades' => ['Diseño arquitectónico', 'Construcción', 'Interventoría', 'Redes de acueducto y alcantarillado', 'Trabajos en altura'],
    ],

    'menu' => [
        'servicios' => 'Servicios',
        'proceso' => 'Proceso',
        'destacados' => 'Destacados',
        'proyectos' => 'Proyectos',
        'contacto' => 'Contacto',
    ],

    'hero' => [
        'titulo' => 'Ingeniería y arquitectura que transforman espacios.',
        'texto' => 'Diseñamos, construimos y supervisamos obras en Antioquia con calidad en cada decisión y honestidad en cada proceso.',
        'imagen' => ['src' => 'images/casa-reservas-del-lago.webp', 'w' => 1422, 'h' => 1068, 'alt' => 'Casa de campo de dos niveles con piscina, diseñada y construida por WE en Sopetrán'],
        'cota_h' => 'Fachada principal',
        'cota_v' => '2 niveles',
        'pie_titulo' => 'Casa de campo, Reservas del Lago',
        'pie_texto' => 'Diseño y construcción en Sopetrán',
    ],

    // Cifras con contador animado: prefijo + número + unidad
    'cifras' => [
        ['prefijo' => '', 'n' => 14, 'unidad' => 'km', 'texto' => 'de red de aducción en PEAD en Anzá'],
        ['prefijo' => '+', 'n' => 500, 'unidad' => 'm', 'texto' => 'de red principal PEAD 315 mm en Sabaneta'],
        ['prefijo' => '', 'n' => 11, 'unidad' => null, 'texto' => 'municipios de Antioquia con obras nuestras'],
        ['prefijo' => '', 'n' => 3, 'unidad' => null, 'texto' => 'servicios: diseño, construcción e interventoría'],
    ],

    'cintas' => [
        'b' => ['Diseño arquitectónico', 'Construcción', 'Interventoría', 'Redes de acueducto PEAD', 'Alcantarillado', 'Casas de campo', 'Trabajos en altura'],
        'a' => ['Arquitectura y Construcciones WE', 'Obra en curso', 'Antioquia', 'Arquitectura y Construcciones WE', 'Obra en curso', 'Antioquia'],
    ],

    'servicios' => [
        'titulo' => 'Un solo equipo, de la idea a la entrega',
        'texto' => 'Contrata cada servicio por separado o los tres juntos. Acompañamos tu proyecto en cada etapa para que tu inversión esté protegida.',
        'items' => [
            ['titulo' => 'Diseño', 'texto' => 'Proyectos funcionales, modernos y pensados para el lugar y para quien los va a habitar.', 'img' => 'images/servicio-diseno.webp', 'w' => 732, 'h' => 780, 'alt' => 'Planos y bocetos de diseño arquitectónico'],
            ['titulo' => 'Construcción', 'texto' => 'Materializamos tu proyecto con calidad, responsabilidad y precisión técnica.', 'img' => 'images/servicio-construccion.webp', 'w' => 810, 'h' => 864, 'alt' => 'Armado de acero de refuerzo en obra'],
            ['titulo' => 'Interventoría', 'texto' => 'Velamos por la calidad, los tiempos y los recursos de tu obra de principio a fin.', 'img' => 'images/servicio-interventoria.webp', 'w' => 771, 'h' => 822, 'alt' => 'Ingenieros revisando planos en obra'],
        ],
    ],

    'proceso' => [
        'titulo' => 'Un proceso claro, sin sorpresas',
        'texto' => 'Sabes qué sigue en cada momento y cuánto va a costar antes de empezar.',
        'pasos' => [
            ['titulo' => 'Consulta', 'texto' => 'Escuchamos tu necesidad, visitamos el lugar y definimos el alcance.'],
            ['titulo' => 'Propuesta', 'texto' => 'Te entregamos presupuesto y cronograma detallados por escrito.'],
            ['titulo' => 'Ejecución', 'texto' => 'Diseñamos y construimos con control técnico en cada etapa.'],
            ['titulo' => 'Entrega', 'texto' => 'Revisamos contigo cada detalle y entregamos la obra terminada.'],
        ],
    ],

    'destacados' => [
        'titulo' => 'Obras que hablan por nosotros',
        'texto' => 'Tres proyectos que muestran el alcance de nuestro trabajo: espacio público, vivienda e interventoría.',
        'items' => [
            ['titulo' => 'Parque Urbano de Támesis', 'tipo' => 'Diseño', 'lugar' => 'Támesis, Antioquia', 'texto' => 'Espacio público con zonas de juego, senderos y áreas verdes pensado para la comunidad.', 'img' => 'images/parque-tamesis-render.webp', 'w' => 1500, 'h' => 843, 'alt' => 'Render del parque urbano de Támesis con senderos y zonas verdes'],
            ['titulo' => 'Casa de campo, Reservas del Lago', 'tipo' => 'Diseño y construcción', 'lugar' => 'Sopetrán, Antioquia', 'texto' => 'Arquitectura contemporánea de dos niveles, con amplios ventanales y piscina integrada al paisaje.', 'img' => 'images/casa-reservas-del-lago.webp', 'w' => 1422, 'h' => 1068, 'alt' => 'Casa de campo Reservas del Lago en Sopetrán'],
            ['titulo' => 'Unidad Residencial Providencia', 'tipo' => 'Interventoría', 'lugar' => 'Medellín', 'texto' => 'Interventoría del mantenimiento de fachada con calidad, cumplimiento y transparencia en cada etapa.', 'img' => 'images/unidad-providencia.webp', 'w' => 1500, 'h' => 966, 'alt' => 'Edificios en ladrillo de la Unidad Residencial Providencia en Medellín'],
        ],
    ],

    // Clave => etiqueta del filtro del portafolio
    'categorias' => [
        'diseno' => 'Diseño',
        'pead' => 'Tubería PEAD',
        'redes' => 'Alcantarillado',
        'casas' => 'Casas de campo',
        'altura' => 'Trabajos en altura',
        'inter' => 'Interventoría',
    ],

    'proyectos' => [
        'titulo' => 'Experiencia en obra',
        'texto' => 'Filtra por tipo de trabajo y toca cualquier foto para verla en grande.',
    ],

    // 'etiqueta' es opcional: reemplaza el nombre de la categoría en la tarjeta
    'obras' => [
        ['cat' => 'diseno', 'titulo' => 'Parque Urbano, Támesis', 'texto' => 'Diseño del parque urbano del municipio.', 'img' => 'images/obras/parque-tamesis-plano.webp', 'w' => 855, 'h' => 1104, 'alt' => 'Plano del parque urbano de Támesis'],
        ['cat' => 'diseno', 'titulo' => 'Parque Principal, Cisneros', 'texto' => 'Diseño del parque principal del municipio.', 'img' => 'images/obras/parque-cisneros.webp', 'w' => 900, 'h' => 900, 'alt' => 'Parque principal de Cisneros con escultura de arriero'],
        ['cat' => 'pead', 'titulo' => 'Red de aducción, Anzá', 'texto' => '14 km en PEAD Ø110 mm con tanques de quiebre, VRP y válvulas ventosas.', 'img' => 'images/obras/aduccion-anza.webp', 'w' => 900, 'h' => 690, 'alt' => 'Tanque de quiebre en la red de aducción de Anzá'],
        ['cat' => 'pead', 'titulo' => 'Red principal, Brizzas (Sabaneta)', 'texto' => 'Más de 500 m en PEAD 315 mm con cámaras reguladoras, cajas ventosas e hidrantes.', 'img' => 'images/obras/red-brizzas-sabaneta.webp', 'w' => 900, 'h' => 1075, 'alt' => 'Termofusión de tubería PEAD en Sabaneta'],
        ['cat' => 'redes', 'titulo' => 'Red de reposición, Caldas', 'texto' => 'Alcantarillado sanitario y pluvial, con manholes y sumideros.', 'img' => 'images/obras/alcantarillado-caldas.webp', 'w' => 900, 'h' => 707, 'alt' => 'Tubería de alcantarillado instalada en zanja en Caldas'],
        ['cat' => 'redes', 'titulo' => 'Red principal, Girardota', 'texto' => 'Construcción de red principal en tubería PVC Novafort.', 'img' => 'images/obras/red-girardota.webp', 'w' => 900, 'h' => 1201, 'alt' => 'Zanja entibada con tubería PVC Novafort en Girardota'],
        ['cat' => 'casas', 'titulo' => 'Urbanización Montesol, Sopetrán', 'texto' => 'Casa de campo con piscina y diseño contemporáneo.', 'img' => 'images/obras/casa-montesol.webp', 'w' => 900, 'h' => 715, 'alt' => 'Casa de campo con piscina en Montesol, Sopetrán'],
        ['cat' => 'casas', 'titulo' => 'Reservas del Lago, Sopetrán', 'texto' => 'Casa de dos niveles con amplios espacios y acabados de cuidado detalle.', 'img' => 'images/obras/reservas-del-lago-interior.webp', 'w' => 804, 'h' => 1074, 'alt' => 'Interior en obra de la casa Reservas del Lago'],
        ['cat' => 'altura', 'titulo' => 'Torre Siempre Verde, Sabaneta', 'texto' => 'Graniplast, resanes, pulida de concreto a la vista, sellos de ventanas, lavados e hidrófugos.', 'img' => 'images/obras/torre-siempre-verde.webp', 'w' => 900, 'h' => 1199, 'alt' => 'Fachada de la Torre Siempre Verde en Sabaneta'],
        ['cat' => 'altura', 'titulo' => 'Fachada Apartamentos Brizzas', 'texto' => 'Resanes, hidrófugo, sello de ventanas y juntas sísmicas, y Graniplast.', 'img' => 'images/obras/fachada-brizzas.webp', 'w' => 900, 'h' => 1201, 'alt' => 'Fachada de los apartamentos Brizzas'],
        ['cat' => 'inter', 'titulo' => 'Unidad Residencial Providencia', 'texto' => 'Interventoría del mantenimiento de fachada, en Medellín.', 'img' => 'images/unidad-providencia.webp', 'w' => 1500, 'h' => 966, 'alt' => 'Unidad Residencial Providencia en Medellín'],
        ['cat' => 'diseno', 'etiqueta' => 'Diseño y construcción', 'titulo' => 'Proyecto de vivienda, Segovia', 'texto' => 'Diseño arquitectónico y construcción de un edificio moderno, funcional y de alta calidad.', 'img' => 'images/obras/vivienda-segovia.webp', 'w' => 849, 'h' => 1131, 'alt' => 'Losa aligerada del proyecto de vivienda en Segovia'],
    ],

    'valores' => [
        'titulo' => 'Construimos confianza en cada obra',
        'texto' => 'Cuatro compromisos que aplicamos igual en una casa de campo que en una red de acueducto.',
        'items' => [
            ['titulo' => 'Calidad', 'texto' => 'En cada decisión técnica y en cada material.'],
            ['titulo' => 'Honestidad', 'texto' => 'En cada proceso, presupuesto y avance de obra.'],
            ['titulo' => 'Compromiso', 'texto' => 'Con los tiempos y los recursos de cada proyecto.'],
            ['titulo' => 'Pasión', 'texto' => 'Por crear espacios que conectan con las personas.'],
        ],
    ],

    'faq' => [
        'titulo' => 'Preguntas frecuentes',
        'texto' => '¿No encuentras tu respuesta? Escríbenos por WhatsApp y te respondemos el mismo día hábil.',
        'items' => [
            ['p' => '¿Puedo contratar solo el diseño o solo la interventoría?', 'r' => 'Sí. Cada servicio puede contratarse por separado o como un solo paquete, de la idea a la entrega.'],
            ['p' => '¿En qué zonas trabajan?', 'r' => 'Nuestra sede está en Medellín y hemos ejecutado obras en distintos municipios de Antioquia. Cuéntanos dónde está tu proyecto.'],
            ['p' => '¿Qué incluye la interventoría?', 'r' => 'Verificamos la calidad de los materiales, el cumplimiento del cronograma y el uso correcto de los recursos durante toda la obra.'],
            ['p' => '¿Cómo solicito una cotización?', 'r' => 'Completa el formulario de esta página o escríbenos por WhatsApp. Te respondemos con una propuesta para tu proyecto.'],
            ['p' => '¿Qué es la tubería PEAD?', 'r' => 'Es polietileno de alta densidad, un material resistente y duradero muy usado en redes de acueducto y aducción.'],
        ],
    ],

    'contacto' => [
        'titulo' => 'Cuéntanos qué quieres construir',
        'texto' => 'Llámanos o escríbenos directamente. Te respondemos con una propuesta para tu proyecto.',
        'form_titulo' => 'Solicita tu propuesta',
        'servicios' => ['Diseño', 'Construcción', 'Interventoría', 'Redes y tubería', 'Trabajos en altura'],
    ],

    // 'id' se usa en el formulario para elegir con quién hablar por WhatsApp
    'equipo' => [
        ['id' => 'evelin', 'nombre' => 'Ing. Evelin Jiménez', 'saludo' => 'Evelin', 'telefono' => '573168744870', 'telefono_visible' => '316 874 4870'],
        ['id' => 'walter', 'nombre' => 'Arq. Walter Restrepo', 'saludo' => 'Walter', 'telefono' => '573012425812', 'telefono_visible' => '301 242 5812'],
        ['id' => 'carolina', 'nombre' => 'Ing. Carolina Ortega', 'saludo' => 'Carolina', 'telefono' => '573113162229', 'telefono_visible' => '311 316 2229'],
    ],

];
