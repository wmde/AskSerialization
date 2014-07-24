<?php

namespace Ask\Deserializers\Strategies;

use Ask\Language\Option\PropertyValueSortExpression;
use Deserializers\Deserializer;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\Exceptions\InvalidAttributeException;
use Deserializers\TypedDeserializationStrategy;
use InvalidArgumentException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SortExpressionDeserializationStrategy extends TypedDeserializationStrategy {

	protected $dvDeserializer;

	public function __construct( Deserializer $dataValueDeserializer ) {
		$this->dvDeserializer = $dataValueDeserializer;
	}

	/**
	 * @see TypedDeserializationStrategy::getDeserializedValue
	 *
	 * @since 1.0
	 *
	 * @param string $selectionRequestType
	 * @param array $valueSerialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function getDeserializedValue( $selectionRequestType, array $valueSerialization ) {
		if ( $selectionRequestType !== 'propertyValue' ) {
			throw new InvalidAttributeException( 'sortExpressionType', $selectionRequestType );
		}

		$this->requireAttribute( $valueSerialization, 'direction' );
		$this->requireAttribute( $valueSerialization, 'property' );
		$this->assertAttributeIsArray( $valueSerialization, 'property' );

		try {
			$expression = new PropertyValueSortExpression(
				$this->dvDeserializer->deserialize( $valueSerialization['property'] ),
				$valueSerialization['direction']
			);
		}
		catch ( InvalidArgumentException $ex ) {
			throw new DeserializationException( $ex->getMessage(), $ex );
		}

		return $expression;
	}

}
