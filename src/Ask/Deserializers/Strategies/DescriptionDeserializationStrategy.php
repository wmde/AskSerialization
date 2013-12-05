<?php

namespace Ask\Deserializers\Strategies;

use Ask\Language\Description\AnyValue;
use Ask\Language\Description\Conjunction;
use Ask\Language\Description\Description;
use Ask\Language\Description\Disjunction;
use Ask\Language\Description\SomeProperty;
use Ask\Language\Description\ValueDescription;
use Deserializers\Deserializer;
use Deserializers\Exceptions\DeserializationException;
use Deserializers\Exceptions\InvalidAttributeException;
use Deserializers\TypedDeserializationStrategy;

/**
 * TODO: split individual description handling to own classes to we can use
 * polymorphic dispatch and not have this big OCP violation.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionDeserializationStrategy extends TypedDeserializationStrategy {

	protected $dvDeserializer;
	protected $descriptionDeserializer;

	public function __construct( Deserializer $dataValueFactory, Deserializer $descriptionDeserializer ) {
		$this->dvDeserializer = $dataValueFactory;
		$this->descriptionDeserializer = $descriptionDeserializer;
	}

	/**
	 * @see TypedDeserializationStrategy::getDeserializedValue
	 *
	 * @since 1.0
	 *
	 * @param string $descriptionType
	 * @param array $descriptionValue
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function getDeserializedValue( $descriptionType, array $descriptionValue ) {
		if ( $descriptionType === 'anyValue' ) {
			return new AnyValue();
		}

		if ( $descriptionType === 'someProperty' ) {
			return $this->newSomeProperty( $descriptionValue );
		}

		if ( $descriptionType === 'valueDescription' ) {
			return $this->newValueDescription( $descriptionValue );
		}

		if ( $descriptionType === 'conjunction' ) {
			return $this->newConjunction( $descriptionValue );
		}

		if ( $descriptionType === 'disjunction' ) {
			return $this->newDisjunction( $descriptionValue );
		}

		throw new InvalidAttributeException(
			'descriptionType',
			$descriptionType,
			'The provided descriptionType is not supported by this deserializer'
		);
	}

	protected function newSomeProperty( array $descriptionValue ) {
		$this->requireAttributes( $descriptionValue, 'property', 'description', 'isSubProperty' );
		$this->assertAttributeIsArray( $descriptionValue, 'property' );

		try {
			$someProperty = new SomeProperty(
				$this->deserializeDataValue( $descriptionValue['property'] ),
				$this->descriptionDeserializer->deserialize( $descriptionValue['description'] ),
				$descriptionValue['isSubProperty']
			);
		}
		catch ( \InvalidArgumentException $ex ) {
			throw new DeserializationException( $ex->getMessage(), $ex );
		}

		return $someProperty;
	}

	protected function deserializeDataValue( $dvSerialization ) {
		return $this->dvDeserializer->deserialize( $dvSerialization );
	}

	protected function newValueDescription( array $descriptionValue ) {
		$this->requireAttributes( $descriptionValue, 'value', 'comparator' );
		$this->assertAttributeIsArray( $descriptionValue, 'value' );

		$valueDescription = new ValueDescription(
			$this->deserializeDataValue( $descriptionValue['value'] ),
			$this->deserialzeComparator( $descriptionValue['comparator'] )
		);

		return $valueDescription;
	}

	protected function deserialzeComparator( $comparatorSerialization ) {
		$comparatorStrings = array(
			ValueDescription::COMP_EQUAL => 'equal',
			ValueDescription::COMP_LEQ => 'leq',
			ValueDescription::COMP_GEQ => 'geq',
			ValueDescription::COMP_NEQ => 'neq',
			ValueDescription::COMP_LIKE => 'like',
			ValueDescription::COMP_NLIKE => 'nlike',
			ValueDescription::COMP_LESS => 'less',
			ValueDescription::COMP_GREATER => 'greater'
		);

		$comparator = array_search( $comparatorSerialization, $comparatorStrings );

		if ( $comparator === false ) {
			throw new InvalidAttributeException( 'comparator', $comparatorSerialization );
		}

		return $comparator;
	}

	protected function newConjunction( array $descriptionValue ) {
		$this->requireAttribute( $descriptionValue, 'descriptions' );
		$this->assertAttributeIsArray( $descriptionValue, 'descriptions' );

		return new Conjunction(
			$this->deserializeDescriptions( $descriptionValue['descriptions'] )
		);
	}

	protected function newDisjunction( array $descriptionValue ) {
		$this->requireAttribute( $descriptionValue, 'descriptions' );
		$this->assertAttributeIsArray( $descriptionValue, 'descriptions' );

		return new Disjunction(
			$this->deserializeDescriptions( $descriptionValue['descriptions'] )
		);
	}

	/**
	 * @param array $descriptionSerializations
	 *
	 * @return Description[]
	 */
	protected function deserializeDescriptions( array $descriptionSerializations ) {
		$descriptions = array();

		foreach ( $descriptionSerializations as $serialization ) {
			$descriptions[] = $this->descriptionDeserializer->deserialize( $serialization );
		}

		return $descriptions;
	}

}
