<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;

use App\Process\TestProcess;
use App\Storage\ChatMessage;
use App\Storage\OnlineUser;
use App\WebSocket\WebSocketEvents;
use App\WebSocket\WebSocketParser;
use EasySwoole\Component\Process\Manager;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\FastCache\Cache;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Socket\Dispatcher;
use EasySwoole\WordsMatch\WordsMatchServer;
use swoole_server;
use swoole_websocket_frame;
use \Exception;

class EasySwooleEvent implements Event
{
    public static function initialize()
    {
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * 服务启动前
     * @param EventRegister $register
     * @throws Exception
     */
    public static function mainServerCreate(EventRegister $register)
    {
        $server = ServerManager::getInstance()->getSwooleServer();

        OnlineUser::getInstance();
        ChatMessage::getInstance();
        Cache::getInstance()->setTempDir(EASYSWOOLE_ROOT . '/Temp')->attachToServer($server);

        // 注册服务事件
        $register->add(EventRegister::onOpen, [WebSocketEvents::class, 'onOpen']);
        $register->add(EventRegister::onClose, [WebSocketEvents::class, 'onClose']);

        // 收到用户消息时处理
        $conf = new \EasySwoole\Socket\Config;
        $conf->setType($conf::WEB_SOCKET);
        $conf->setParser(new WebSocketParser);
        $dispatch = new Dispatcher($conf);
        $register->set(EventRegister::onMessage, function (swoole_server $server, swoole_websocket_frame $frame) use ($dispatch) {
            $dispatch->dispatch($server, $frame->data, $frame);
        });

        //words-match
        WordsMatchServer::getInstance()
            ->setDefaultWordBank('/Users/zhaoqingyang/es/demo/comment.txt')
            ->setProcessNum(3)
            ->setSeparator(',')
            ->attachToServer(ServerManager::getInstance()->getSwooleServer());
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {

    }
}