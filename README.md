## Dinámica

### Sprint 1: Preparación

1. **Crea un fork del repositorio:**

   - Ve al repositorio original y haz clic en el botón "Fork" para crear tu propia copia en tu cuenta.

2. **Clona el repositorio en tu máquina:**

   ```bash
   git clone <URL-de-tu-repositorio>
   ```

3. **Comprueba que puedes hacer commit y push:**

   - Crea un archivo de prueba:
     ```bash
     echo "Prueba de commit" > prueba.txt
     ```
   - Haz commit y push:
     ```bash
     git add prueba.txt
     git commit -m "Comprobando commit y push"
     git push origin main
     ```

4. **Comprueba que tienes la sesión iniciada en Docker Hub:**

   - Inicia sesión:
     ```bash
     docker login
     ```
   - Introduce tus credenciales de Docker Hub.

### Sprint 2: Apache

1. **Crea una carpeta llamada ****`apache`**** y dentro un archivo llamado ****`Dockerfile`****:**

   ```bash
   mkdir apache
   cd apache
   touch Dockerfile
   ```

2. **Configura el Dockerfile para un servidor Apache:**

   ```Dockerfile
   FROM httpd:2.4
   COPY ./index.html /usr/local/apache2/htdocs/
   ```

3. **Crea un archivo ****`index.html`****:**

   ```html
   <!DOCTYPE html>
   <html>
   <body>
       <h1>Hola Mundo</h1>
   </body>
   </html>
   ```

4. **Construye y lanza la imagen:**

   ```bash
   docker build -t apache-server .
   docker run -d -p 8080:80 apache-server
   ```

5. **Documentación:**

   - Documenta los pasos en el archivo `README.md`.

### Sprint 3: Apache + PHP

1. **Copia la carpeta ****`apache`**** y renómbrala a ****`apache-php`****:**

   ```bash
   cp -r apache apache-php
   cd apache-php
   ```

2. **Modifica el Dockerfile para incluir PHP:**

   ```Dockerfile
   FROM php:7.4-apache
   COPY ./index.php /var/www/html/
   ```

3. **Crea un archivo ****`index.php`****:**

   ```php
   <?php
   echo "<h1>Hola Mundo</h1>";
   echo "<p>Fecha y hora actual: " . date('Y-m-d H:i:s') . "</p>";
   echo "<p>Versión de PHP: " . phpversion() . "</p>";
   echo "<p>Versión de Apache: " . apache_get_version() . "</p>";
   echo "<p>IP del servidor: " . $_SERVER['SERVER_ADDR'] . "</p>";
   echo "<p>IP del cliente: " . $_SERVER['REMOTE_ADDR'] . "</p>";
   ?>
   ```

4. **Construye y lanza la imagen:**

   ```bash
   docker build -t apache-php-server .
   docker run -d -p 8080:80 apache-php-server
   ```

5. **Documenta los pasos en el archivo ****`README.md`****.**

### Sprint 4: PHP

1. **Crea un archivo ****`info.php`****:**

   ```php
   <?php
   phpinfo();
   ?>
   ```

2. **Crea un archivo ****`random.php`****:**

   ```php
   <?php
   $number = rand(1, 100);
   $elements = ["Elemento1", "Elemento2", "Elemento3", "Elemento4", "Elemento5"];
   echo json_encode([
       "random_number" => $number,
       "parity" => $number % 2 === 0 ? "par" : "impar",
       "random_element" => $elements[array_rand($elements)]
   ]);
   ?>
   ```

3. **Construye y lanza la imagen:**

   ```bash
   docker build -t apache-php-random .
   docker run -d -p 8080:80 apache-php-random
   ```

4. **Documenta los pasos en el archivo ****`README.md`****.**

### Sprint 5: Composing con Apache + PHP + MySQL

1. **Crea una carpeta ****`apache-php-mysql`**** y dentro un archivo ****`docker-compose.yml`****:**

   ```yml
   version: '3.8'
   services:
     web:
       build: ./apache-php
       ports:
         - "8080:80"
     db:
       image: mysql:5.7
       environment:
         MYSQL_ROOT_PASSWORD: root
         MYSQL_DATABASE: examen
       volumes:
         - db_data:/var/lib/mysql
   volumes:
     db_data:
   ```

2. **Crea un archivo ****`init.sql`****:**

   ```sql
   CREATE DATABASE examen;
   USE examen;
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100),
       password VARCHAR(100)
   );
   INSERT INTO users (name, password) VALUES ('user1', 'pass1'), ('user2', 'pass2');
   ```

3. **Copia la carpeta ****`apache-php`**** dentro de ****`apache-php-mysql`****.**

4. **Modifica ****`index.php`**** para conectar a MySQL:**

   ```php
   <?php
   $conn = new mysqli('db', 'root', 'root', 'examen');
   if ($conn->connect_error) {
       die("Conexión fallida: " . $conn->connect_error);
   }
   echo "Conexión exitosa a la base de datos.";
   ?>
   ```

5. **Crea un archivo ****`users.php`****:**

   ```php
   <?php
   $conn = new mysqli('db', 'root', 'root', 'examen');
   $result = $conn->query("SELECT * FROM users");
   while ($row = $result->fetch_assoc()) {
       echo "<p>ID: {$row['id']} - Name: {$row['name']}</p>";
   }
   ?>
   ```

6. **Construye y lanza el entorno completo:**

   ```bash
   docker-compose up --build
   ```

7. **Crea un contenedor en Docker Hub:**

   ```bash
   docker tag apache-php-mysql <tu-usuario>/apache-php-mysql
   docker push <tu-usuario>/apache-php-mysql
   ```

8. **Actualiza la página principal en Docker Hub:**

   - Proporciona el comando:
     ```bash
     docker run -d -p 8080:80 <tu-usuario>/apache-php-mysql
     ```

9. **Documenta los pasos en el archivo ****`README.md`****.**

10. **Haz commit y push a tu repositorio:**

    ```bash
    git add .
    git commit -m "Finalizando examen"
    git push origin main
    ```

