<?php

namespace Ask\Tests\Phpunit\Serializers;

use Ask\Language\Option\PropertyValueSortExpression;
use Ask\Language\Option\SortExpression;
use Ask\Language\Selection\PropertySelection;
use Ask\Language\Selection\SelectionRequest;
use Ask\Language\Selection\SubjectSelection;
use Ask\Serializers\SelectionRequestSerializer;
use Ask\Serializers\SortExpressionSerializer;
use DataValues\StringValue;

/**
 * @covers Ask\Serializers\SortExpressionSerializer
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
class SortExpressionSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testConstructWithNoSerializers() {
		$serializer = new SortExpressionSerializer();

		$this->assertFalse( $serializer->canSerialize( 'foo' ) );
		$this->assertFalse( $serializer->canSerialize( null ) );

		$this->setExpectedException( 'Ask\Serializers\Exceptions\UnsupportedObjectException' );

		$serializer->serialize( 'foo' );
	}

	/**
	 * @dataProvider sortExpressionProvider
	 */
	public function testSerializeSortExpression( SortExpression $expression, $expectedSerialization ) {
		$serializer = new SortExpressionSerializer();
		$actualSerialization = $serializer->serialize( $expression );

		$this->assertEquals( $expectedSerialization, $actualSerialization );
	}

	public function sortExpressionProvider() {
		$argLists = array();

		$p1337 = new StringValue( '1337prop' );

		$argLists[] = array(
			new PropertyValueSortExpression(
				$p1337,
				SortExpression::DIRECTION_ASCENDING
			),
			array(
				'objectType' => 'sortExpression',
				'sortExpressionType' => 'propertyValue',
				'value' => array(
					'property' => $p1337->toArray(),
					'direction' => SortExpression::DIRECTION_ASCENDING,
				),
			)
		);

		$argLists[] = array(
			new PropertyValueSortExpression(
				$p1337,
				SortExpression::DIRECTION_DESCENDING
			),
			array(
				'objectType' => 'sortExpression',
				'sortExpressionType' => 'propertyValue',
				'value' => array(
					'property' => $p1337->toArray(),
					'direction' => SortExpression::DIRECTION_DESCENDING,
				),
			)
		);

		return $argLists;
	}

}