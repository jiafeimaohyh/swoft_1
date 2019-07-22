<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/5/29
 * Time: 22:27
 */
use Swlib\SaberGM;

namespace App\Components\Consul;

class ConsulProvider
{
    //http://118.24.109.254:8500/v1/agent/services  展示所有的服务
    //http://118.24.109.254:8500/v1/catalog/service/pay-php 某个服务多个服务地址
    //http://118.24.109.254:8500/v1/health/service/pay-php   某个服务多个服务地址并且查看健康的服务

    const REGISTER_PATH='/v1/agent/service/register';
    public  function  registerServer($config){
        echo 'http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH,json_encode($config['register']);
        $this->curl_request('http://' . $config['address'] . ':' . $config['port'] . self::REGISTER_PATH, "PUT", json_encode($config['register']));
            output()->writeln("<success>Rpc service Register success by consul tcp=" . $config['address'] . ":" . $config['port'] . "</success>");
        //注册地址底层错误无法使用
       /* \Swlib\SaberGM::put('http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH,json_encode($config['register']));*/
        //var_dump();


    }

    public  function  getServerList(){
        //排除不健康的服务

    }

    public function curl_request($url, $method = 'POST', $data = [])
    {
        $method = strtoupper($method);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

}