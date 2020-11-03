<?php

namespace m4rku5\DockComp;

class DockCompService
{
    const mapping = [
        'volumes' => DockCompServiceVolume::class,
        'ports' => DockCompServicePort::class,
    ];

    /** @var array $config */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        foreach (self::mapping as $section => $class) {
            foreach ($this->config[$section] as $index => $config) {
                $this->config[$section][$index] = new $class($config);
            }
        }
    }

    public function setImage(string $image): self
    {
        $this->config['image'] = $image;
        return $this;
    }

    public function setContainerName(string $name): self
    {
        $this->config['container_name'] = $name;
        return $this;
    }

    public function setEnvFile(string $path): self
    {
        $this->config['env_file'] = $path;
        return $this;
    }

    public function setRestart(string $state): self
    {
        $this->config['restart'] = $state;
        return $this;
    }

    public function get(): array
    {
        $config = $this->config;
        // convert back to array
        foreach (self::mapping as $section => $class) {
            $config[$section] = array_map(static function ($volume) {
                return $volume->get();
            }, $config[$section]);
        }
        // return config array
        return $config;
    }
}
