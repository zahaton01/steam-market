<?php

namespace App\Proto\TM\Instances\CS;

use App\Proto\AbstractProto;
use App\Proto\JSONProto;

class CSTMItemInstancesProto extends AbstractProto
{
    /** @var string */
    private $hashName;
    /** @var CSTMItemInstanceProto[] */
    private $instances;

    /**
     * CSTMItemInstancesProto constructor.
     *
     * @param JSONProto|null $proto
     */
    public function __construct(JSONProto $proto = null)
    {
        parent::__construct($proto);

        if ($this->hasProto()) {
            $this->init();
        }
    }

    /**
     * @param null $data
     * @param array $params
     *
     * @return $this|mixed
     */
    public function init($data = null, array $params = [])
    {
        if ($this->hasProto()) {
            $data = $this->getProto()->getDecodedJson()['data'];

            foreach ($data as $datum) {
                $instance = new CSTMItemInstanceProto();

                $datum['currency'] = $this->getProto()->getDecodedJson()['currency'] ?? null;
                $datum['instance'] = $datum['class'] . '_' . $datum['instance'];

                $this->addInstance($instance->init($datum, [
                    'divide_price' => true
                ]));
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     *
     * @return self
     */
    public function setHashName(?string $hashName): self
    {
        $this->hashName = $hashName;
        return $this;
    }

    /**
     * @return CSTMItemInstanceProto[]
     */
    public function getInstances(): ?array
    {
        return $this->instances;
    }

    /**
     * @param CSTMItemInstanceProto $itemInstance
     *
     * @return self
     */
    public function addInstance(?CSTMItemInstanceProto $itemInstance): self
    {
        $this->instances[] = $itemInstance;
        return $this;
    }
}
