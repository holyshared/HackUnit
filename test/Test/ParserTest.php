<?hh // strict

namespace HackPack\HackUnit\Tests\Test;

use HackPack\HackUnit\Contract\Assert;
use HackPack\HackUnit\Test\Parser;
use Facebook\DefinitionFinder\TreeParser;
use HH\Lib\{ Vec };

abstract class ParserTest {

  abstract protected static function basePath(): string;
  abstract protected static function fullName(string $name): string;

  protected static Map<string, Parser> $parsersBySuiteName = Map {};

  <<Setup('suite')>>
  public static async function buildParsers(): Awaitable<void> {
    $parser = await TreeParser::fromPathAsync(static::basePath());
    $parsers = $parser->getClasses()
      |> Vec\map($$, $class ==> {
        return Pair {
          $class->getName(),
          new Parser($class->getName(), $class->getFileName())
        };
      });

    self::$parsersBySuiteName->clear()->addAll($parsers);
  }

  protected function parserFromSuiteName(string $name): Parser {
    $parser = self::$parsersBySuiteName->get(static::fullName($name));

    if ($parser === null) {
      throw new \RuntimeException('Unable to locate suite '.$name);
    }
    return $parser;
  }
}
