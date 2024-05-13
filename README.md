<h1># Panelly</h1>

<p>Breve descripción del proyecto.</p>

<h2>Instalación</h2>

<ol>
  <li>Clona este repositorio: <code>git clone https://github.com/sunshine772/panelly.git</code></li>
  <li>Navega al directorio del proyecto: <code>cd panelly</code></li>
  <li>Instala las dependencias: <code>composer install o composer update</code></li>
  <li>Copia el archivo de configuración de entorno: <code>cp .env.example .env</code></li>
  <li>Genera la clave de la aplicación: <code>php artisan key:generate</code></li>
  <li>Configura tu archivo <code>.env</code> con los detalles de tu base de datos MySQL</li>
  <li>Ejecuta las migraciones de la base de datos: <code>php artisan migrate</code></li>
  <li>Inicia el servidor de desarrollo: <code>php artisan serve</code></li>
</ol>

<h2>Configuración con XAMPP</h2>

<p>Si estás utilizando XAMPP para tu entorno de desarrollo, sigue estos pasos adicionales:</p>

<ol>
  <li>Asegúrate de que XAMPP esté instalado y en funcionamiento en tu máquina.</li>
  <li>Crea una nueva base de datos en MySQL utilizando phpMyAdmin o la interfaz de línea de comandos de MySQL.</li>
  <li>Configura tu archivo <code>.env</code> con los siguientes detalles:</li>
</ol>

<pre><code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=nombre_de_usuario_de_mysql
DB_PASSWORD=contraseña_de_mysql
</code></pre>

<ol start="4">
  <li>Asegúrate de que Apache y MySQL estén iniciados en XAMPP.</li>
  <li>Ejecuta las migraciones de la base de datos: <code>php artisan migrate</code></li>
</ol>
