<?php

namespace App\HttpController;

use EasySwoole\Http\Message\Status;
use EasySwoole\WordsMatch\WordsMatchServer;

/**
 * Class Index
 * @package App\HttpController
 */
class Words extends Base
{
    function index()
    {
        $content = $this->request()->getRequestParam('content');
        $res = WordsMatchServer::getInstance()->search($content);
        $this->writeJson(Status::CODE_OK,$res);
    }

    function add(){
        $text = $this->request()->getRequestParam('text');
        $res = WordsMatchServer::getInstance()->append($text);
        $this->writeJson(Status::CODE_OK,$res);
    }

    function del(){
        $text = $this->request()->getRequestParam('text');
        $res = WordsMatchServer::getInstance()->remove($text);
        $this->writeJson(Status::CODE_OK,$res);
    }
}
