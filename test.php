<?php
use EasySwoole\EasySwoole\Command\CommandRunner;

defined('IN_PHAR') or define('IN_PHAR', boolval(\Phar::running(false)));
defined('RUNNING_ROOT') or define('RUNNING_ROOT', realpath(getcwd()));
defined('EASYSWOOLE_ROOT') or define('EASYSWOOLE_ROOT', IN_PHAR ? \Phar::running() : realpath(getcwd()));

$file = EASYSWOOLE_ROOT.'/vendor/autoload.php';
if (file_exists($file)) {
    require $file;
}else{
    die("include composer autoload.php fail\n");
}

//$server = new Swoole\Http\Server("0.0.0.0", 9501);
//$server->set([
//    'worker_num'=>1//设置1个进程进行处理
//]);
//$server->on('Request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
//    //模拟当前任务处理特别繁忙的情况,sleep不会自动切换协程,3秒后代表处理完毕.给浏览器返回数据
//    //此例子也可以代表处理io阻塞时,例如mysql查询耗时3秒,但用的不是swoole的 mysql协程客户端
//    $time = time();
//    var_dump($time);
//    while(time()-$time<=3) {
//
//    }
//    $response->end("test1");//相当于此次请求必须3秒内返回,又因为协程没有做切换,所以第二个请求需要3秒后才能开始处理....
//});
//$server->start();


$server = new Swoole\Http\Server("0.0.0.0", 9501);
$server->set([
    'worker_num' => 1//设置1个进程进行处理
]);
$server->on('Request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    $user = 'tioncico';
    var_dump(time());
    co::sleep(3);//假设查询$user需要3秒,在使用协程mysql客户端时,会自动切换,查询完自动恢复协程.
    $response->end($user);//相当于此次请求必须3秒内返回,又因为协程没有做切换,所以第二个请求需要3秒后才能开始处理....
});
$server->start();