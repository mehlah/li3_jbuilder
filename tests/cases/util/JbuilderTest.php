<?php

namespace li3_jbuilder\tests\cases\util;

use li3_jbuilder\util\Jbuilder;

class JbuilderTest extends \lithium\test\Unit {

	public function testSingleKeyAssign() {
		$json = Jbuilder::encode(function($json) {
			$json->a = 42;
		});

		$this->assertEqual('{"a":42}', $json);
	}

	public function testSingleKeyCall() {
		$json = Jbuilder::encode(function($json) {
			$json->a(42);
		});

		$this->assertEqual('{"a":42}', $json);
	}

	public function testNesting() {
		$json = Jbuilder::encode(function($json) {
			$json->a(function($json) {
				$json->b(function($json) {
					$json->c = "d";
				});
			});
		});

		$this->assertEqual('{"a":{"b":{"c":"d"}}}', $json);
	}

	public function testArray() {
		$json = Jbuilder::encode(function($json) {
			$json->a(array(1,2,3));
		});

		$this->assertEqual('{"a":[1,2,3]}', $json);
	}

	public function testArrayMap() {
		$json = Jbuilder::encode(function($json) {
			$json->a(array(1,2,3), function($json, $e) { return $e + 5; });
		});

		$this->assertEqual('{"a":[6,7,8]}', $json);
	}

	public function testArrayMapObject() {
		$json = Jbuilder::encode(function($json) {
			$json->a(array(1,2,3), function($json, $e) {
				$json->b = $e;
			});
		});

		$this->assertEqual('{"a":[{"b":1},{"b":2},{"b":3}]}', $json);
	}
}

?>