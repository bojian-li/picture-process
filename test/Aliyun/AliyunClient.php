<?php

namespace Tests\Aliyun;

use Bojian\Phpunit\BaseApi;
/**
 * AliyunClient.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/14 6:53 PM
 * @version 0.1
 */
class AliyunClient extends BaseApi
{
    /**
     * 获取版本号
     * @return void
     */
    public function testGetVersion()
    {
        $version = aliyunPictureClient('version');
        $this->assertSame('1.0.0', $version);
    }

    /**
     * 测试错误路由
     * @return void
     */
    public function testErrorRout()
    {
        $result = aliyunPictureClient('error');
        $this->assertSame(1, $result['error_code'] ?? 0);
    }

}
