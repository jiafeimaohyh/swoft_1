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
use App\Components\LoadBalance\RandLoadBalance;

class Provider implements ProviderInterface
{
    protected  $serviceName;
    public function __construct($serviceName)
    {
       $this->serviceName=$serviceName;
    }

    public  function  getList(Client $client): array
    {

        $config = bean('config')->get('provider.consul');
        $address = bean('consulProvider')->getServerList($this->serviceName, $config);
        //负载均衡(加权随机)
        //$address = RandLoadBalance::select(array_values($address))['address'];
        $address = RandLoadBalance::select(array_values($address));
        var_dump($address);
        //根据服务名称consul当中获取动态地址
        return [$address['address']];
    }
}