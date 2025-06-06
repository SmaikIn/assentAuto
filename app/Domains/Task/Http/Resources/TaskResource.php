<?php

namespace App\Domains\Task\Http\Resources;

use App\Domains\Task\Dto\TaskDto;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

/**
 * @property TaskDto $resource
 */
class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getId(),
            'title' => $this->resource->getTitle(),
            'description' => $this->resource->getDescription(),
            'status' => $this->resource->getStatus()->value,
            'createdAt' => $this->resource->getCreatedAt()->toIso8601String(),
            'updatedAt' => $this->resource->getUpdatedAt()->toIso8601String(),
        ];
    }
}
