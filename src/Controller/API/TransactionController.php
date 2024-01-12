<?php
namespace App\Controller\API;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Service\TransactionService;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends AbstractAPIController
{
    #[Get(path: '/api/transactions')]
    public function read(Request $request, TransactionService $transactionService): Response
    {
        $data = $transactionService->getList();

        return $this
            ->setMetas(["types" => array_flip(Transaction::TYPES)])
            ->respond($data, $request->get('_route') . ':ok', 200);
    }

    
    #[Get(path: '/api/transactions/{id}')]
    public function readone(Request $request): Response
    {
        return $this->respond([], $request->get('_route') . ':ok', 200);
    }

    #[Post(path: '/api/transactions')]
    public function create(Request $request, TransactionService $transactionService): Response
    {
        $data = $transactionService->create($errors);
        if ($data === false) {
            return $this
                ->setFailures($errors)
                ->respond([], $request->get('_route') . ':error', 500);
        }

        return $this
            ->respond($data, $request->get('_route') . ':ok', 201);
    }

    #[Put(path: '/api/transactions/{id}')]
    public function update(Request $request, TransactionService $transactionService): Response
    {
        $data = $transactionService->update($errors);
        if ($data === false) {
            return $this
                ->setFailures($errors)
                ->respond([], $request->get('_route') . ':error', 500);
        }

        return $this->respond($data, $request->get('_route') . ':ok', 200);
    }
}