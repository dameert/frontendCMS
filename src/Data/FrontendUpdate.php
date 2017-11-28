<?php

namespace Dameert\FrontendCms\Data;


class FrontendUpdate
{
    /**
     * @var array
     */
    private $keys = [];

    /**
     * @var array
     */
    private $values = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param array $modifications
     * @param string $type
     */
    public function __construct(array $modifications, $type)
    {
        foreach ($modifications as $keyValue) {
            if (!isset($keyValue['key'])) {
                continue;
            }

            if (!isset($keyValue['value'])) {
                continue;
            }

            $this->keys[] = $keyValue['key'];
            $this->values[] = $keyValue['value'];
        }

        $this->data = array_combine($this->keys, $this->values);
        $this->data['type'] = $type;
    }

    public function getJson()
    {
        return json_encode($this->data);
    }
}