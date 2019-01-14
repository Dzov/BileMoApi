<?php

namespace App\Controller;

use App\Exception\InvalidFormDataException;
use Hateoas\HateoasBuilder;
use Hateoas\UrlGenerator\SymfonyUrlGenerator;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * @var FilesystemAdapter
     */
    protected $cache;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        UrlGeneratorInterface $generator,
        AdapterInterface $cache
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->generator = $generator;
        $this->cache = $cache;
    }

    protected function createJsonResponse($data, array $groups = [], int $response = Response::HTTP_OK): JsonResponse
    {
        $jsonData = $this->serializeHateoas($data, $groups);

        return new JsonResponse($jsonData, $response, [], true);
    }

    /**
     * @throws InvalidFormDataException
     */
    protected function validate($data)
    {
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new InvalidFormDataException($errorMessages);
        }
    }

    protected function serializeHateoas($data, array $groups = []): string
    {
        $hateoas = HateoasBuilder::create()
            ->setUrlGenerator(null, new SymfonyUrlGenerator($this->generator))
            ->build();

        if (!empty($groups)) {
            $context = SerializationContext::create()->setGroups($groups);

            return $hateoas->serialize($data, 'json', $context);
        }

        return $hateoas->serialize($data, 'json');
    }

    protected function invalidateCache(string $key): void
    {
        $this->cache->deleteItem($key);
    }
}
