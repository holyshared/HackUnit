<?hh // strict

namespace HackPack\HackUnit\Tests\Fixtures\InvalidSuites\Test;

use HackPack\HackUnit\Contract\Assert;

<<TestSuite>>
class Constructor
{
    <<Test>>
    public function __construct()
    {
    }

    <<Test>>
    public function validTest(Assert $assert) : void
    {
    }
}
