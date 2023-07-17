<?php

namespace Bojian\PictureProcess\Process;

/**
 * PhantomjsClient.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/17 3:49 PM
 * @version 0.1
 */

class PhantomjsClient {

    /**
     * phantomjs官网地址：https://phantomjs.org/
     * 定义客户端逻辑
     * @var array
     */
    protected $route = [
        'version' => 'getVersion', // 获取版本号
        'screenshot' => 'setScreenshot', // 生成截图
    ];

    /**
     * 获取请求方法
     * @var array
     */
    public $function = 'getErrorData';

    /**
     * 错误信息
     * error_code_1 : route is empty 「路由不存在」
     * error_code_2 : phantomjs exec error 「phantomjs执行失败」
     */
    public const ERROR_MESSAGE = [
        1 => 'route is empty', // 路由不存在
        2 => 'phantomjs exec error', // phantomjs执行失败
    ];
    public $_ERROR_CODE;
    protected $error;
    protected $message;

    /**
     * 配置图片属性
     */
    protected $params = [];
    protected $screenshotUrl; //截图地址
    protected $width = 375;   //图片宽度 默认:375
    protected $height = 10000; //图片高度 默认:10000
    protected $size = 2;   //网页放大倍数(默认2,建议2,网页放大2倍已经足够清晰，倍数越大，图片越大)
    protected $time = 2; //渲染时间，默认200毫秒
    protected $extParam;   //扩展参数
    protected $unsetPicture = false; //是否删除图片 false-不删除 true-删除 默认:false

    /**
     * 程序执行配置
     */
    protected $phantomjs;
    protected $picturePath;
    protected $screenshotJs;

    /**
     * PhantomjsClient constructor.
     * @param string $route
     * @param array $params
     */
    public function __construct(string $route, array $params = [])
    {
        $this->params = $params;
        $this->function = $this->route[$route] ?? '';

        if (empty($this->function)) {
            $this->_ERROR_CODE = 1;
            $this->function = 'getErrorData';
        }
        /**
         * 加载配置信息
         */
        $this->phantomjs = Helper::getEnv('phantomjs.phantomjs_path');
        $this->picturePath = Helper::getEnv('phantomjs.picture_path');
        $this->screenshotJs = Helper::getEnv('phantomjs.screenshot_path');
        $this->time = $this->params['time'] ?? $this->time;
        $this->width = $this->params['width'] ?? $this->width;
        $this->height = $this->params['height'] ?? $this->height;
        $this->extParam = $this->params['ext_param'] ?? $this->extParam;
        $this->screenshotUrl = $this->params['screenshot_url'] ?? $this->screenshotUrl;
        $this->unsetPicture = $this->params['unset_picture'] ?? $this->unsetPicture;
    }

    /**
     * Client version.
     */
    public const VERSION = '1.0.0';

    /**
     * 获取返回结果
     * @return mixed
     */
    public function getResult()
    {
        return $this->{$this->function}();
    }

    /**
     * 获取版本号
     * @return string
     */
    protected function getVersion()
    {
        return self::VERSION;
    }

    /**
     * 获取错误信息
     * @return array
     */
    protected function getErrorData()
    {
        return [
            'error_code' => $this->_ERROR_CODE,
            'message' => self::ERROR_MESSAGE[$this->_ERROR_CODE] ?? '',
        ];
    }

    /**
     * 生成截图
     * @param array extParam  扩展配置信息
     * @param string screenshotUrl 截图地址
     * @param int width 图片宽度
     * @param int height 图片高度
     * @param int size 网页放大倍数
     * @param int time 渲染时间
     * @param bool unsetPicture 是否删除生成图片
     *
     * @return array|string
     */
    protected function setScreenshot()
    {
        $this->extParam = empty($this->extParam) ? null : http_build_query($this->extParam);
        $url = urlencode(empty($this->extParam) ? $this->screenshotUrl : sprintf('%s?%s', $this->screenshotUrl, $this->extParam));
        $filePath = sprintf('%s/picture/%s.jpg', $this->picturePath, md5(time().rand(1,99999)));
        $command = "$this->phantomjs $this->screenshotJs $url $filePath $this->width*$this->size $this->height*$this->size $this->size $this->time";
        $result = @exec($command);

        if ('success' !== $result) {
            $this->_ERROR_CODE = 2;
            return $this->getErrorData();
        }

        // 返回图片base64信息
        $imgBase64 = Helper::imgToBase64($filePath);
        $this->unsetPicture && @unlink($filePath);
        return $imgBase64;
    }
}
