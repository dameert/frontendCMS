<?php

namespace Dameert\FrontendCms\Data;


class RawData
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!isset($data['type'])) {
            return;
        }
        $this->type = $data['type'];
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return null !== $this->type;
    }

    /**
     * @return mixed
     */
    public function __get($name)
    {
        if (!isset($this->data[$name])) {
            // error
        }

        return $this->data[$name];
    }
}