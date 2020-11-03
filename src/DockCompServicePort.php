<?php

namespace m4rku5\DockComp;

class DockCompServicePort
{
    /** @var string $config */
    private $config;

    /**
     * @param string $config
     */
    public function __construct(string $config)
    {
        $this->config = $config;
    }

    public function get()
    {
        return $this->config;
    }
}
