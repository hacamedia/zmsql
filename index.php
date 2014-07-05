<?

include('ZMSQL.php');

$zm = new ZMSQL('root','','zme_database');

$como = 'hoa';
$a = '14';
 $data = $zm->select("tb_zmTRM")
 			->where("term =?", $como)
 			->where("id =?", $a)
 			->setOperator('OR')
 			->where("value =?", 'ok')
 			->order("id", "DESC")
 			->run();


print_r('<pre>');
print_r($data);
print_r('</pre>');

