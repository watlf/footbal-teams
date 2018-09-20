<?php

namespace App\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriberTest extends TestCase
{
    /**
     * @var ExceptionSubscriber
     */
    private $exceptionSubscriber;

    public function setUp()
    {
        $debug = false;

        $this->exceptionSubscriber = new ExceptionSubscriber($debug);
    }

    public function testProcessException()
    {
        $httpKernel = $this->getMockBuilder(HttpKernelInterface::class)->getMock();
        $exception = new \Exception('Exception message');
        $request = new Request();

        $event = new GetResponseForExceptionEvent(
            $httpKernel,
            $request,
            HttpKernelInterface::MASTER_REQUEST,
            $exception
        );

        $this->exceptionSubscriber->processException($event);

        $this->assertTrue($event->hasResponse());
        $this->assertNotEmpty($event->getResponse()->getContent());
    }

    public function testGetSubscribedEvents()
    {
        $result = $this->exceptionSubscriber->getSubscribedEvents();
        $this->assertArrayHasKey(KernelEvents::EXCEPTION, $result);
    }
}
