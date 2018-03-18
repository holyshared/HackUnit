<?hh // strict

namespace HackPack\HackUnit\Tests\Report;

use HackPack\HackUnit\Contract\Assert;
use HackPack\HackUnit\Event\Failure;
use HackPack\HackUnit\Event\Pass;
use HackPack\HackUnit\Event\Skip;
use HackPack\HackUnit\Report\Status;

final class StatusTest {
  <<Test>>
  public function passShowsDot(Assert $assert): void {
    using ($context = $this->createContext()) {
      $context->status()->handlePass(Pass::fromCallStack());
      $context->assertOutput($assert, '.');
    }
  }

  <<Test>>
  public function failureShowsF(Assert $assert): void {
    using ($context = $this->createContext()) {
      $context->status()->handleFailure(Failure::fromCallStack('testing'));
      $context->assertOutput($assert, 'F');
    }
  }

  <<Test>>
  public function skipShowsS(Assert $assert): void {
    using ($context = $this->createContext()) {
      $context->status()->handleSkip(Skip::fromCallStack('testing'));
      $context->assertOutput($assert, 'S');
    }
  }

  <<__ReturnDisposable>>
  private function createContext(): ReportStatusContext {
    $out = fopen('php://memory', 'w+');
    return new ReportStatusContext($out, new Status($out));
  }
}


final class ReportStatusContext implements \IDisposable {
  public function __construct(private resource $out, private Status $status) {
  }

  public function status(): Status {
    return $this->status;
  }

  public function assertOutput(Assert $assert, string $expected): void {
    rewind($this->out);
    $actual = stream_get_contents($this->out);
    $assert->string($actual)->is($expected);
  }

  public function __dispose(): void {
    fclose($this->out);
  }
}
