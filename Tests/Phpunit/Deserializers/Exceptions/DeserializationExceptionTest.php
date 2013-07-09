<?php

namespace Ask\Tests\Phpunit\Deserializers\Exceptions;

use Ask\Deserializers\Exceptions\DeserializationException;

/**
 * @covers Ask\Deserializers\Exceptions\DeserializationException
 *
 * @file
 * @since 0.1
 *
 * @ingroup Ask
 * @group Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DeserializationExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testConstructorWithOnlyRequiredArguments() {
		new DeserializationException();
		$this->assertTrue( true );
	}

	public function testConstructorWithAllArguments() {
		$message = 'NyanData all the way across the sky!';
		$previous = new \Exception( 'Onoez!' );

		$exception = new DeserializationException( $message, $previous );

		$this->assertEquals( $message, $exception->getMessage() );
		$this->assertEquals( $previous, $exception->getPrevious() );
	}

}
