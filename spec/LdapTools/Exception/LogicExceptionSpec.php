<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools\Exception;

use PhpSpec\ObjectBehavior;

class LogicExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Exception\LogicException');
    }

    public function it_should_have_the_exception_interface()
    {
        $this->shouldHaveType('\LdapTools\Exception\ExceptionInterface');
    }

    public function it_should_extend_the_base_invalid_argument_exception()
    {
        $this->shouldHaveType('\LogicException');
    }
}
