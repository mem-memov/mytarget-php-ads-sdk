<?php

namespace MyTarget\Operator\V1\Remarketing;

use MyTarget\Client;
use MyTarget\Domain\V1\Remarketing\RemarketingCounter;
use MyTarget\Mapper\Mapper;

class RemarketingCounterOperator
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Mapper
     */
    private $mapper;

    public function __construct(Client $client, Mapper $mapper)
    {
        $this->client = $client;
        $this->mapper = $mapper;
    }

    /**
     * @param RemarketingCounter $counter
     * @param array|null $context
     *
     * @return RemarketingCounter
     */
    public function create(RemarketingCounter $counter, array $context = null)
    {
        $rawCounter = $this->mapper->snapshot($counter);

        $json = $this->client->post("/api/v1/remarketing_counters.json", null, $rawCounter, $context);

        return $this->mapper->hydrateNew(RemarketingCounter::class, $json);
    }

    /**
     * @param int $id
     * @param RemarketingCounter $counter
     * @param array|null $context
     *
     * @return RemarketingCounter
     */
    public function edit($id, RemarketingCounter $counter, array $context = null)
    {
        $rawCounter = $this->mapper->snapshot($counter);

        $json = $this->client->post(sprintf("/api/v1/remarketing_counters/%d.json", $id), null, $rawCounter, $context);

        return $this->mapper->hydrateNew(RemarketingCounter::class, $json);
    }

    /**
     * @param array|null $context
     *
     * @return RemarketingCounter[]
     */
    public function all(array $context = null)
    {
        $json = $this->client->get("/api/v1/remarketing_counters.json", null, $context);

        return array_map(function ($json) {
            return $this->mapper->hydrateNew(RemarketingCounter::class, $json);
        }, $json);
    }

    /**
     * @param int $id
     * @param array|null $context
     */
    public function delete($id, array $context = null)
    {
        $path = sprintf("/api/v1/remarketing_counters/%d.json", $id);
        $this->client->delete($path, null, $context);
    }
}
