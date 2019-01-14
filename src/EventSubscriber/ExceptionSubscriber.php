<?php

namespace App\EventSubscriber;

use App\Normalizer\NormalizerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Amélie Haladjian <amelie.haladjian@gmail.com>
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    private $serializer;

    private $normalizers;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function processException(GetResponseForExceptionEvent $event)
    {
        $response = null;

        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supports($event->getException())) {
                $response = $normalizer->normalize($event->getException());

                break;
            }
        }

        if (null == $response) {
            $response['errors'] = [
                'status'    => Response::HTTP_BAD_REQUEST,
                'message' => $event->getException()->getMessage(),
            ];
        }

        $body = $this->serializer->serialize($response, 'json');

        $event->setResponse(new JsonResponse($body, $response['errors']['status'], [], true));
    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizers[] = $normalizer;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'processException',
        ];
    }
}
