<?php
namespace lookfeel\traits;

trait Instance
{

    /**
     * 实例
     *
     * @var unknown
     */
    protected static $instances = [];

    /**
     * 配置
     *
     * @var unknown
     */
    protected $instance_option = [];

    /**
     * key
     *
     * @var unknown
     */
    protected $instance_key;

    public static function instance(array $rules = [], $message = [])
    {
        $key = md5(get_called_class() . serialize($rules) . serialize($message));
        if (! isset(static::$instances[$key])) {
            $instance = new static($rules, $message);
            $instance->instance_key = $key;
            static::$instances[$key] = $instance;
        }
        return static::instanceGet($key);
    }

    /**
     * 根据key获取实例
     *
     * @param string $key
     * @return self
     */
    public static function instanceGet($key)
    {
        return isset(static::$instances[$key]) ? static::$instances[$key] : null;
    }

    /**
     * 读取或者设置配置
     *
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function option($name = null, $value = null)
    {
        if (is_null($value)) {
            if (is_null($name)) {
                return $this->instance_option;
            } else {
                return isset($this->instance_option[$name]) ? $this->instance_option[$name] : '';
            }
        } else {
            $this->instance_option[$name] = $value;
        }
    }

    /**
     * 获取key
     *
     * @return string
     */
    public function getInstanceKey()
    {
        return $this->instance_key;
    }
}
