-- Adminer 4.8.1 MySQL 10.11.11-MariaDB-0+deb12u1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Certificaciones`;
CREATE TABLE `Certificaciones` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `duracion` varchar(255) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `mes` varchar(255) NOT NULL,
  `ventas` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Certificaciones` (`id`, `nombre`, `duracion`, `precio`, `tipo`, `mes`, `ventas`) VALUES
(1,	'Técnico en pruebas de resistencia',	'5 horas',	'4060.00',	'Examen',	'Marzo',	0),
(2,	'Técnico en pruebas de agregados',	'5 horas',	'4060.00',	'Examen',	'Abril',	0),
(3,	'Técnico y acabador de superficies planas de concreto',	'8 horas',	'10440.00',	'Curso y Examen',	'Mayo',	0),
(4,	'Supervisor especializado en obras de concreto',	'16 horas',	'13920.00',	'Curso',	'Mayo',	0),
(5,	'Técnico Laboratorista Nivel 2',	'8 horas',	'10440.00',	'Curso y Examen',	'Mayo',	0),
(6,	'Tecnico para pruebas al concreto en la obra Grado I',	'5 horas',	'4060.00',	'Examen',	'Junio',	0),
(7,	'Supervisor especializado en obras de concreto',	'5 horas',	'4060.00',	'Examen',	'Junio',	0),
(8,	'Técnico en pruebas de agregados',	'5 horas',	'4060.00',	'Examen',	'Julio',	0),
(9,	'Técnico en pruebas de agregados',	'5 horas',	'4060.00',	'Examen',	'Agosto',	0),
(10,	'Supervisor especializado en obras de concreto',	'16 horas',	'13920.00',	'Curso',	'Septiembre',	0),
(11,	'Técnico y acabador de superficies planas de concreto',	'8 horas',	'10440.00',	'Curso y Examen',	'Septiembre',	0),
(12,	'Tecnico para pruebas al concreto en la obra Grado I',	'5 horas',	'4060.00',	'Examen',	'Octubre',	0),
(13,	'Supervisor especializado en obras de concreto',	'5 horas',	'4060.00',	'Examen',	'Octubre',	0),
(14,	'Técnico en pruebas de resistencia',	'5 horas',	'4060.00',	'Examen',	'Noviembre',	0),
(15,	'Técnico en pruebas de agregado',	'5 horas',	'4060.00',	'Examen',	'Diciembre',	0);

DROP TABLE IF EXISTS `cotizaciones`;
CREATE TABLE `cotizaciones` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `numCotizacion` varchar(255) NOT NULL,
  `folio` varchar(255) NOT NULL,
  `cliente` varchar(255) NOT NULL,
  `capturo` varchar(255) NOT NULL,
  `fecha` varchar(255) NOT NULL,
  `usuariocl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `folio` (`folio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cotizaciones` (`id`, `numCotizacion`, `folio`, `cliente`, `capturo`, `fecha`, `usuariocl`) VALUES
(1,	'COT-GT-0001-2024',	'cliente2-ze80UW',	'cliente2 cl cl',	'KAREN LISSET PALACIOS REYNOSO',	'2024-06-04 11:12:05',	'cliente1'),
(2,	'COT-GT-0002-2024',	'Fabian-qPW3Fd',	'Fabian Medina ',	'KAREN LISSET PALACIOS REYNOSO',	'2024-06-04 12:08:57',	'fmedina'),
(3,	'COT-GT-0003-2024',	'Fabian-6AlcW9',	'Fabian Medina ',	'KAREN LISSET PALACIOS REYNOSO',	'2024-06-04 13:17:30',	'fmedina');

DROP TABLE IF EXISTS `cotizacionesf`;
CREATE TABLE `cotizacionesf` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `id_productos` text NOT NULL,
  `productos` text NOT NULL,
  `cantidades` text NOT NULL,
  `importe` float NOT NULL,
  `folio_cot` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cotizacionesf` (`id`, `Fecha`, `id_productos`, `productos`, `cantidades`, `importe`, `folio_cot`) VALUES
(1,	'2024-06-04',	'1,2',	'ACCION DE LOS AGENTES FISICOS Y QUIMICOS,ANALISIS ESTRUCTURAL',	'4,5',	10783,	'cliente2-ze80UW'),
(2,	'2024-06-04',	'1,2,3,4',	'ACCION DE LOS AGENTES FISICOS Y QUIMICOS,ANALISIS ESTRUCTURAL,ANALISIS SUGERIDO Y PROCEDIMIENTOS DE DISEÑO PARA ZAPATAS COMBINADAS Y LOSAS DE CIMENTACION,ANALISIS Y GUIA DE ESTUDIOS PARA PRUEBAS BASICAS AL CONCRETO EN ESTADO FRESCO 2018',	'2,3,1,2',	4415,	'Fabian-qPW3Fd');

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `precio` int(6) NOT NULL,
  `descripcion` text NOT NULL,
  `modulos` int(4) NOT NULL,
  `modalidad` varchar(255) NOT NULL,
  `clase` varchar(255) NOT NULL,
  `ventas` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cursos` (`id`, `nombre`, `precio`, `descripcion`, `modulos`, `modalidad`, `clase`, `ventas`) VALUES
(1,	'TÉCNICO ESPECIALISTA EN TÓPICOS DE DURABILIDAD',	0,	'Conocer los aspectos más importantes asociados al diagnóstico y evaluación de una estructura de concreto caracterizada por la presencia de alguna sintomatología patológica anómala e identificar los métodos para la prevención de las fallas y el deterioro prematuro',	5,	'En Linea',	'En Linea',	5),
(2,	'TÉCNICO EN COLOCACIÓN DE CONCRETO EN CLIMA CÁLIDO',	0,	'El objetivo de la certificación es que el participante podrá reconocer los efectos de colocar el concreto en climas con temperaturas elevadas y que acciones se deben tomar en cuenta para poder minimizar las consecuencias de colocar concreto en climas calurosos',	5,	'En Linea',	'En Linea',	5),
(3,	'TÉCNICO EN COLOCACIÓN DE CONCRETO EN CLIMA FRÍO',	0,	'El objetivo de la certificación es que el participante podrá reconocer los efectos de colocar el concreto en fríos moderado y severo con temperaturas bajas y que acciones se deben tomar en cuenta para poder minimizar las consecuencias de colocar concreto en climas fríos.',	7,	'En Linea',	'En Linea',	0),
(4,	'TÉCNICO EN PRUEBAS DE CAMPO DE CONCRETO – GRADO I',	0,	'Certificar el personal técnico y adquiera las habilidades para ejecutar y registrar correctamente los resultados de las pruebas de campo básicas con base a la normas ASTM y NMX en la mezcla de concreto fresco.',	5,	'En Linea',	'En Linea',	0),
(5,	'TÉCNICO EN PRUEBAS DE RESISTENCIA',	0,	'Conocer el procedimiento normalizado de las cuatro pruebas que se realizan al concreto endurecido con base en ASTM y NMX',	4,	'En Linea',	'En Linea',	0),
(6,	'TÉCNICO EN PRUEBAS DE AGREGADOS NIVEL I',	0,	'Certificación de técnicos con experiencia en el ensaye de agregados para concreto con tomando en cuenta las normas mexicanas NMX y normas internacionales ASTM.\r\n\r\n',	5,	'En Linea',	'En Linea',	0),
(7,	'SISTEMAS LIGEROS Y FIJACIÓN DIRECTA',	0,	'Certificación de técnicos con experiencia en el área de sistemas de fijación garantizando un personal con conocimientos en temas de métodos constructivos, generando alternativas más eficientes y sustentables',	4,	'En Linea',	'En Linea',	0),
(8,	'TÉCNICO ESPECIALISTA EN TECNOLOGÍA DE ADITIVOS',	0,	'Certificar al personal de la industria de la construcción que realiza pruebas de desempeño del concreto usando aditivos, para la comprensión de los efectos que se pueden obtener y puedan aplicar el conocimiento a las pruebas de campo y en la obra de construcción',	20,	'En Linea',	'En Linea',	0),
(9,	'BOMBEO DE CONCRETO',	0,	'Certificar al personal involucrado en sistemas de aplicación de concreto mediante bombeo, garantizando una operación segura y eficaz en obras de construcción.',	10,	'En Linea',	'En Linea',	0),
(10,	'FUNDAMENTOS DEL CONCRETO',	0,	'Proporcionar al personal de la industria de la construcción información esencial sobre la tecnología del concreto, durabilidad y posibles fallas que se puedan presentar para aplicarlo en las pruebas, colocación y evaluación de concreto.',	6,	'En Linea',	'En Linea',	0),
(11,	'DURABILIDAD',	0,	'Certificar a los trabajadores dedicados a procesos de autoconstrucción para que apliquen los fundamentos principales para la construcción de una vivienda, usando materiales de vanguardia',	5,	'En Linea',	'En Linea',	0),
(12,	'PATOLOGÍAS DEL CONCRETO',	0,	'Certificar a los trabajadores dedicados a procesos de autoconstrucción para que apliquen los fundamentos principales para la construcción de una vivienda, usando materiales de vanguardia',	10,	'En Linea',	'En Linea',	0),
(13,	'TÉCNICO EN PROCESOS GENERALES DE AUTOCONSTRUCCIÓN',	0,	'Certificar a los trabajadores dedicados a procesos de autoconstrucción para que apliquen los fundamentos principales para la construcción de una vivienda, usando materiales de vanguardia',	4,	'En Linea',	'En Linea',	0),
(14,	'TÉCNICO ESPECIALISTA EN TÓPICOS DE POSTENSADO',	0,	'Promover la certificación del personal que realiza y verifica los sistemas postensados que se aplican al concreto, enfocado en la situación actual en pisos postensados',	8,	'En Linea',	'En Linea',	0),
(15,	'TÉCNICO PARA PRUEBAS AL CONCRETO EN LA OBRA-GRADO I',	0,	'Certificar que el aspirante posee los conocimientos y habilidades para ejecutar y registrar correctamente los resultados de las pruebas de campo básicas con base a la norma ASTM en la mezcla de concreto fresco.',	4,	'Presencial',	'Certificaciones ACI',	0),
(16,	'TÉCNICO EN PRUEBAS DE RESISTENCIA AL CONCRETO ENDURECIDO',	0,	'Conocer el procedimiento normalizado de las cuatro pruebas que se realizan al concreto endurecido con base en ASTM International (American SocietyforTesting and Materials).',	4,	'Presencial',	'Certificaciones ACI',	0),
(17,	'TÉCNICO Y ACABADOR DE SUPERFICIES PLANAS DE CONCRETO',	0,	'Proporcionar las bases para la certificación de acabadores de concreto experimentados, corregir los problemas relacionados con prácticas de campo inapropiadas, elevar la calidad de la construcción con concreto y preparar a la industria para una futura certificación obligatoria',	3,	'Presencial',	'Certificaciones ACI',	0),
(18,	'TÉCNICO EN PRUEBAS DE AGREGADOS',	0,	'Proporcionar las bases para la certificación de técnicos con experiencia en el ensaye de agregados para concreto, resolver los problemas derivados de las prácticas inadecuadas de prueba, mejorar la calidad de la construcción con concreto y preparar a la industria para la certificación obligatoria',	5,	'Presencial',	'Certificaciones ACI',	0),
(19,	'SUPERVISOR ESPECIALIZADO EN OBRAS DE CONCRETO',	0,	'Certificar que el aspirante posee los conocimientos sobre tecnología del concreto, especificaciones y tolerancias de armados, cimbras, recubrimientos e insertos, para ejecutar la secuencia correcta de supervisión antes, durante y después de la colocación del concreto, así como la escolaridad y la experiencia en la construcción con concreto requeridas para ser un Supervisor en obras de concreto.',	3,	'Presencial',	'Certificaciones ACI',	0),
(20,	'SUPERVISOR Y TÉCNICO DE CONSTRUCCIONES TILT-UP',	0,	'Asegurar que el aspirante cuenta con la experiencia en temas de seguridad, lectura de planos, programación, preparación del sitio y cimentaciones, losas sobre el terreno, disposición, moldaje. Así como, proporcionar los conocimientos relacionados con las propiedades del concreto, su colocación y erección de elementos en los diferentes sistemas estructurales.',	8,	'Presencial',	'Certificaciones ACI',	0),
(21,	'TÉCNICO LABORATORISTA NIVEL II',	0,	'Certificar que el aspirante ha demostrado el conocimiento y la capacidad para realizar de manera adecuada, registrar y reportar los resultados de procedimientos avanzados de laboratorio para agregados y concreto de cinco procedimientos ASTM básicos de laboratorio.',	2,	'Presencial',	'Certificaciones ACI',	0),
(22,	'CONCRETO LANZADO',	0,	'Este programa requiere la demostración de los conocimientos cubiertos en el análisis de tareas de trabajo (JTA) para el inspector de concreto lanzado',	9,	'Presencial',	'Certificaciones ACI',	0),
(23,	'TÉCNICO EN PRUEBAS AL CEMENTO',	0,	'Proporcionar al participante de conocimientos y habilidades para ejecutar las pruebas básicas en pastas de cemento hidráulicas con base a las normas NMX correspondientes.',	7,	'Presencial',	'Certificaciones IMCYC',	0),
(24,	'SUPERVISOR DE CONCRETO LANZADO',	0,	'Respaldar los conocimientos que el aspirante posee respecto a las tecnologías del concreto lanzado, así como tipos, aplicaciones, condiciones climáticas, curado y formas para evitar las malas aplicaciones del concreto lanzado.\r\n\r\n',	11,	'Presencial',	'Certificaciones IMCYC',	0),
(25,	'CIMBRAS PARA CONCRETO LANZADO',	0,	'Respaldar los conocimientos que el aspirante posee respecto a las tecnologías del concreto lanzado, así como tipos, aplicaciones, condiciones climáticas, curado y formas para evitar las malas aplicaciones del concreto lanzado.',	5,	'Presencial',	'Certificaciones IMCYC',	0),
(26,	'ACABADOR DE CONCRETO LANZADO',	0,	'Respaldar los conocimientos que el aspirante posee respecto a las tecnologías del concreto lanzado, así como tipos, aplicaciones, condiciones climáticas, curado y formas para evitar las malas aplicaciones del concreto lanzado.',	4,	'Presencial',	'Certificaciones IMCYC',	0),
(27,	'TÉCNICO PARA PRUEBAS AL CONCRETO FRESCO',	0,	'Transmitir al aspirante, para que obtenga los conocimientos y habilidades para ejecutar y registrar correctamente los resultados de las pruebas de campo básicas con base a la norma NMX en la mezcla de concreto fresco.',	6,	'Presencial',	'Certificaciones IMCYC',	0),
(28,	'TÉCNICO EN PRUEBAS DE RESISTENCIA',	0,	'Conocer el procedimiento normalizado de las cuatro pruebas que se realizan al concreto endurecido con base en a las normas Mexicanas NMX',	4,	'Presencial',	'Certificaciones IMCYC',	0),
(29,	'TÉCNICO EN PRUEBAS DE AGREGADOS',	0,	'Proporcionar las bases para la certificación de técnicos con experiencia en el ensaye de agregados para concreto, resolver los problemas derivados de las prácticas inadecuadas de prueba, mejorar la calidad de la construcción con concreto y preparar a la industria para la certificación obligatoria.',	5,	'Presencial',	'Certificaciones IMCYC',	0),
(30,	'OPERADORES DE PLANTAS, BOMBAS Y OLLAS DE CONCRETO',	0,	'Que los participantes adquieran el conocimiento de los sistemas para operar máquinas para concreto, su mantenimiento y seguridad. Se proporcionará a los participantes temas de fundamentos de concreto y atención al cliente.',	4,	'Presencial',	'Certificaciones IMCYC',	0),
(31,	'TÉCNICO EN EVALUACIÓN DE ESTRUCTURAS DE CONCRETO',	0,	'El objetivo general de la certificación radica en que al final del evento el alumno conozca los aspectos más importantes asociados al diagnóstico, la evaluación y la intervención de una estructura de concreto caracterizada por la presencia de alguna sintomatología patológica anómala.',	4,	'Presencial',	'Certificaciones IMCYC',	0),
(32,	'DISEÑO Y CONSTRUCCIÓN DE PISOS INDUSTRIALES',	0,	'Presentar la importancia que tiene la estructura de una losa de concreto que estará apoyada sobre el terreno en especial la subrasante y la subbase. Así como los efectos de la humedad que pueden influir en la calidad de la estructura. Seleccionar la calidad del concreto que será utilizado durante la construcción de una losa apoyada sobre el terreno. ',	7,	'Presencial',	'Cursos IMCYC',	0),
(33,	'EVALUACIÓN DE ESTRUCTURAS DE CONCRETO',	0,	'El objetivo general de la certificación radica en que al final del evento el alumno conozca los aspectos más importantes asociados al diagnóstico, la evaluación y la intervención de una estructura de concreto caracterizada por la presencia de alguna sintomatología patológica anómala',	4,	'Presencial',	'Cursos IMCYC',	0),
(34,	'TECNOLOGÍA DE ADITIVOS PARA CONCRETO',	0,	'Dar a conocer y mostrar los temas avanzados de aditivos químicos que se utilizan en las mezclas de concreto y que demanda la industria de la construcción en estos momentos.',	6,	'Presencial',	'Cursos IMCYC',	0),
(35,	'CONSTRUCCIÓN DE PAVIMENTOS DE CONCRETO',	0,	'Conocer las consideraciones previas que hay que tomarse en cuenta antes de realizar la pavimentación de un proyecto carretero, se analizará la mezcla de concreto y la importancia que juega en este tipo de estructuras',	6,	'Presencial',	'Cursos IMCYC',	0),
(36,	'EVALUACIÓN DE PAVIMENTOS DE CONCRETO',	0,	'Contar con herramientas que permitan entender el deterioro ocasionado por las cargas o solicitaciones externas, así como por los agentes erosivos que causan un daño a los pavimentos rígidos.',	5,	'Presencial',	'Cursos IMCYC',	0),
(37,	'PRUEBAS FÍSICAS AL CEMENTO',	0,	'Proporcionar al participante de conocimientos y habilidades para ejecutar las pruebas básicas en pastas de cemento hidráulicas con base a las normas NMX correspondientes.',	6,	'Presencial',	'Cursos IMCYC',	0),
(38,	'REPARACIÓN DE ESTRUCTURAS DE CONCRETO',	0,	'Dar a conocer los aspectos básicos del Reglamento ACI 318, presentar la manera de realizar la evaluación de las estructuras de concreto así como las bases de la rehabilitación y mantenimiento, ejemplificando algunas de ellas con casos de estudio',	5,	'Presencial',	'Cursos IMCYC',	0),
(39,	'DISEÑO DE ESTRUCTURAS DE CONCRETO CON BASE AL REGLAMENTO ACI 318-19',	0,	'Introducir al usuario al nuevo reglamento ACI 318-14 reorganizado. Actualizar al asistente en el manejo y entendimiento de la reorganización completa del reglamento ACI 318-14. Mostrar como impactará el capítulo de Construcción del ACI 318-14 a la industria',	11,	'Presencial',	'Cursos IMCYC',	0),
(40,	'DURABILIDAD DE ESTRUCTURAS DE CONCRETO',	0,	'Que los participantes adquieran los conocimientos básicos necesarios para saber detectar e identificar las diferentes patologías que se pueden desarrollar en las estructuras de concreto; con lo que será posible de primera instancia, desarrollar diagnósticos eficaces encaminados a evaluar y reparar dichas estructuras, antes acciones de posible ocurrencia.',	3,	'Presencial',	'Cursos IMCYC',	0),
(41,	'PRUEBAS NO DESTRUCTIVAS (PND)',	0,	'Ofrecer una descripción y las ventajas de la ejecución de pruebas no destructivas en la evaluación de las estructuras de concreto. Así como, la aplicación y los alcances de las pruebas más comunes. Mostrar como se puede realizar un diagnóstico rápido y confiable del estado que guarda la estructura, los materiales con los que fue construida y su comportamiento futuro.',	2,	'Presencial',	'Cursos IMCYC',	0),
(42,	'SUPERVISOR DE CONCRETO LANZADO',	0,	'Respaldar los conocimientos que el aspirante posee respecto a las tecnologías del concreto lanzado, así como tipos, aplicaciones, condiciones climáticas, curado y formas para evitar las malas aplicaciones del concreto lanzado.',	8,	'Presencial',	'Cursos IMCYC',	0),
(43,	'TECNOLOGÍA DEL CONCRETO',	0,	'Proporcionar a los participantes información relacionada con los materiales y Normas Mexicanas de los componentes del concreto. Presentar temas relacionados con sus propiedades, así como algunos aspectos de durabilidad y conceptos que son necesarios en la práctica.',	2,	'Presencial',	'Cursos IMCYC',	0),
(44,	'DISEÑO DE PAVIMENTOS DE CONCRETO',	0,	'Proporcionar a los participantes información actualizada del proyecto y diseño, transmitir las ideas y criterios básicos de diseño; posteriormente se hace un recuento minucioso sobre cada uno de los componentes y aspectos a considerar en el proyecto y diseño de los pavimentos.',	8,	'Presencial',	'Cursos IMCYC',	0),
(45,	'REPARACIÓN DE PAVIMENTOS DE CONCRETO',	0,	'Identificar los deterioros en pavimentos de concreto mediante pruebas y técnicas de RPC para optar por la o las estrategias y procesos de rehabilitación adecuados, así como las causas de los deterioros y aplicación de técnicas preventivas.',	2,	'Presencial',	'Cursos IMCYC',	0),
(46,	'FORMACIÓN DE AUDITORES INTERNOS NORMA ISO 19011:2001',	0,	'Al terminar el curso, el participante conocerá los lineamientos para la realización de auditorías internas a sistemas de gestión de la calidad, las etapas del proceso de auditoría, así como su utilidad en el desarrollo de la empresa.',	3,	'Presencial',	'Cursos IMCYC - CALIDAD',	0),
(47,	'ESTIMACIÓN DE LA INCERTIDUMBRE EN LA MEDICIÓN EN MÉTODOS DE PRUEBA EN EL SECTOR DE LA CONSTRUCCIÓN',	0,	'Proporcionar a los participantes los conceptos básicos sobre la estimación de la incertidumbre de los resultados en las mediciones de métodos de prueba.\r\n\r\nExplicar la metodología de la estimación de la incertidumbre con base a la norma NMX-CH-140 “Guía para la expresión de incertidumbre en las mediciones”.\r\n\r\nDeterminar la incertidumbre del resultado de las mediciones involucradas en los ensayes básicos del área de construcción.\r\n\r\nUnificar los criterios de aplicación de la estimación de la incertidumbre entre los participantes.',	4,	'Presencial',	'Cursos IMCYC - CALIDAD',	0),
(48,	'TRATAMIENTO DE NO CONFORMIDADES, ACCIONES CORRECTIVAS Y PREVENTIVAS',	0,	'Promover una sistemática de mejora continua PARA tratamiento de las no conformidades\r\n\r\nTomar consciencia de los riesgos, tomando una política de anticipación en el tratamiento de no conformidades de gestión de reclamaciones.\r\n\r\nConocer el correcto tratamiento de las no conformidades en relación al Sistema de Calidad',	7,	'Presencial',	'Cursos IMCYC - CALIDAD',	0),
(49,	'ASEGURAMIENTO DE LA VALIDEZ DE LOS RESULTADOS',	0,	'Proporcionar a los participantes diversas formas de asegurar la calidad de los resultados de los ensayos a través de la aplicación de herramientas estadísticas, ejemplificando casos prácticos de ensayos en el sector de la construcción.',	5,	'Presencial',	'Cursos IMCYC - CALIDAD',	0),
(50,	'ADMINISTRACIÓN DE UN LABORATORIO CON BASE A LA NORMA 17025',	0,	'Al terminar el curso, el participante conocerá los requisitos que deben ser cumplidos de acuerdo a la norma NMX-EC-17025-IMNC-2006 “Requisitos generales para la competencia de los laboratorios de ensayo y de calibración” y, aquellos adicionales solicitados para obtener y mantener la acreditación.',	3,	'Presencial',	'Cursos IMCYC - CALIDAD',	0),
(51,	'FORMACIÓN DE GERENTE TÉCNICO',	0,	'El participante podrá obtener información completa sobre el concreto y sus componentes, pruebas de calidad y análisis económico sobre la viabilidad de los proyectos, así implementarlo para el desarrollo de los nuevos productos y conocerá las técnicas comerciales para incremento de ventas',	5,	'Presencial',	'Talleres',	0),
(52,	'TECNOLOGÍA DEL CONCRETO',	0,	'Conocer los componentes del concreto\r\n\r\nDescubrir los factores que influyen en las características físicas del concreto\r\n\r\nConocer cuáles son las características deseables de un concreto\r\n\r\nIdentificar las etapas del proceso de fabricación del concreto que influyen en su calidad\r\n\r\nConocer que es el cemento y como se fabrica\r\n\r\nAnalizar la composición química del cemento\r\n\r\nClasificar los distintos tipos de cemento\r\n\r\nConocer la normativa\r\n\r\nDeterminar la composición y las características especiales de los cementos puzolánicos\r\n\r\nAnalizar las propiedades físicas del cemento\r\n\r\nComprender qué tipo de cementos se utilizan en determinadas construcciones',	9,	'Presencial',	'Diplomados',	0),
(53,	'PISOS Y PAVIMENTOS DE CONCRETO',	0,	'El participante podrá diseñar, evaluar y reparar pisos y pavimentos de concreto y aplicarlo para realizar evaluación de proyectos de construcción de esta índole',	10,	'Presencial',	'Diplomados',	0),
(54,	'NUEVAS TÉCNICAS EN EL DISEÑO Y CONSTRUCCIÓN DE PAVIMENTOS DE CONCRETO',	0,	'El participante conocerá las técnicas novedosas acerca del diseño y la construcción de pavimentos de concreto para poder aplicarlo en la obra.',	0,	'Presencial',	'SEMINARIOS',	0),
(55,	'DISEÑO POR DURABILIDAD Y PATOLOGÍAS EN LAS ESTRUCTURAS DE CONCRETO',	0,	'El personal que asista al seminario conocerá los métodos y técnicas para la predicción de durabilidad de estructuras de concreto, así como las patologías que se pueden presentar, se establecerán algunas soluciones para incrementar el tiempo de servicio de elementos estructurales.',	0,	'Presencial',	'SEMINARIOS',	0),
(56,	'EVALUACIÓN Y DIAGNOSTICO INTEGRAL DEL NIVEL DE DAÑO EN LAS ESTRUCTURAS DE CONCRETO (PND)',	0,	'Conocer los sistemas de evaluación de estructuras de concreto\r\n\r\nComprender de que consta el diagnostico integral acerca de los daños que se presentan en las estructuras de concreto\r\n\r\nConocer las pruebas no destructivas que se tienen en la industria del concreto',	0,	'Presencial',	'SEMINARIOS',	0),
(57,	'EVALUACIÓN DE ESTRUCTURAS DE CONCRETO Y EL ESTADO DEL ARTE EN SUS TÉCNICAS DE REPARACIÓN',	0,	'Conocer las patologías que se presentan en el concreto y las medidas de corrección\r\n\r\nComprender como se realizar el diagnostico y la corrección de los daños\r\n\r\nIdentificar los materiales para la reparación, refuerzo y protección\r\n\r\nConocer los procedimientos de reparación, refuerzo y protección para el mantenimiento de las estructuras',	4,	'Presencial',	'SEMINARIOS',	0),
(58,	'CRITERIOS DE EVALUACIÓN PARA LOS LABORATORIOS DE ENSAYO',	0,	'Identificar los criterios que se marcan para evaluar laboratorios de concreto para avalar la calidad e integridad del personal que realiza las pruebas',	0,	'Presencial',	'SEMINARIOS',	0),
(59,	'CAUSAS, EVALUACIÓN Y REPARACIÓN DE GRIETAS EN ESTRUCTURAS DE CONCRETO',	0,	'Identificar los mecanismos de formación de grietas en el concreto\r\n\r\nPresentar como controlar el agrietamiento debido a las diferentes causas\r\n\r\nReconocer los efectos del agrietamiento a largo plazo',	3,	'Presencial',	'SEMINARIOS',	0),
(60,	'EXPLORACIÓN Y EVALUACIÓN INTEGRAL DE BANCOS DE AGREGADOS PARA CONCRETO',	0,	'Dar a conocer los procesos de exploración de bancos de agregados utilizados para elaboración de concreto\r\n\r\nPresentar la evaluación de bancos de agregados para verificación de calidad de los materiales',	0,	'Presencial',	'SEMINARIOS',	0),
(61,	'TECNOLOGÍA Y PATOLOGÍA DEL CONCRETO PARA LA INDUSTRIA MINERA',	0,	'Identificar las fallas que puedan ocurrirle al concreto en la industria de la minería\r\n\r\nConocer los fundamentos básicos de tecnología de concreto aplicada a la industria minera',	0,	'Presencial',	'SEMINARIOS',	0),
(62,	'NUEVAS TECNOLOGÍAS EN MACROFIBRAS DE ALTO DESEMPEÑO Y SU EVALUACIÓN TÉCNICA',	0,	'Identificar tecnologías novedosas en el uso de macrofibras en la industria del concreto de alto desempeño\r\n\r\nReconocer la evaluación técnica que se realiza al concreto de alto desempeño con fibras',	0,	'Presencial',	'SEMINARIOS',	0),
(63,	'LAS NUEVAS TENDENCIAS EN LA CONSTRUCCIÓN/ EL ESTADO DEL ARTE DE FIBROCEMENTO',	0,	'Reconocer las nuevas tendencias que se realizan en la industria de la construcción para poder aplicarlas\r\n\r\nIdentificar las generalidades sobre fibrocemento aplicado en la construcción',	0,	'Presencial',	'SEMINARIOS',	0);

DROP TABLE IF EXISTS `libros`;
CREATE TABLE `libros` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) NOT NULL,
  `general` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `precio` float NOT NULL,
  `ventas` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `libros` (`id`, `clave`, `general`, `titulo`, `autor`, `precio`, `ventas`) VALUES
(1,	'740-038',	'',	'ACCION DE LOS AGENTES FISICOS Y QUIMICOS',	'ING. MIGUEL ANGEL SAN JUAN Y DR. PEDRO CASTRO',	120,	42),
(2,	'740-281',	'336.2R-02',	'ANALISIS ESTRUCTURAL',	'A. GHALI / A.M. NEVILLE ',	490,	27),
(3,	'740-439',	'336.2R-02',	'ANALISIS SUGERIDO Y PROCEDIMIENTOS DE DISEÑO PARA ZAPATAS COMBINADAS Y LOSAS DE CIMENTACION',	NULL,	185,	1),
(4,	'740-033',	'304-96',	'ANALISIS Y GUIA DE ESTUDIOS PARA PRUEBAS BASICAS AL CONCRETO EN ESTADO FRESCO 2018',	NULL,	1260,	2),
(5,	'740-033',	'336.2R-02',	'BOMBEO DE CONCRETO',	NULL,	170,	0),
(6,	'740-420',	'441',	'COLUMNAS DE CONCRETO DE ALTA RESISTENCIA',	NULL,	160,	0),
(7,	'740-003',	'309.R-05',	'COMPACTACION DEL CONCRETO',	NULL,	250,	0),
(8,	'740-334',	'211.4R y 363.2R',	'CONCRETO DE ALTA RESISTENCIA. PROPORCIONAMIENTO DE MEZCLAS, CONTROL DE CALIDAD Y ENSAYES',	NULL,	320,	0),
(9,	'740-273',	'',	'CONCRETO PARA TECNICOS DE LA CONSTRUCCION',	'DR. RENÉ MUCIÑO CASTAÑEDA',	305,	0),
(10,	'740-006',	'302.1R-04',	'CONSTRUCCION DE LOSAS Y PISOS DE CONCRETO',	NULL,	385,	0),
(11,	'740-521',	'336.3R-93',	'DISEÑO Y CONSTRUCCION DE PILAS COLADAS EN EL SITIO',	NULL,	185,	0),
(12,	'740-525',	'543.R-00',	'DISEÑO, FABRICACION E INSTALACIÓN DE PILOTES DE CONCRETO',	NULL,	300,	0),
(13,	'740-014',	'301-05',	'ESPECIFICACIONES PARA EL CONCRETO ESTRUCTURAL',	NULL,	450,	0),
(14,	'740-185',	'117.01',	'ESPECIFICACIONES Y TOLERANCIAS PARA MATERIALES Y CONSTRUCCIONES DE CONCRETO',	NULL,	185,	0),
(15,	'748-009',	'',	'FISUROMETRO - GRIETOMETRO',	'IMCYC',	35,	0),
(16,	'740-573',	'ASCC-10 ',	'GUIA DEL CONTRATISTA PARA LA CONSTRUCCION EN CONCRETO DE CALIDAD ',	NULL,	685,	0),
(17,	'740-485',	'',	'GUIA PARA ANALISIS SISMICO DE EST. CONCRETO REFZ. CONTENER LIQUIDOS',	'M. en I. VICTOR PAVÓN',	365,	0),
(18,	'740-511',	'213R-03',	'GUIA PARA EL CONCRETO ESTRUCTURAL DE AGREGADOS DE PESO LIGERO',	NULL,	190,	0),
(19,	'740-524',	'308-01',	'GUÍA PARA EL CURADO DEL CONCRETO',	NULL,	170,	0),
(20,	'740-535 ',	'',	'GUIA PARA EL DISEÑO CONSTRUCCION DE PAVIMENTOS RIGIDOS - 2da EDICIÓN ',	'ING. AURELIO SALAZAR',	320,	0),
(21,	'740-015',	'347-04',	'GUIA PARA EL DISEÑO Y LA CONSTRUCCION DE CIMBRAS',	NULL,	315,	0),
(22,	'740-530',	'303.R-04',	'GUIA PARA LA COLOCACION DE CONCRETO ARQUITECTONICO EN EL SITIO',	NULL,	215,	0),
(23,	'740-566',	'305 y 306-10 ',	'GUIA PARA LA COLOCACION DEL CONCRETO EN CLIMA CALIENTE Y CLIMA FRIO ACI305-306-10 ',	NULL,	320,	0),
(24,	'740-490',	'221-01',	'GUIA PARA USO DE AGREGADOS',	NULL,	185,	0),
(25,	'740-593',	'214-11',	' GUIA PARA LA EVALUACION DE LOS RESULTADOS DE PRUEBAS DE  RESISTENCIA DE CONCRETO',	NULL,	215,	0),
(26,	'740-440',	'221-01',	'GUIA PARA USO DE AGREGADOS',	NULL,	135,	0),
(27,	'740-200',	'304-00',	' GUIA PRACTICA PARA LA MEDICION, MEZCLADO, TRANSPORTE Y  COLOCACION DEL CONCRETO',	NULL,	385,	0),
(28,	'740-039',	'',	'INFRAESTRUCTURA DEL CONCRETO ARMADO',	'DR. PEDRO CASTRO',	160,	0),
(29,	'740-199',	'224.3R',	' JUNTAS EN LAS CONSTRUCCIONES DE CONCRETO',	NULL,	320,	0),
(30,	'740-536',	'',	' MANOS A LA OBRA II',	'ARQ. JOSÉ DE JESUS SALDAÑA GUERRA',	495,	0),
(31,	'740-040',	'',	'MANUAL DE CONSTRUCCION DE MAMPOSTERIA DE CONCRETO',	'ANGELICA MARIA HERRERA V.',	320,	0),
(32,	'740-487',	'PCA',	'MANUAL DE CONSTRUCCION DE SUELO CEMENTO',	'',	190,	0),
(33,	'740-488',	'PCA',	' MANUAL DEL INSPECTOR DE SUELO CEMENTO',	NULL,	165,	0),
(34,	'740-321',	'',	' MANUAL ILUSTRADO DE REPARACION Y MANTENIMIENTO DEL CONCRETO.  ANALISIS DE PROBLEMAS, ESTRATEGIAS Y TECNICAS DE REPARACION',	'PETER H. EMMONS',	385,	0),
(35,	'740-022',	'CRSI',	'MANUAL PARA HABILITAR ACERO DE REFUERZO PARA EL CONCRETO',	NULL,	250,	0),
(36,	'740-023',	'',	'MANUAL PARA REPARACION, REFUERZO Y PROTECCION DE LAS  ESTRUCTURAS DE CONCRETO',	'DR. PAULO DO LAGO HELENE',	360,	0),
(37,	'740-021',	'311-07',	'MANUAL PARA SUPERVISAR OBRAS DE CONCRETO',	NULL,	620,	0),
(38,	'740-187',	'',	'MANUAL PRACTICO PARA SOLDAR Y SUPERVISAR ACERO DE REFUERZO',	'ING. FRANCISCO VELAZQUEZ ALCALÁ',	185,	0),
(39,	'740-482',	'',	'METODOS PARA DOSIFICAR CONCRETO DE ELEVADO DESEMPEÑO',	'VITERVO A. O´REILLY DIAZ',	305,	0),
(40,	'740-184',	'22B.1R',	' METODOS PARA ESTIMAR LA RESISTENCIA DEL CONCRETO EN EL SITIO',	NULL,	245,	0),
(41,	'748-003',	'',	'MONITOR DE FISURAS',	'IMCYC',	285,	0),
(42,	'740-491',	'325.10-01',	'PAVIMENTOS DE CONCRETO COMPACTADO CON RODILLO',	NULL,	195,	0),
(43,	'740-459',	'',	'PAVIMENTOS DE CONCRETO PARA CARRETERAS. VOL. 1 PROYECTO Y  CONSTRUCCION',	'COMITÉ TÉCNICO DE PAVIMENTOS DE  CONCRETO & ESQUIVEL DÍAZ, R.',	290,	0),
(44,	'740-459',	'',	'PAVIMENTOS DE CONCRETO PARA CARRETERAS. VOL. 2 EVALUACION Y  CONSERVACION',	'COMITÉ TÉCNICO DE PAVIMENTOS DE  CONCRETO & ESQUIVEL DÍAZ, R',	290,	0),
(45,	'740-441',	'PCA',	'PISOS INDUSTRIALES DE CONCRETO',	'JAMES A. FARNY',	295,	0),
(46,	'740-027',	'211.1',	'PROPORCIONAMIENTO DE MEZCLAS. CONCRETO NORMAL, PESADO Y  MASIVO',	NULL,	260,	0),
(47,	'740-586',	'3185-14',	'REQUISITOS DE REGLAMENTO PARA CONCRETO ESTRUCTURAL Y  COMENTARIOS (2019)',	NULL,	1435,	0),
(48,	'740-183',	'121.R',	'SISTEMAS DE CALIDAD PARA PROYECTOS DE CONSTRUCCION CON  CONCRETO',	NULL,	110,	0),
(49,	'740-436',	'',	'SISTEMAS DE CIMBRA PARA EL CONCRETO',	'AWAD S. HANNA',	385,	0),
(50,	'740-029',	'',	'SUELO-CEMENTO. PROPIEDADES Y APLICACIONES',	'EDUARDO DE LA FUENTE LAVALLE',	240,	0),
(51,	'740-531',	'CP 44-09',	'TECNICO EN ENSAYE DE AGREGADOS CP-44-09',	NULL,	1090,	0),
(52,	'740-529',	'CP-19',	'TECNICO EN ESAYE DE RESISTENCIA CP-19',	NULL,	655,	0),
(53,	'740-030',	'',	'TECNOLOGIA DEL CONCRETO',	'ADAM M. NEVILLE',	535,	0),
(54,	'740-437',	'',	'TEMAS FUNDAMENTALES DEL CONCRETO PRESFORZADO',	'ING. FELIPE DE JESÚS OROZCO ZEPEDA',	390,	0),
(55,	'740-173',	'116.R-00',	'TERMINOLOGIA DEL CEMENTO Y DEL CONCRETO',	NULL,	200,	0);

DROP TABLE IF EXISTS `Webinars`;
CREATE TABLE `Webinars` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `precio` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `modulos` int(11) NOT NULL,
  `ventas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `Webinars` (`id`, `nombre`, `precio`, `descripcion`, `modulos`, `ventas`) VALUES
(1,	'CLIMA CALIDO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	11),
(2,	'CLIMA FRIO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	6),
(3,	'DURABILIDAD DEL CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Video Clase',	5,	0),
(4,	'TECNOLOGIA DE LOS AGREGADOS PARA CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	6,	0),
(5,	'PISOS INDUSTRIALES DE CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(6,	'REFORZAMIENTO TÉCNICO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(7,	'ESTRATEGIA COMERCIAL',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Video clase',	0,	0),
(8,	'FUNDAMENTOS DEL CEMENTO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(9,	'MANUAL DE HABILITADO DEL ACERO DE REFUERZO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos',	0,	0),
(10,	'VISIÓN PRÁCTICA EN LA ADMINISTRACIÓN DEL CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(11,	'FUNDAMENTOS DEL CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(12,	'PISOS POSTENSADOS DE CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Video Clase',	0,	0),
(13,	'TECNICO EN PRUEBAS FISICAS DE CEMENTO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(14,	'MANUAL DE EVALUACION FORENSE',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias',	0,	0),
(15,	'PRUEBAS NO DESTRUCTIVAS APLICADAS AL CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Video Clase',	0,	0),
(16,	'INSPECCION Y MANTENIMIENTO DE PUENTES DE CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos',	0,	0),
(17,	'MANUAL DE CONSTRUCCION DE VIVIENDA',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos',	0,	0),
(18,	'EL CONCRETO DE LA GEOTECNICA',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos',	0,	0),
(19,	'TECNICO EN PRUEBAS DE CAMPO DE CONCRETO GRADO 1',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0),
(20,	'TECNICO LABORATORISTA NIVEL 2',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0),
(21,	'PRESENTACION EN PRUEBAS DE RESISTENCIA',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0),
(22,	'TECNICO ACABADOR DE SUPERFICIES PLANAS DE CONCRETO',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0),
(23,	'TECNICO EN PRUEBAS DE AGREGADOS NIVEL 1',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0),
(24,	'TECNICO EN PRUEBAS DE CONCRETO AUTOCOMPACTABLE',	'2500',	'Presentación ejecutiva, Dato en concreto, Infografias, Videos, Video Clase',	0,	0);

-- 2025-06-19 18:23:09
