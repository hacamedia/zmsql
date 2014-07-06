
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

## *Licencia* ##
----

 >This program is free software: you can redistribute it and/or modify
 >it under the terms of the GNU General Public License as published by
 >the Free Software Foundation, either version 3 of the License, or
 >(at your option) any later version.
 >
 >This program is distributed in the hope that it will be useful,
 >but WITHOUT ANY WARRANTY; without even the implied warranty of
 >MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 >GNU General Public License for more details.
 >
 >You should have received a copy of the GNU General Public License
 >along with this program. If not, see <http://www.gnu.org/licenses/>.
 
 ----
