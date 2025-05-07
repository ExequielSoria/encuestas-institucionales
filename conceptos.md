# Sistema de Encuestas Institucionales #
Este es un sistema donde los directivos podran crear encuestas dirigidas a estudiantes dentro de un instituto.

RECORDATORIO: Hacer la validacion de usuarios permitidos separado del codigo para hacerlo mas universal


- Tener en cuenta las validaciones de usuarios fuera del terciario/institucion

## Funcionamiento ADMIN ##

En el inicio se veran todas las encuestas disponibles, prioritariamente las que esten activas, seguidas por las inactivas. 
Opcion para crear encuesta en otra pestaña.

Cada tarjeta de encuesta mostrara opciones a elegir sobre esa encuesta, tales como...

Editar:


Ver encuesta: Se podran ver las encuestas de forma grafica


Los `directivos` veran un menu con distintas operaciones sobre las encuestas, tales como ver, crear, editar o borrar una encuesta.

Al crear encuesta salta un modal con un formulario para ingresar los datos de cada encuesta, esto se valida y se carga a la base de datos y por lo tanto al sistema.


**Crear encuesta:** Al crear la encuesta se define toda la informacion sobre esta, siendo posible editarla mas tarde o eliminarla.

> ### Datos que componen una encuesta
> - Nombre de la encuesta
> - Descripcion
> - Fecha de inicio y fin
> - Visibilidad de resultados
> - Opciones

**Opciones de cada encuesta:** 
Cualquier cosa podria ser una opcion de encuesta, pero si se trata de una persona se cuenta con campos especiales los cuales son opcionales.

> ### Datos que componen una opcion (Todos datos publicos)
> - Titulo de opcion / Nombre completo
> - Informacion relevante para el votante ( 500 caracteres )
> - Edad ( Opcional )
> - Carrera ( Opcional )
> - Identificador ( DNI ) ( Opcional )
> - Identificador institucional ( LEGAJO, ID, etc ) ( Opcional )


> ### Opcion de ejemplo, tipo persona ( Eleccion KAI )
> - Eber Exequiel Soria
> - "Quisiera proponer una mejor organizaci..."
> - 23
> - Sistemas
> - 26458242
> - "S1004"

> ### Opcion de ejemplo, tipo sin especificar ( Eleccion de materias Promocionales )
> - Ingles II
> - "Profe: Gabriela Costela"
> - "" ( Vacio )
> - "" ( Vacio )
> - "" ( Vacio )
> - "1123" ( En este caso podria ser la "ID" de la materia dentro del sistema de la institucion, pero podria estar vacio tambien )

> ### Encuesta de ejemplo
> - Elecciones KAI 2025
> - "Este año lectivo 2025 elegiremos a los represen..."
> - 02/05/2025 - 09/05/2025
> - Publicos
> - Candidato 1
> - Candidato 2
> - Candidato 3



> Ver encuesta: Al ver una encuesta se mostrara en pantalla la informacion sobre esta misma en forma de estadisticas. Datos como las opciones a elegir, los votos que recibio cada opcion, algun que otro grafico de barras y el tiempo restante para que se cierren las votaciones.

Porcentajes
Numero de votantes
Numero de votantes restantes ( basado en la bd de todos los estudiantes )



Editar encuesta:

Borrar encuesta:

## CAMPOS DE LAS ENCUESTAS

> Nombre de encuesta (Tipo de encuesta, etc)

iuhiuhi


Descripcion
Descripcion de la encuesta


- Fecha inicio y fin (Cuando se habilita y se cierra la encuesta)
- Transparencia de resultados (Publicos/Privados)
- Opcion 1 (Evidentemente)
- Opcion 2





- Nombre de encuesta --> Elecciones KAI 2025
- Descripcion de la encuesta --> "Este año lectivo 2025 elegiremos a los representantes de..."
- Fecha inicio
- Fecha fin
- Resultados Publicos/Privados
- Opcion 1
- Opcion 2





Aca se cargan los candidatos y se establece la fecha de inicio y final de las elecciones

Editar eleccion


- Datos a cargar por candidato
Cada candidato tendra una lista de datos los cuales son opcionales, esto principalmente para 

-Nombre
-Apellido
-Edad
-Curso
-Carrera
-Descripcion



- Verificaciones de usuarios 
¿Que estudiantes podran votar? Los que esten registrados en la base de datos del instituto.
La pagina pedira como credenciales el DNI, Legajo y


## Funcionamiento USER ##
El usuario entra en la pagina principal, al no estar logeado (Unico login seria el del admin) se mostrara prioritariamente las encuestas activas y luego las que ya estan cerradas.

El usuario podra ingresar a una encuesta activa para votar, el sistema le pedira 2 identificadores, los cuales son el legajo y el dni del alumno

EL USUARIO NO PODRA VER LOS RESULTADOS ANTES DE VOTAR SI LA ENCUESTA ESTA ACTIVA


## BASE DE DATOS

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



> - Titulo de opcion / Nombre completo
> - Informacion relevante para el votante ( 500 caracteres )
> - Edad ( Opcional )
> - Carrera ( Opcional )
> - Identificador ( DNI ) ( Opcional )
> - Identificador institucional ( LEGAJO, ID, etc ) ( Opcional )





La base de datos guardara los siguientes datos

> Encuestas:
> 
> Cuando se crea una encuesta, se guardan solo estos datos
> - survey_id ( INT )
> - survey_name ( VARCHAR 100 )
> - survey_desc ( VARCHAR 800 )
> - survey_init ( DATE )
> - survey_end ( DATE )
> - survey_visibility ( BOOLEAN )

Resultados
> - result_id ( INT )
> - result_survey_id ( INT )
> - 

Opciones:
> - ID
> - ID
> - Titulo de opcion / Nombre completo
> - Informacion relevante para el votante ( 500 caracteres )
> - Edad ( Opcional )
> - Carrera ( Opcional )
> - Identificador ( DNI ) ( Opcional )
> - Identificador institucional ( LEGAJO, ID, etc ) ( Opcional )

Usuarios:

PAGINAS:

LOGIN: Inicio de sesion, no es la primer pagina pero una vez que se intente votar y el sistema note que no esta registrado lo redirecciona al login.

INICIO: Pagina en donde se encuentran todas las encuestas, las activas e inactivas.

CREAR ENCUESTA: Pagina en donde rellenando los campos se puede crear una encuesta personalizada

EDITAR ENCUESTA: Pagina casi identica a la de CREAR ENCUESTA, en donde se pueden editar las encuestas creadas.

VER ENCUESTA: Pagina en donde se ven todos los datos de la encuesta, incluyendo los participantes y la opcion para votar.

ENCUESTAS ACTIVAS:

ENCUESTAS INACTIVAS:

FUNCIONAMIENTO TECNICO DEL PROYECTO:

Crea una encuesta y rellena los campos, estos se guardaran en la base de datos propia del proyecto. 



Login: El login pedira 2 datos para ingresar, siendo estos el DNI del estudiante y su LEGAJO. Una vez ingresado ya podra votar en las encuestas disponibles.


LOGICA:

Cuando cualquier usuario ingresa en la web, lo primero que pide es logearse. Habria 2 logins, uno para votantes (estudiantes con una BD distinta) y otra para creadores/admin(Profes o usuarios que puedan crear encuestas, BD del proyecto).

Una vez ingresado, es redirigido al inicio, donde se muestran las encuestas. y dependiendo del rol del usuario, tendra las opciones para votar y/o ver los resultados o editar/borrar encuestas si es que tiene rol de creador de dicha encuesta o rol de administrador.

Roles:
Administrador: Podra crear/editar/borrar usuarios con rol de creadores, editar/borrar encuestas ajenas.
Creador: Podra crear encuestas y editar/borrar las que sean de su pertenencia.
Usuario: Podra solamente votar en encuestas y ver los resultados si esta permitido.