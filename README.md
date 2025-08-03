# Sistema de Encuestas Institucionales #
Este es un sistema donde ciertos usuarios podran crear encuestas dirigidas a estudiantes dentro de un instituto, recopilando los votos y facilitando su lectura.

### Usuarios ###
Habra 3 tipos de usuarios dentro del sistema, el usuario Administrador, Creador y Votante.

*ADMIN* se encarga de la moderacion del sitio, siendo capaz de crear, editar, borrar y ver todas las encuestas del sitio, tambien es el encargado de crear, editar y borrar los usuarios de tipo *Creador*.

*CREADOR* Este tipo de usuario tiene la posibilidad de crear encuestas, con sus respectivos filtros y caracteristicas, siendo capaz de borrar o editar las que sean de su propiedad.

*ALUMNO* Este tipo de usuario puede ver las encuestas disponibles, votar y ver los resultados. Siendo tambien capaz de hacer publico su voto o mantenerlo en privado (Con respecto a otros alumnos, el creador y el admin siempre tienen acceso a esta info)


## LOGICA GENERAL DEL SISTEMA ##
Cuando cualquier usuario ingresa en el sitio, lo primero que pide es logearse. Habria 2 tipos de logins, uno para votantes (estudiantes, con una base de datos distinta) y otra para creadores/admin(Profes o usuarios que puedan crear encuestas, base de datos propia del proyecto).

Una vez ingresado, es redirigido al inicio, donde dependiendo del rol vera distintas cosas ademas de las encuestas, como un tablero de control con funciones propias de cada rol. El alumno no tiene panel

Panel Admin --> Ver usuario - Crear usuario - Ver encuesta - Crear encuesta

Panel Creador --> Ver encuesta - Crear encuesta

(El tablero es simplemente un conjunto de botones que enlazan los distintos sitios del sistema, el sistema de roles en el servidor se encarga de filtrar a los demas usarios)


## Estructura del sitio / Distintas paginas ##

*Login:* Inicio de sesion separado para los distintos tipos de usuarios
(Primer pagina, ademas de corresponder a varias redirecciones)

*Tablero de admin:* Seccion con los botones -> Crear usuario - Ver usuario -> Crear encuesta - Ver encuesta
(Seria una seccion dentro del inicio)

*Inicio Admin:* Tablero de admin -> (si hay)Ultimas encuestas abiertas -> Ultimas encuestas creadas -> Ultimas encuestas cerradas

*Inicio Creador:* Tablero de Creador -> (si hay)Ultimas encuestas propias -> Ultimas encuestas creadas -> Ultimas encuestas cerradas

*Inicio Alumno:* (DISPONIBLES) Ultimas encuestas abiertas -> Ultimas encuestas creadas -> Ultimas encuestas cerradas

*Crear encuesta:* Formulario de creacion de encuestas (Luego redirije a Añadir opciones)

*Añadir opciones:* Seccion para añadir participantes de encuestas ya existentes (Luego redirije a inicio)

*Ver encuesta, SI VOTÓ y/o CERRÓ:* Se muestran los ultimos resultados registrados por la encuesta. Grafico de lineas con el total de votos y el porcentaje de cada opcion (A DESARROLLAR) *Si no votó, se lo redirige a votar*

*Votar encuesta:* Se muestra la encuesta completa, junto con sus opciones para votar

*Editar encuesta:* Formulario precargado con una encuesta editable que comprueba que seas el creador o admin

*Usuarios:* Listado de usuarios creados

*Crear usuario:* Creacion de usuarios

*ver Usuario:* Seccion para editar y consultar datos de usuarios (quizas Boton hacia mis encuestas)

*Mis encuestas:* Pagina que hace un select con todas las encuestas creadas por el usuario con la ID traida del perfil

*Ayuda:* Seccion explicativa sobre el sistema. Al admin le debera enseñar el funcionamiento logico del sistema y como usar las funciones que tiene en su poder, algo similar para el Creador. Para el usuario tipo Alumno quizas se explique el uso de sus datos dentro del sistema y como es la logica que siguen las encuestas

*Documentacion/Replicar:* Esto seria una seccion tambien explicativa, pero mas enfocada en el funcionamiento del codigo y documentacion.(No es prioridad, seguro sea lo ultimo ultimo que haga del proyecto)

(Aun estoy viendo como implementar una especie de buscador o filtro para encuestas, pero mientras la idea seria que haya distintas secciones tipo "Encuestas recientes", "Encuestas abiertas", "Encuestas populares" etc siendo todas la misma pagina, cambiando solo la sentencia sql para traer distintas encuestas en distintos ordenes )

## Ejemplo practico, con el rol de cada usuario ##

*(Profesor/Creador)* desea consultar a todos los alumnos del segundo año de sistemas por su desempeño como profesor el año anterior. Acude al *(Preceptor/Admin)* para que le cree un usuario  y poder empezar a emitir encuestas.

Una vez  que *(Preceptor/Admin)* crea el respectivo usuario, *(Profesor/Creador)* ingresa al sistema, inicia sesion y crea la encuesta con los debidos filtros y personalizacion.

Por ultimo, el *(Alumno/Votante)* ingresa en el sistema en el rango del tiempo que se haya pactado, si está dentro del filtro se muestra la encuesta y le permite verla a detalle, siendo capaz de ver las opciones a votar. Luego de votar, el alumno podria ver los resultados actualizados con su voto, podria hacer publico su voto y podria ver los votos de los demas compañeros que hayan querido hacer publicas sus elecciones, todo esto si el *(Profesor/Creador)* lo permite dentro de la misma encuesta.

(A DESARROLLAR)Una vez votado, se consultara si desea hacer publico su nombre en los resultados 

# Datos de ejemplo #

> ### Datos que componen una encuesta
> - Nombre de la encuesta
> - Descripcion
> - Fecha de inicio y fin
> - Tipo de apariencia (A DESARROLLAR)
> - Carreras que votan
> - Años que votan
> - Multiple Choice
> - Visibilidad de resultados
> - Opciones y/o Candidatos

> ### Encuesta de ejemplo
> - Elecciones KAI 2025
> - "Este año lectivo 2025 elegiremos a los represen..."
> - 02/05/2025 - 09/05/2025
> - Apariencia 5
> - Todas las carreras
> - Todos los años
> - Multiple Choice SI
> - Resultados publicos

> ### Datos que componen un candidato
> - Nombre completo
> - Informacion relevante para el votante ( 500 caracteres )
> - Edad ( Opcional )
> - Carrera ( Opcional )
> - Foto del candidato

> ### Datos que componen una opcion
> - Titulo de opcion
> - Informacion relevante para el votante ( 500 caracteres )
> - Foto de la opcion

> ### Candidato de ejemplo ( Eleccion KAI )
> - Eber Exequiel Soria
> - "Quisiera proponer una mejor organizaci..."
> - 23
> - Foto del alumno

> ### Opcion de ejemplo ( Eleccion de materias Promocionales )
> - Ingles II
> - "Profe: Mariano Moreno"
> - Foto del profe (?)

- Verificaciones de usuarios 
¿Que estudiantes podran votar? Los que esten registrados en la base de datos del instituto.
La pagina pedira como credenciales el DNI, Legajo.
NOTA: Se supone que son credenciales de inicio, en el futuro podrian cambiarse a gusto


## BASE DE DATOS ## (Ultimamente estoy realizando algun que otro cambio, asi que no es la BD final)
Nombre: BD_SURVEYS
Tablas:

POLLS

ID_POLL ( VARCHAR ) [PRIMARY_KEY]
NAME_POLL ( VARCHAR 100 ) NOT NULL
INFO_POLL ( VARCHAR 255 )
STARTDATE_POLL ( DATETIME ) NOT NULL
ENDINGDATE_POLL ( DATETIME ) NOT NULL
VISIBILITY_POLL ( BOOLEAN )
COLOUR_POLL ( TINYINT )
RANGE_POLL ( VARCHAR 50 )
STATUS TINYINT DEFAULT 1


OPTIONS

ID_OPTION ( VARCHAR ) [PRIMARY_KEY]
ID_POLL ( VARCHAR ) [FOREIGN_KEY]
TITLE_OPTION ( VARCHAR 100 ) NOT NULL
INFO_OPTION ( VARCHAR 255 )
VOTES_OPTION ( INT ) 
STATUS TINYINT DEFAULT 1
PHOTO_OPTION ( VARCHAR 255 )  

CANDIDATES

ID_CANDIDATE ( VARCHAR ) [PRIMARY_KEY]
ID_POLL ( VARCHAR ) [FOREIGN_KEY]
NAME_CANDIDATE ( VARCHAR 100 ) NOT NULL
INFO_CANDIDATE ( VARCHAR 255 )
AGE_CANDIDATE ( TINYINT )
CARER_CANDIDATE ( VARCHAR 20 )
PHOTO_CANDIDATE ( VARCHAR 255 )  
VOTES_CANDIDATE ( INT )
STATUS TINYINT DEFAULT 1

VOTES

ID_VOTE ( VARCHAR ) [PRIMARY_KEY]
ID_OPTION ( VARCHAR ) [FOREIGN_KEY]
ID_CANDIDATE ( VARCHAR ) [FOREIGN_KEY]
USER_IDENTIFIER ( VARCHAR ) NOT NULL
STATUS TINYINT DEFAULT 1

USERS

ID_USER ( VARCHAR ) [PRIMARY_KEY]
USERNAME ( VARCHAR )
PASSWORD_HASH ( VARCHAR )
ROLE ( VARCHAR ) NOT NULL
STATUS TINYINT DEFAULT 1

-Expectativa-
Mi meta con este proyecto es que por lo menos sea de utilidad, que funcione para lo que fue pensado, de maneria simple y directa. Por ahora para el proyecto solo pretendo entregar la logica del mismo, sin ser una prioridad la estetica, sin embargo, una vez cerrado y calificado el proyecto mi idea es darle un buen front-end y una interfaz simple, limpia y sobria. La idea tambien es poder exponerlo dentro de mi curriculum como programador, creo que podria ser bastante llamativo si queda como lo tengo planeado. Tambien quiero dejar el codigo libre y las instrucciones basicas para que sea facilmente replicable por cualquiera. 

# FUNCIONAMIENTO #

La idea de este proyecto es que sea acoplable a entornos con bases de datos ya definidas, esto ya que el sistema no contiene los datos de los votantes, solo hace las gestiones de encuestas, usuarios especiales y permisos basado en roles.

Para determinar y tambien validar los votos de los alumnos, se hace una consulta a la base de datos de la institucion preguntando por 2 datos**: 

**DOCUMENTO** DNI/CUIT o cualquier tipo de Identificador que este registrado en la db del instituto.

**IDENTIFICADOR INSTITUCIONAL** LEGAJO/ID o cualquier identificador del usuario dentro del mismo instituto.

Con esto podremos dar con el usuario y traer temporalmente la info que necesitemos. Dentro del sistema se almacenaria solamente el identificador para poder registrar su voto y tambien se almacenaria su nombre y apellido para hacer publica su eleccion (si éste lo desea).




Una vez

Estos 2 datos la idea es que sea a eleccion a futuro
Por eso es que hay planes a futuro de pulir mucho mas este apartado. El objetivo final del "sistema de acoplamiento" seria poder parametrizar desde el .env las tablas en donde se encuentra la informacion de los usuarios en las bases de datos ajenas.

## Desarrollo ##

## Despliegue ##