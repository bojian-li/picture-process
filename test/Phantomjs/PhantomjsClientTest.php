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
     * @param array extParam  扩展配置信息
     * @param string screenshotUrl 截图地址
     * @param int width  图片宽度
     * @param int height 图片高度
     * @param int size 网页放大倍数 默认:2
     * @param int time 渲染时间
     * @param bool unsetPicture 是否删除生成图片
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
            'unset_picture' => true, //是否删除生成图片 false-不删除 true-删除 默认:false
        ];

        $imageUrl = phantomjsPictureClient('screenshot', $params);
        var_dump($imageUrl);
        $this->assertIsString($imageUrl);
    }
}
