<?php
namespace Bojian\PictureProcess\Process;

/**
 * OssPath.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/17 2:12 PM
 * @version 0.1
 */

class OssPath {
    // domain
//    const DOMAIN_FILE = 'file.uhouzz.com';
    const DOMAIN_IMG = 'img.uhzcdn.com';//'img.uhomes.com'; //普通图片
    const DOMAIN_IMAGE = 'image.uhzcdn.com';//'image.uhomes.com'; //房源图片
    const DOMAIN_VIDEO = 'video.uhzcdn.com';//'video.uhomes.com'; //视频
    // cdn
    const CDNPATH_IMG = 'https://'.self::DOMAIN_IMG;
    const CDNPATH_IMAGE = 'https://'.self::DOMAIN_IMAGE;
    const CDNPATH_VIDEO = 'https://'.self::DOMAIN_VIDEO;

    /**
     *   字段  记得 key都要大写.
     *
     *  oss的配置为组内对应的bucket cdn域名等
     *
     *  path -> 代表 在 env_path 下级目录下的 路径
     *
     *   比如  https://img.uhouzz.com/testing/images/user/2b/65addc930f0c70ed32f92d95083162245edc98.jpg
     *   path = images/user
     */
    const PATHS = [
        // 房源图片  这里不要再添加了 这个需要加水印的
        'IMAGE' => [
            'oss' => [
                'bucket' => 'uhz-house-images',
                'domain' => self::DOMAIN_IMAGE,
                'watermark' => '',
            ],
            'path' => '',
            'directory' => ['house'],
        ],
        // 视频
        'VIDEO' => [
            'oss' => [
                'bucket' => 'uhz-videos',
                'domain' => self::DOMAIN_VIDEO,
            ],
            'path' => '',
            'directory' => [],
        ],
        // 文件
        'FILE' => [
            'oss' => [
                'bucket' => 'uhz-images',
                'domain' => self::DOMAIN_IMG,
            ],
            'path' => 'files/',
            'directory' => [],
        ],
        // 图片
        'IMG' => [
            'oss' => [
                'bucket' => 'uhz-images',
                'domain' => self::DOMAIN_IMG,
            ],
            'path' => 'images/',
            'directory' => ['customer', 'feedback', 'apply'],
        ],
    ];
}

