<?php

namespace m4rku5\DockComp;

use Symfony\Component\Yaml\Yaml;

class DockComp
{
    const mapping = [
        'services' => DockCompService::class,
    ];

    /** @var array $config */
    private $config;

    /**
     * Assumes loaction in ./vendor/m4rku5/dockcomp/src
     * @param  string  $path
     */
    public function __construct($path = __DIR__ . '/../../../../' . 'docker-compose.yml')
    {
        $this->config = Yaml::parse(file_get_contents($path));

        foreach (self::mapping as $section => $class) {
            foreach ($this->config[$section] as $index => $config) {
                $this->config[$section][$index] = new $class($config);
            }
        }
    }

    public function service(string $key): DockCompService
    {
        return $this->config['services'][$key];
    }

    public function get(): string
    {
        $config = $this->config;
        // convert back to array
        foreach (self::mapping as $section => $class) {
            $config[$section] = array_map(static function ($volume) {
                return $volume->get();
            }, $config[$section]);
        }
        // Return yaml string
        return Yaml::dump($config, 999);
    }
}
