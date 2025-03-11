<?php
namespace SLiMS\Pdf;

final class Factory {

    /**
     * Factory instance
     */
    private static ?Factory $instance = null;

    /**
     * List of provider
     */
    private array $providers = [];

    /**
     * PDF Provider instance
     */
    private ?object $pdf = null;

    private array $providerCommands = [
        'setContent','download', 
        'stream', 'saveToFile',
        'preview'
    ];

    private function __construct() {}

    public static function getInstance(): Factory
    {
        if (self::$instance === null) self::$instance = new Factory;
        return self::$instance;
    }

    /**
     * If you have yours don't forget to
     * register it.
     *
     * @param string $name
     * @param string $providerClass
     * @return void
     */
    public static function registerProvider(string $name, string $providerClass):void
    {
        self::getInstance()->providers[$name] = $providerClass;
    }

    /**
     * After you register your provider
     * you need tell the factory to use you own
     * as current provider to generate PDF
     *
     * @param string $providerName
     * @param array $options
     * @return void
     */
    public static function useProvider(string $providerName, array $options = [])
    {
        $class = self::getInstance()->providers[$providerName]??null;
        if ($class === null) throw new \Exception("$providerName isn't registered!");
        $providerInstance = new $class(...$options);
        
        if (!$providerInstance instanceof Contract) throw new \Exception("$class is not use PDF contract!");

        self::getInstance()->pdf = $providerInstance;
    }

    /**
     * SLiMS is not directly interacted with your provider,
     * for modularity of this flow SLiMS is only interact
     * with your provider through the Factory. Because of that
     * your own provider must be extend factory contract.
     *
     * @param string $method
     * @param array $arguments
     * @return void
     */
    public static function __callStatic(string $method, array $arguments)
    {
        if (in_array($method, self::getInstance()->providerCommands));
        {
            return call_user_func_array([self::getInstance()->pdf, $method], $arguments);
        }
    }
}
