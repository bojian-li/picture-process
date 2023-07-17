<?php

use Bojian\PictureProcess\Process\OssPath;
use Bojian\PictureProcess\Process\AliyunClient;
use Bojian\PictureProcess\Process\PhantomjsClient;

/**
 * 是否以开头
 * @param      $haystack      //The string to search in
 * @param      $needle        //Note that the needle may be a string of one or more characters
 * @param bool $caseSensitive 大小写敏感 true敏感 false不敏感
 * @return bool
 */
function startWith($haystack, $needle, bool $caseSensitive = true): bool
{
    return $caseSensitive ? str_starts_with($haystack, $needle) : 0 == stripos($haystack, $needle);
}

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

/**
 * Phantomjs图片客户端
 * @param string $route
 * @param array $params
 * @return array|null|string
 */
function phantomjsPictureClient(string $route, array $params = [])
{
    $client = new PhantomjsClient($route, $params);
    return $client->getResult();
}

/**
 * 获取图片路径
 * @return string
 */
function getImagePath($imagePath = '', $cdn = OssPath::CDNPATH_IMG)
{
    if (empty($imagePath)) {
        return '';
    }

    if (startWith($imagePath, 'http')) {
        return $imagePath;
    }

    return $cdn . '/' . ltrim($imagePath, '/');
}
