# Zapatería Kicks & Co.

Un proyecto Fullstack de e-commerce premium para la venta de zapatillas y calzado, con conexión a una base de datos MySQL (Zapatería).

## Características principales
- **Diseño Premium**: Interfaz de usuario con estética moderna, dark mode, glassmorphism y tipografía elegante.
- **Catálogo Dinámico**: Listado de productos extraídos directamente de la base de datos `zapateria`.
- **Filtros por Categoría**: Los usuarios pueden filtrar zapatos por categoría sin recargar la página gracias a JavaScript.
- **Carrito de Compras**: Posibilidad de añadir productos al carrito y realizar el checkout directamente hacia la base de datos (registrando las ventas y actualizando el stock).
- **Backend PHP**: API y scripts que se comunican con MySQL utilizando PDO y declaraciones preparadas para mayor seguridad.

## Tecnologías Utilizadas
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla), Lucide Icons
- **Backend**: PHP 8+
- **Base de Datos**: MySQL

## Instrucciones de Instalación
1. Importa el archivo de base de datos o ejecuta el script SQL proveído para crear la base de datos `zapateria`.
2. Clona este repositorio o cópialo a la carpeta de tu servidor web local (como `htdocs` en XAMPP o `www` en WAMP).
3. Asegúrate de configurar tus credenciales en el archivo `db.php` si son diferentes a `root` / `""`.
4. Abre `http://localhost/EntregableFullstack` en tu navegador.
