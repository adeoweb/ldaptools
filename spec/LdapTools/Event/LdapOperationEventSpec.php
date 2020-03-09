<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools\Event;

use LdapTools\Connection\LdapConnection;
use LdapTools\DomainConfiguration;
use LdapTools\Operation\AddOperation;
use PhpSpec\ObjectBehavior;

class LdapOperationEventSpec extends ObjectBehavior
{
    public function let()
    {
        $config = new DomainConfiguration('foo.bar');
        $config->setLazyBind(true);
        $connection = new LdapConnection($config);
        $operation = new AddOperation('dc=foo,dc=bar');
        $this->beConstructedWith('foo', $operation, $connection);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Event\LdapOperationEvent');
    }

    public function it_should_have_type_Event()
    {
        $this->shouldHaveType('LdapTools\Event\Event');
    }

    public function it_should_implement_EventInterface()
    {
        $this->shouldImplement('LdapTools\Event\EventInterface');
    }

    public function it_should_get_the_event_name()
    {
        $this->getName()->shouldBeEqualTo('foo');
    }

    public function it_should_get_the_operation_for_the_event()
    {
        $this->getOperation()->shouldReturnAnInstanceOf('LdapTools\Operation\LdapOperationInterface');
    }

    public function it_should_get_the_connection_for_the_event()
    {
        $this->getConnection()->shouldReturnAnInstanceOf('LdapTools\Connection\LdapConnectionInterface');
    }
}
