# Short Links

## Instalación y puesta en marcha de WordPress

Para poner en marcha la instalación de WordPress hay que usar el paquete de  `npm` [@wordpress/env](https://developer.wordpress.org/block-editor/packages/packages-env/).

### Prerequisitos

Tener instalados [Docker](https://docs.docker.com/) y [Node.js](https://nodejs.org)

### Instalación

Instalar el paquete de  `npm` [@wordpress/env](https://developer.wordpress.org/block-editor/packages/packages-env/) de manera global:

```bash
$ npm -g i @wordpress/env
```
Ahora ya está disponible el comando `wp-env`.

### Iniciar el entorno local

Después de haber clonado este repositorio, entrar en la carpeta del proyecto e iniciar el entorno, mediante:

```bash
$ cd wp-short-links
$ wp-env start
```

La primera vez puede tardar unos minutos, dependiendo de la conexion a internet. Ya que se tienen que descargar unas imágenes de docker.

Finalmente el sitio de WordPress estará disponible en [http://localhost:8888](http://localhost:8888).

El panel de administración se encuentra en [http://localhost:8888/wp-admin](http://localhost:8888/wp-admin).

El Usuario es `admin` y la contraseña `password`.

### Detener el entorno local

Se detiene con el siguiente comando:

```bash
$ wp-env stop
```

## Activación del tema y del plugin

La primera vez que se entra al panel de administración es necesario activar el tema de WordPress `Short Links Theme`. Entrando en [http://localhost:8888/wp-admin/themes.php](http://localhost:8888/wp-admin/themes.php).

El plugin `Short Links` tambien hay que activarlo, en [http://localhost:8888/wp-admin/plugins.php](http://localhost:8888/wp-admin/plugins.php)

Estas dos operaciones solo hay que hacerlas la primera vez que se ejecuta el entorno local.

## Estructura de permalinks

Es necesario cambiar la Estructura de los permalink. Hay que ponerlo en `Post name` en la siguiente página: [http://localhost:8888/wp-admin/options-permalink.php](http://localhost:8888/wp-admin/options-permalink.php)

## Descripción del proyecto

## Tests