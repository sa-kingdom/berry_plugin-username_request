<?php

/*
 * This file is part of fof/username-request.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\UserRequest\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use FoF\UserRequest\Api\Serializer\RequestSerializer;
use FoF\UserRequest\Command\ActOnRequest;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ActOnRequestController extends AbstractShowController
{
    public $serializer = RequestSerializer::class;

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $this->bus->dispatch(
            new ActOnRequest(array_get($request->getQueryParams(), 'id'), $request->getAttribute('actor'), array_get($request->getParsedBody(), 'data', []))
        );
    }
}
