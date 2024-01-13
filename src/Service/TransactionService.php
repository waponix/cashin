<?php
namespace App\Service;

use App\Entity\Transaction;
use App\Form\TransactionType;
use Symfony\Component\Form\Form;

class TransactionService extends AbstractBaseService
{
    public function getList(): array
    {
        return $this->em->getRepository(Transaction::class)
            ->createQueryBuilder('t')
            ->orderBy('t.transactionedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function create(&$errors = []): Transaction|false
    {
        $form = $this->createApiForm(TransactionType::class);
        $form->handleRequest($this->getRequest());

        $errors = $this->getErrorMessages($form);
        if (!empty($errors)) {
            return false;
        }

        $data = $form->getData();
        $data->setUser($this->getUser());

        return $this->save($data) ?? false;
    }
    
    public function update(&$errors = []): Transaction|false
    {
        $id = $this->getRequest()->get('id');

        $transaction = $this->em->getRepository(Transaction::class)->findOneBy(['id' => $id]);

        // set the method of this form to PUT
        $form = $this->createApiForm(TransactionType::class, $transaction, ['method' => 'PUT']);
        $form->handleRequest($this->getRequest());

        $errors = $this->getErrorMessages($form);
        if (!empty($errors)) {
            return false;
        }

        return $this->save($transaction) ?? false;
    }

    private function save($data): Transaction|false
    {
        $this->em->getConnection()->beginTransaction();
        try {
            $this->em->persist($data);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (\Exception $exception) {
            $this->em->getConnection()->rollback();
            return false;
        }

        return $data;
    }

    private function getErrorMessages(Form $form) {
        $errors = [];
        foreach ($form->getErrors() as $key => $error) {
            $template = $error->getMessageTemplate();
            $parameters = $error->getMessageParameters();
    
            foreach ($parameters as $var => $value) {
                $template = str_replace($var, $value, $template);
            }
    
            $errors[$key] = $template;
        }
        if ($form->count()) {
            foreach ($form as $child) {
                if (!$child->isValid()) {
                    $errors[$child->getName()] = $this->getErrorMessages($child);
                }
            }
        }
        return $errors;
    }
}