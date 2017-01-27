<?php

namespace Tests;

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert as PHPUnit;

class TestResponse extends \Illuminate\Foundation\Testing\TestResponse
{
	public function dump()
	{
		dump($this->decodeResponseJson());
	}
	
	public function dd()
	{
		dd($this->decodeResponseJson());
	}
	
	public function assertValidationError($field)
	{
		$this->assertStatus(422);
		PHPUnit::assertArrayHasKey($field, $this->decodeResponseJson());
	}
	
	public function assertJsonContains(array $data)
	{
		foreach ($data as $key => $value) {
			if (is_string($key)) {
				$excepted = $this->formatJsonFragment($key, $value);
				
				PHPUnit::assertTrue(Str::contains($this->getContent(), $excepted), "Unable to find {$excepted} \n within \n {$this->getContent()}.");
			} else {
				$this->assertSee($value);
			}
		}
		
		return $this;
	}
	
	protected function formatJsonFragment($key, $value)
	{
		$excepted = json_encode([$key => $value]);
		
		// Strip first and last curly bracket off the json string
		$excepted = substr($excepted, 1);
		$excepted = substr($excepted, 0, -1);
		
		return trim($excepted);
	}
	
	public function assertJsonDontContain(array $data)
	{
		foreach ($data as $key => $value) {
			if (is_string($key)) {
				$excepted = $this->formatJsonFragment($key, $value);
				
				PHPUnit::assertFalse(Str::contains($this->getContent(), $excepted),
					"Unexpected {$excepted} found \n within \n {$this->getContent()}.");
			} else {
				$this->assertDontSee($value);
			}
		}
		
		return $this;
	}
}