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
        'screenshot' => 'setScreenshot', // 生成截图
        'environment' => 'getSystemEnvironment', // 获取系统环境变量
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
     * 配置图片属性
     */
    protected $screenshotUrl; //截图地址
    protected $width = 375; //图片宽度 默认:375
    protected $height = 10000; //图片高度 默认:10000
    protected $extParam;  //扩展参数
    protected $alifcUrl = 'http://alifc.uhomes.com/screenshot'; //阿里云截图地址

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

        /**
         * 加载配置信息
         */
        $aliFcUrl = Helper::getEnv('aliyun.alifc_url');
        !empty($alifcUrl) && $this->alifcUrl = $aliFcUrl;
        $this->width = $this->params['width'] ?? $this->width;
        $this->height = $this->params['height'] ?? $this->height;
        $this->extParam = $this->params['ext_param'] ?? $this->extParam;
        $this->screenshotUrl = $this->params['screenshot_url'] ?? $this->screenshotUrl;
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
     * 获取系统环境变量
     * @return bool|mixed|string|null
     */
    public function getSystemEnvironment()
    {
        return Helper::getEnv('app_status');
    }

    /**
     * 生成截图
     * @param string screenshot_url 截图地址
     * @param int width 图片宽度
     * @param int height 图片高度
     * @param array ext_param 扩展参数
     * @param string alifc_url 阿里云截图服务地址
     *
     * @return string
     */
    public function setScreenshot() {
        // 处理截图参数Emoji信息
//        $exPram = empty($this->extParam) ? null : json_encode($this->extParam, JSON_UNESCAPED_UNICODE);
//        if (!empty($exPram)) {
//            $exPram = htmlspecialchars_decode(htmlspecialchars_decode($exPram));
//        }
        if (!empty($this->extParam)) {
            $param = http_build_query(array_filter($this->extParam));
            $this->screenshotUrl = sprintf('%s?%s', $this->screenshotUrl, $param);
        }
        $postParams = [
            'url' => $this->screenshotUrl,
            'width' => $this->width,
            'height' => $this->height,
            'token' => md5('Uhomes_Fc_Screenshot_' . time()),
            'times' => time(),
        ];

        $url = sprintf('%s?%s', $this->alifcUrl, http_build_query($postParams));
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄CURLOPT_SSL_VERIFYHOST
        curl_close($ch);
        $res = empty($output) ? [] : json_decode($output, true);
        return getImagePath($res['relative_url'] ?? '');
    }

}
