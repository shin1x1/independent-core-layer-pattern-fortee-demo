# 独立したコアレイヤパターンの適用 - fortee 編 -

* https://speakerdeck.com/shin1x1/fortee-meets-independent-core-layer-pattern

当日ライブコーディングで書いたコードです。before コードは作者の @tomzoh さんから許可を頂いて掲載しています。

```
before/ // リファクタリング前
after/  // リファクタリング後
  Fortee/
    Proposal/
      Application/ // アプリケーションレイヤ
      Core/        // コアレイヤ
```

## Usage

```
$ git clone this_repo
$ cd this_repo

$ docker run -it --rm -v `pwd`:/opt -w /opt composer install --ignore-platform-reqs
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 35 installs, 0 updates, 0 removals
(snip)
Writing lock file
Generating autoload files

$ docker run --rm -v `pwd`:/opt -w /opt php:7.4-cli-alpine ./vendor/bin/phpunit 
PHPUnit 6.5.14 by Sebastian Bergmann and contributors.
  
..                                                                  2 / 2 (100%)
  
Time: 307 ms, Memory: 4.00MB
  
OK (2 tests, 2 assertions)
```