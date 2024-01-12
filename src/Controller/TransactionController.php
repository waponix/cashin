<?php

namespace App\Controller;

use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'app_transaction')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
    ): Response
    {
        $data = [
            'form' => $this->createForm(TransactionType::class)->createView()
        ];

        return $this->render('transaction/index.html.twig', $data);
    }
}
