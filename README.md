# picture-process
picture process package

### Installation

运行环境要求 PHP 7.2 及以上版本，以及[cURL](http://php.net/manual/zh/book.curl.php)。

#### 灵活配置环境
特点：`html截图`封装在composer包内，定期更新

> composer require bojian/picture-process

#### AliyunClient图片处理调用

.env配置，alifc_url为阿里云图片处理服务地址
```sh
[aliyun]
alifc_url = 
```

```php
$version = aliyunPictureClient('version');
```

#### phantomjs图片处理调用
.env配置；按照机器安装位置配置
```sh
[phantomjs]
;phantomjs的安装路径「compose包中用macosx、linux 64、linux 32、windows运行包在phantomjs文件夹下解压安装本地即可」
phantomjs_path = /Users/libojian/bojian-github/picture-process/phantomjs/macosx-2.1.1/bin/phantomjs
;截图js存放路径
screenshot_path = /Users/libojian/bojian-github/picture-process/extend/exec/screenshot.js
;图片存放路径
picture_path = /Users/libojian/bojian-github/picture-process/screenshot/
```

```php
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

$imageBase64 = phantomjsPictureClient('screenshot', $params);
```

#### 附加图片处理功能
```php
use bojian\pictureProcess\extend\Helper;

//图片转base64
$imgBase64 = Helper::imgToBase64($filePath);

//自定义图片cdn域名
$imageUrl = getImagePath($imagePath)

/**
 * 是否以开头
 * @param      $haystack      //The string to search in
 * @param      $needle        //Note that the needle may be a string of one or more characters
 * @param bool $caseSensitive 大小写敏感 true敏感 false不敏感
 * @return bool
 */
startWith($haystack, $needle, bool $caseSensitive = true)
```
