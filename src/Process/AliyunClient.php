<?php
/**
 * AliyunClient.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/14 5:20 PM
 * @version 0.1
 */

namespace Bojian\PictureProcess\Process;

class AliyunClient
{
    /**
     * 定义客户端逻辑
     * @var array
     */
    protected $route = [
        'version' => 'getVersion', // 获取版本号
        'pictureWatermark' => 'setPictureWatermark', // 生成水印图片
    ];

    /**
     * 获取请求方法
     * @var array
     */
    public $function = 'getErrorData';

    /**
     * 错误信息
     * error_code_1 : route is empty 「路由不存在」
     */
    public const ERROR_MESSAGE = [
        1 => 'route is empty', // 路由不存在
    ];
    public $_ERROR_CODE;
    protected $error;
    protected $message;
    protected $params = [];

    /**
     * AliyunClient constructor.
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
    }

    /**
     * Client version.
     */
    public const VERSION = '1.0.0';

    /**
     * 获取版本号
     * @return string
     */
    protected function getVersion()
    {
        return self::VERSION;
    }

    /**
     * 生成水印图片
     * @return string
     */
    protected function setPictureWatermark()
    {
        return 'setPictureWatermark';
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
     * 获取返回结果
     * @return mixed
     */
    public function getResult()
    {
        return $this->{$this->function}();
    }

}
