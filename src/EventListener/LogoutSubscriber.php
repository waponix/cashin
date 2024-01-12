<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use App\Service\AuditLogService;

class LogoutSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly AuditLogService $auditLog,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        //2 - Subscribe to LogoutEvent
        return [LogoutEvent::class => 'onLogout'];
    }

    public function onLogout(LogoutEvent $event): void
    {
        // write audit log when user logs out
        $token = $event->getToken();

        $user = $token->getUser();

        $this->auditLog->createLog($user->getUsername(), 'Logout');
    }
}