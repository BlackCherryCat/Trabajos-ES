Para reproducir la estructura necesaria para usar este programa usamos docker compose:
```docker compose up -d```
Ejecutando este comando en la carpeta donde tengas el docker-compose.yml te creara los contenedores y una estructura similar a la que hay en data.
Es necesario tener dentro de la carpeta nginx y vhosts los mismos contenidos que tiene las carpetas nginx y vhosts de data y dentro de httpdocs de php pones la carpeta del proyecto a ejecutar.
Entonces ahora en php pasaremos a usar:
```php
$server = 'db';
$user = 'root';
$passwd = 'root';
$bd = 'GestionReservas';
$db = mysqli_connect($server, $user, $passwd, $bd);
```