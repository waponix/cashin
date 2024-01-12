<?php
namespace App\Controller\API;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAPIController extends AbstractFOSRestController
{
    private $metas = [];
    private $failures = [];

    protected function respond(array|object $data, string $status, int $statusCode): Response
    {
        $format = [
            "metas" => $this->metas,
            "failures" => $this->failures,
            "status" => $status,
            "data" => $data,
        ];

        return $this->handleView($this->view($format, $statusCode));
    }

    protected function setMetas(array $metas): self
    {
        $this->metas = $metas;
        return $this;
    }

    protected function setFailures(array $failures): self
    {
        $this->failures = $failures;
        return $this;
    }

    protected function buildForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge([
            'csrf_protection' => false
        ], $options);

        return $this->container->get('form.factory')->createNamed('', $type, $data, $options);
    }
}