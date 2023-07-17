<?php

/**
 * PhantomjsClientTest.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/17 4:12 PM
 * @version 0.1
 */
use Bojian\Phpunit\BaseApi;

class PhantomjsClientTest extends BaseApi
{
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

        $imageUrl = phantomjsPictureClient('screenshot', $params);
        var_dump($imageUrl);
        $this->assertIsString($imageUrl);
    }
}
