<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/5/25
 * Time: 22:48
 */

namespace App\Rpc\Client;


use Swoft\Rpc\Client\Contract\ProviderInterface;
use Swoft\Rpc\Client\Client;

class Provider implements ProviderInterface
{
    protected  $serviceName;
    public function __construct($serviceName)
     {
         $this->serviceName=$serviceName;
     }

    public  function  getList(Client $client): array
     {

          var_dump($this->serviceName);
          //  bean('consulProvider')->getServerList($this->serviceName);
          //负载均衡，缓存地址
          //根据服务名称consul当中获取动态地址
          return ["127.0.0.1:9508","127.0.0.1:9508"];
          //return [];
     }
}