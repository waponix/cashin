<?php
namespace App\Service;

use App\Repository\AuditLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AuditLog;

class AuditLogService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    public function createLog(string $user, string $action, string $page = '', array $details = []) : void
    {
        $auditLog = new AuditLog;

        $defaultDetails = [
            'Date' => ($auditDatetime = new \DateTime('Now'))->format('Y-m-d'),
            'Time' => $auditDatetime->format('H:i:s'),
        ];

        $details = array_merge($defaultDetails, $details);

        $auditLog
            ->setUser($user)
            ->setAction($action)
            ->setPage($page)
            ->setDetails($details);

        $this->em->persist($auditLog);
        $this->em->flush();
    }
}