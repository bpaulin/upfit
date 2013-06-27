<?php
require_once __DIR__.'/vendor/symfony/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'          => __DIR__.'/vendor/symfony/symfony/src'
));
$loader->register();

require_once __DIR__.'/vendor/symfony/symfony/src/Symfony/Component/Yaml/Yaml.php';

use Symfony\Component\Yaml\Yaml;

$array = Yaml::parse(file_get_contents('app/config/parameters.yml'));

$user = $array['parameters']['database_user'];
$pass = $array['parameters']['database_password'];
$host = $array['parameters']['database_host'];
$base = $array['parameters']['database_prod'];

$file = $base . '_' . date("Y-m-d-H-i-s") . '.gz';
$dir =  __DIR__.'/dumps';
if (!is_dir($dir)) {
    mkdir($dir);
}
$command = "mysqldump --opt -h $host -u $user -p$pass $base | gzip > $dir/$file";
system($command);
