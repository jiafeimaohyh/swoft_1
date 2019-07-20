<?php declare(strict_types=1);


namespace App\Listener;


use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Consul\Agent;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Server\ServerEvent;

/**
 * Class RegisterServiceListener
 *
 * @since 2.0
 *
 * @Listener(event=ServerEvent::BEFORE_START)
 */
class RegisterService implements EventHandlerInterface
{
    /**
     * @Inject()
     *
     * @var Agent
     */
    private $agent;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        var_dump(bean('config')->get('provider.consul'));
        var_dump(bean('consulProvider')->registerServer());
        var_dump("注册服务");

    }
}