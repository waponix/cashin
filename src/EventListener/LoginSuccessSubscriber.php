<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use App\Service\AuditLogService;

class LoginSuccessSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly AuditLogService $auditLog,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        //2 - Subscribe to LogoutEvent
        return [LoginSuccessEvent::class => 'onLogin'];
    }

    public function onLogin(LoginSuccessEvent $event): void
    {
        // write audit login when user logs in
        $token = $event->getAuthenticatedToken();

        $user = $token->getUser();

        $this->auditLog->createLog($user->getUsername(), 'Login', 'User Login');
    }
}