#Software Amigo
El propósito del software amigo es brindad agilidad, control y organización al jefe líder de talleres o mecánicos que requieran llevan un mayor
control al momento de gestionar las órdenes de trabajo en su taller o centro de mecánica automotriz ya que podra asignar órdenes de trabajo ha 
determinado vehículo, además de asignarle un mecánico líder del trabajo.

##Versión 5
La versión 5 del software Amigo es una versión cuya interfaz está inspirada en el sistema operativo de Microsoft: **Windows Longhorn**.

El sistema utiliza JavaScript, PHP, HTML y Css. Su interfaz se construyo sobre una plantilla web, la cual se adaptó para darle es estilo de Windows Longhorn M5. Lo elaboré usando el servidor local XAMMP, usando PhpMyAdmin. La base de datos se incluye en este repositorio

###LogIn
IDENTIFICACIÓN DEL USUARIO:
12345
Contraseña: 
123

###Importante
Lamentablemente,  al no encontrar una empresa de programación que me brindara la oportunidad de hacer parte de su equipo de trabajo, 
tuve que suspender la elaboración de este proyecto para empezar a trabajar y buscar otras alternativas para mi sustento. Si embargo, 
espero terminar este proyecto a finales de año cuando si situación financiera mejore.

###Pendientes
Algunos pendientes en este proyecto son:
- Agregar encriptación al log-in
- Agregar la opción de editar vehículo
- Agregar funcionalidad al menú de opciones en la vista detalle vehículo
- Permitir al usuario agregar fotos a la orden de trabajo
- Permitir agregar foto del vehículo al momento de registrarlo
- Añadir funcionalidad Responsive Design


###Funcionamiento
La primera vez que el usuario instala la aplicación, debe ir al menú desplegable, seleccionar la opción Atributos y allí:
- Agregar los tipos de servicios a prestar
- Agregar los tipos de vehículos a los cuales se les prestara servicio (Autos, Volquetas, Camiones, etc.)
- Luego, ir a la opción Mecánicos situada en la barra superior, allí debe registrar los mecánicos líderes de los servicios prestados.

estos registros quedarán almacenados en la base de datos amigo. De esa manera podrá crear órdenes de trabajo, y asignarle un mecánico y el tipo de vehículo previamente registrado.

Puede registrar un nuevo vehículo y asignarle una nueva orden de trabajo, o seleccionar un vehículo previamente registrado y asignar una nueva orden.

El sistema cuenta con un menú contextual (estilo Windows). El cual se despliega al hacer clic sobre una fila en la tabla órdenes o vehículos. Esto brinda una mejor presentación, ya que reemplaza los típicos botones de un CRUD. Al hacer doble clic sobre la fila, abrirá una vista más en detalle de la orden o vehículo seleccionado.
