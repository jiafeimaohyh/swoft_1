<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/5/25
 * Time: 22:45
 */

namespace App\Rpc\Client;

use Swoft\Rpc\Client\Contract\ProviderInterface;

class Client extends \Swoft\Rpc\Client\Client
{
    //protected  $serviceName; //服务名称
    public function getProvider(): ?ProviderInterface
    {

        //切换成curl发生在服务启动之前
        //$config = bean('config')->get('provider.consul');
        //bean('consulProvider')->registerServer($config);
        //不能区分当前调用的服务是哪个
         //return $this->provider=new Provider($this->getServiceName());
         return $this->provider=new Provider();
    }

    /*public  function  getServiceName(){
        return $this->serviceName;
    }*/
}