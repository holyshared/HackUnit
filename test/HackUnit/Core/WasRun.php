<?hh //strict
namespace HackUnit\Core;

class WasRun extends TestCase
{
    public string $log = '';

    <<Override>> public function setUp(): void
    {
        $this->log = 'setUp ';
    }

    <<Override>> public function tearDown(): void
    {
        $this->log .= 'tearDown ';
    }

    public function testMethod(): void
    {
        $this->log .= 'testMethod ';
    }

    public function testBrokenMethod(): void
    {
        throw new \Exception("broken");
    }
}