<?

include('ZMSQL.php');

$zm = new ZMSQL('root','1234','database');

$data = $zm->select("mytable")
            ->distinct('term') // Eliminar valores repetidos
            ->run();//Ejecuta el query.	


print_r('<pre>');
print_r($data);
print_r('</pre>');

