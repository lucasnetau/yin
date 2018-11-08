<?php
declare(strict_types=1);

namespace WoohooLabs\Yin\JsonApi\Schema\Document;

use WoohooLabs\Yin\JsonApi\Schema\Data\DataInterface;
use WoohooLabs\Yin\JsonApi\Schema\Data\SingleResourceData;
use WoohooLabs\Yin\JsonApi\Schema\Link\DocumentLinks;
use WoohooLabs\Yin\JsonApi\Transformer\ResourceDocumentTransformation;
use WoohooLabs\Yin\JsonApi\Transformer\ResourceTransformer;

abstract class AbstractSimpleResourceDocument extends AbstractResourceDocument
{
    /**
     * Provides information about the "links" member of the current document.
     *
     * The method returns a new Links object if you want to provide linkage data
     * for the document or null if the member should be omitted from the response.
     */
    abstract public function getLinks(): ?DocumentLinks;

    abstract protected function getResource(): array;

    /**
     * @internal
     */
    public function getData(ResourceDocumentTransformation $transformation, ResourceTransformer $transformer): DataInterface
    {
        $data = new SingleResourceData();

        $data->addPrimaryResource($this->getResource());

        return $data;
    }

    /**
     * @internal
     */
    public function getRelationshipData(ResourceDocumentTransformation $transformation, ResourceTransformer $transformer, DataInterface $data): ?array
    {
        $relationship = $this->getRelationshipFromResource($this->getResource(), $transformation->requestedRelationshipName);

        if ($relationship === null) {
            $relationship = [];
        } else {
            $data->addPrimaryResource($relationship);
        }

        return $relationship;
    }

    private function getRelationshipFromResource(array $resource, string $relationshipName): ?array
    {
        if (empty($resource["relationships"][$relationshipName])) {
            return null;
        }

        if (\is_array($resource["relationships"][$relationshipName]) === false) {
            return null;
        }

        return $resource["relationships"][$relationshipName];
    }
}