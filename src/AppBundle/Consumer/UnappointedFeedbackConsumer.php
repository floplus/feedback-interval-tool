<?php

namespace AppBundle\Consumer;

/**
 *
 *
 * @category
 * @package  Hmmh_
 * @author   Florian Beyerlein <florian.beyerlein@hmmh.de>
 */

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use \PhpAmqpLib\Message\AMQPMessage;
use \Symfony\Component\DependencyInjection\ContainerAwareInterface;
use \Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UnappointedFeedbackConsumer  implements ConsumerInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param AMQPMessage $msg
     *
     * @return bool
     */
    public function execute(AMQPMessage $msg)
    {
        //Process picture upload.
        //$msg will be an instance of `PhpAmqpLib\Message\AMQPMessage` with the $msg->body being the data sent over RabbitMQ.

        echo "unappointed feedback {$msg->body}".PHP_EOL;

        return true;
    }
}
