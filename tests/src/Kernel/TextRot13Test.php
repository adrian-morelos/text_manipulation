<?php

namespace Drupal\Tests\text_manipulation\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests custom implementation of text_rot13() with different strings.
 *
 * @group text
 */
class TextRot13Test extends KernelTestBase {

  public static $modules = ['system', 'user', 'filter', 'text'];

  protected function setUp() {
    parent::setUp();
    $this->installConfig(['text']);
  }

  /**
   * Tests Rot13 with short example
   */
  function testShortSentence() {
    $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
    $expected = 'Yberz vcfhz qbybe fvg nzrg, pbafrpgrghe nqvcvfpvat ryvg.';
    $this->assertTextSummary($text, $expected);
  }

  /**
   * Test Rot13 with long example.
   */
  function testLongSentence() {
    $text = 'Nam aliquam quis risus sed bibendum. Pellentesque mattis tempus ligula nec lobortis. Duis sodales pretium nisi. Pellentesque quis arcu quis risus elementum volutpat. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi faucibus metus nec enim vulputate, a sollicitudin massa fringilla. Curabitur vel aliquam leo, vitae venenatis nibh. Morbi consequat, diam bibendum bibendum imperdiet, purus odio bibendum odio, quis tincidunt est eros sed ipsum.'; // 491
    $expected = 'Anz nyvdhnz dhvf evfhf frq ovoraqhz. Cryyragrfdhr znggvf grzchf yvthyn arp ybobegvf. Qhvf fbqnyrf cergvhz avfv. Cryyragrfdhr dhvf neph dhvf evfhf ryrzraghz ibyhgcng. Pynff ncgrag gnpvgv fbpvbfdh nq yvgben gbedhrag cre pbahovn abfgen, cre vaprcgbf uvzranrbf. Zbeov snhpvohf zrghf arp ravz ihychgngr, n fbyyvpvghqva znffn sevatvyyn. Phenovghe iry nyvdhnz yrb, ivgnr irarangvf avou. Zbeov pbafrdhng, qvnz ovoraqhz ovoraqhz vzcreqvrg, chehf bqvb ovoraqhz bqvb, dhvf gvapvqhag rfg rebf frq vcfhz.';
    $this->assertTextSummary($text, $expected);
  }

  /**
   * Calls text_rot13() and asserts that the expected Rot13 is returned.
   */
  function assertTextSummary($text, $expected) {
    $rot13_version = text_rot13($text);
    $this->assertIdentical($rot13_version, $expected, format_string('<pre style="white-space: pre-wrap">@actual</pre> is identical to <pre style="white-space: pre-wrap">@expected</pre>', [
      '@actual' => $rot13_version,
      '@expected' => $expected,
    ]));
  }


}