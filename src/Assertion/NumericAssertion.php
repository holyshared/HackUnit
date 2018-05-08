<?hh // strict

namespace HackPack\HackUnit\Assertion;

use HackPack\HackUnit\Event\Failure;
use HackPack\HackUnit\Event\FailureEmitter;
use HackPack\HackUnit\Event\FailureListener;
use HackPack\HackUnit\Event\SuccessEmitter;
use HackPack\HackUnit\Event\SuccessListener;
use HackPack\HackUnit\Util\Trace;

class NumericAssertion<Tcontext>
  implements
    \HackPack\HackUnit\Contract\Assertion\NumericAssertion<Tcontext> {
  use FailureEmitter;
  use SuccessEmitter;

  private bool $negate = false;

  public function __construct(
    private Tcontext $context,
    Vector<FailureListener> $failureListeners,
    Vector<SuccessListener> $successListeners,
  ) {
    $this->setFailureListeners($failureListeners);
    $this->setSuccessListeners($successListeners);
  }

  public function not(): this {
    $this->negate = true;
    return $this;
  }

  public function eq(Tcontext $expected): void {
    if ($this->context === $expected) {
      $this->negate ? $this->fail('!==', $expected) : $this->emitSuccess();
      return;
    }
    $this->negate ? $this->emitSuccess() : $this->fail('===', $expected);
  }

  public function gt(Tcontext $expected): void {
    if ($this->context > $expected) {
      $this->negate ? $this->fail('!>', $expected) : $this->emitSuccess();
      return;
    }
    $this->negate ? $this->emitSuccess() : $this->fail('>', $expected);
  }

  public function gte(Tcontext $expected): void {
    if ($this->context >= $expected) {
      $this->negate ? $this->fail('!>=', $expected) : $this->emitSuccess();
      return;
    }
    $this->negate ? $this->emitSuccess() : $this->fail('>=', $expected);
  }

  public function lt(Tcontext $expected): void {
    if ($this->context < $expected) {
      $this->negate ? $this->fail('!<', $expected) : $this->emitSuccess();
      return;
    }
    $this->negate ? $this->emitSuccess() : $this->fail('<', $expected);
  }

  public function lte(Tcontext $expected): void {
    if ($this->context <= $expected) {
      $this->negate ? $this->fail('!<=', $expected) : $this->emitSuccess();
      return;
    }
    $this->negate ? $this->emitSuccess() : $this->fail('<=', $expected);
  }

  private function fail(string $comparison, Tcontext $expected): void {
    if (is_int($this->context)) {
      $this->emitFailure(
        Failure::fromCallStack(
          \sprintf(
            'Integer assertion failed.  Expected %d %s %d',
            $this->context,
            $comparison,
            $expected,
          ),
        ),
      );
      return;
    }
    $this->emitFailure(
      Failure::fromCallStack(
        \sprintf(
          'Float assertion failed. Expected %f %s %f',
          $this->context,
          $comparison,
          $expected,
        ),
      ),
    );
  }
}
