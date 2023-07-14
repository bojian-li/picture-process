<?php

use Bojian\PictureProcess\Process\AliyunClient;

/**
 * 阿里云图片客户端
 * @param string $route
 * @param array $params
 * @return array|null|string
 */
function aliyunPictureClient(string $route, array $params = [])
{
     $client = new AliyunClient($route, $params);
     return $client->getResult();
}
