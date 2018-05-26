# MysqliCon-php
Class para agilizar a conexão com o servidor mysql.

```php
require("MysqliCon.class.php");

$conection = new MysqliCon();

$conection->end = "localhost";
$conection->db = "my db";
$conection->user = "my user";
$conection->pass = "my pass";
$conection->charset = "utf8"; //default

$con = $conection->conec();

$myQuery = $conection->query($con, "My query INSERT|SELECT|UPDATE|DELETE...");

$conection->fechaCon($con);
```

### Licença
Licensed under the Apache License, Version 2.0
