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

    /**
     * 测试错误路由
     * @return void
     */
    public function testPictureWatermark()
    {
        $result = aliyunPictureClient('pictureWatermark');
        $this->assertSame('setPictureWatermark', $result);
    }

    /**
     * 获取系统环境变量
     * @return void
     */
    public function testGetEnvironment()
    {
        $result = aliyunPictureClient('environment');
        $this->assertSame('dev', $result);
    }

    /**
     * 生成截图图片URL
     * @return void
     */
    public function testSetScreenshot()
    {
        $params = [
            'screenshot_url' => 'https://poster-test.uhomes.com/groupBuying/shareMerchants',
            'width' => 360,
            'height' => 288,
            'ext_param' => [
                'showType' => 3,
                'coverImg' => 'https://img.uhzcdn.com/testing/ugc/customer/80/460bfc6d9af8a739a3ed18e4ee796269a09316.png',
            ],
        ];

        $imageUrl = aliyunPictureClient('screenshot', $params);
        var_dump($imageUrl);
        $this->assertIsString($imageUrl);
    }

}
