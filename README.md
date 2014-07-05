# **Clase PHP mysqli** #

----
## **Uso** ##

Para comenzar a usar esta clase, solo basta con incluir el archivo **ZMSQL.php** a tu proyecto


```
#!php

include('ZMSQL.php');
```

Inicializamos la clase.

```
#!php

$zm = new ZMSQL('usuario','password','database' 'host');
```
Reemplazar los datos de acceso correspondientes.

----
usuario -> Nombre de usuario de tu base de datos.

password -> La contraseña con la que ingresas a tu base de datos.

database -> El nombre de tu base de datos.

host [opcional] -> El nombre de tu host (por defecto es localhost)

----

Finalmente hacemos usamos los métodos necesarios.

```
#!php

 $data = $zm->select("tb_tabla")
 			->where("value =?", 'ok')
 			->order("id", "DESC")
 			->run();
```

Para mayor información visita la [wiki](https://bitbucket.org/hacamedia/zmsql/wiki/Home)