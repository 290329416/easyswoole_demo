<?php

namespace App\HttpController;

use App\Event\TestEvent;
use App\Process\TestProcess;
use App\Utility\ReverseProxyTools;
use EasySwoole\Component\Process\Manager;
use EasySwoole\Component\WaitGroup;
use EasySwoole\EasySwoole\Config;
use EasySwoole\EasySwoole\ServerManager;
use EasySwoole\EasySwoole\Task\TaskManager;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Http\Message\Status;
use http\Client\Curl\User;
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Http\Client;

/**
 * Class Index
 * @package App\HttpController
 */
class Index extends Base
{
    public $user_id;

    function index()
    {
        $hostName = $this->cfgValue('WEBSOCKET_HOST', 'ws://127.0.0.1:9501');
        $this->render('index', [
            'server' => $hostName
        ]);

    }

    function test(){
        echo 'Hello test';
    }

    function testa(){
//        var_dump($this->user_id);
//        $this->user_id = 1;
//        var_dump($this->user_id);
//        $this->response()->write('testa');
//        $this->actionNotFound('testa');


//        $Channel = new Channel(12);
//        $WaitGroup =  new WaitGroup();
//        for ( $i=1; $i<=12; $i++ ){
//            $WaitGroup->add();
//            go(function () use($Channel,$i){
//                $num  = rand(1,3);
//                \co::sleep($num);
//                $Channel->push('这是第'.$i.'月数据,随机数为'.$num);
//                $WaitGroup->done();
//            });
//        }
//        $WaitGroup->wait();
//        while (true){
//            if($Channel->isEmpty()){
//                break;
//            }
//            echo $Channel->pop().PHP_EOL;
//        }
//        echo '==================';


//        $chan = new Channel(2);
//        go(function () use ($chan) {
//            \co::sleep(1);
////            $cli = new Client('www.easyswoole.com', 80);
////            $cli->get('/');
//            $chan->push(1111);
//        });
//        go(function () use ($chan) {
//            \co::sleep(2);
////            $cli = new Client('www.baidu.com', 80);
////            $cli->get('/');
//            $chan->push(222);
//        });
//        $result = [];
//        for ($i = 0; $i < 2; $i++)
//        {
//            $result[] = $chan->pop();
//        }
//        var_dump($result);

        echo '==========';
    }


    function task(){
        $task = TaskManager::getInstance();
        $task->async(function (){
            echo "异步调用task1开始\n";
        },function (){
            echo "异步调用task1结束\n";
        });
        $data =  $task->sync(function (){
            echo "同步调用task2\n";
            return "1123121\n";
        });
        $this->response()->write($data);
    }


    protected function onRequest(?string $action): ?bool
    {
//        echo $action;
//        $this->response()->write($action);
//        $this->response()->write('request');
        return  true;
    }

    function onException(\Throwable $throwable): void
    {
        var_dump($throwable->getMessage());
    }

    protected function actionNotFound(?string $action): void
    {
        $this->response()->withStatus(Status::CODE_NOT_FOUND);
        $this->response()->write('action not found');
    }


}
