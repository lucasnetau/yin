<?php
declare(strict_types=1);

namespace WoohooLabs\Yin\JsonApi\Schema\Link;

class RelationshipLinks extends AbstractLinks
{
    public static function createWithoutBaseUri(?Link $self = null, ?Link $related = null): RelationshipLinks
    {
        return new self("", $self, $related);
    }

    public static function createWithBaseUri(string $baseUri, ?Link $self = null, ?Link $related = null): RelationshipLinks
    {
        return new self($baseUri, $self, $related);
    }

    public function __construct(string $baseUri = "", ?Link $self = null, ?Link $related = null)
    {
        parent::__construct($baseUri, ["self" => $self, "related" => $related]);
    }

    public function setBaseUri(string $baseUri): RelationshipLinks
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function getSelf(): ?Link
    {
        return $this->getLink("self");
    }

    public function setSelf(?Link $self): RelationshipLinks
    {
        $this->addLink("self", $self);

        return $this;
    }
}