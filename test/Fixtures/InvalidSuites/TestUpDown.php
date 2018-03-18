<?hh // strict

namespace HackPack\HackUnit\Tests\Fixtures\InvalidSuites;

class TestUpParams {
  <<Setup>>
  public function invalid(int $requiredParam): void {}
}

class TestUpConstructDestruct {
  <<Setup>>
  public function __construct() {}
}

class TestDownParams {
  <<TearDown>>
  public function invalid(int $requiredParam): void {}
}

class TestDownConstructDestruct {
  <<TearDown>>
  public function __construct() {}
}
