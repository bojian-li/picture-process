<?php

namespace Bojian\PictureProcess\Process;

/**
 * Helper.php
 *
 * @author libojian <bojian.li@foxmail.com>
 * @since 2023/7/14 5:00 PM
 * @version 0.1
 */

class Helper
{
    private static $logger;
    static $loaded = false;
    const ENV_PREFIX = 'PHP_';

    /**
     * 日志记录函数.
     *
     * @param       $data
     * @param null $key
     * @param array $options
     */
    public static function log($data, $key = null, array $options = [])
    {
        if (null == self::$logger) {
            self::$logger = function_exists('__LOG_MESSAGE');
        }
        self::$logger && __LOG_MESSAGE($data, $key, $options);
    }

    /**
     * 加载配置文件
     * @access public
     * @param string $filePath 配置文件路径
     * @return void
     * @throws \Exception
     */
    public static function loadFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception('配置文件' . $filePath . '不存在');
        }

        self::$loaded = true;

        //返回二位数组
        $env = parse_ini_file($filePath, true);

        foreach ($env as $key => $val) {
            $prefix = static::ENV_PREFIX . strtoupper($key);
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $item = $prefix . '_' . strtoupper($k);
                    putenv("$item=$v");
                }
            } else {
                putenv("$prefix=$val");
            }
        }
    }

    /**
     * 获取环境变量值
     *
     * @access public
     *
     * @param string $name 环境变量名（支持二级 . 号分割）
     * @param string $default 默认值
     *
     * @return mixed
     */
    public static function getEnv(string $name, string $default = null)
    {

        if (!self::$loaded) {
            try {
                self::loadFile(dirname(dirname(__DIR__)) . '/.env');
            } catch (\Exception $e) {
                return $default;
            }
        }

        $result = getenv(static::ENV_PREFIX . strtoupper(str_replace('.', '_', $name)));

        if (false !== $result) {
            'true' === $result && $result = true;
            'false' === $result && $result = false;
            return $result;
        }

        return $default;
    }

    /**
     * 图片转base64
     * @param string $filePath  文件地址
     * @param string $type      图片类型 jpg|png|gif
     * @return string
     */
    public static function imgToBase64(string $filePath, string $type = 'jpg'): string
    {
        if (empty($filePath)) {
            return '';
        }

        $base64 = '';
        if (file_exists($filePath)) {
            //合成图片的base64编码
            $base64 = sprintf('data:image/%s;base64,%s', $type, chunk_split(base64_encode(file_get_contents($filePath))));
        }
        return $base64;
    }
}
