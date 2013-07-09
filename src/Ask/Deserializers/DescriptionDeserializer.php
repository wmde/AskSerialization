<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Strategies\DescriptionDeserializationStrategy;
use Ask\Language\Description\ValueDescription;
use DataValues\DataValueFactory;

/**
 * TODO: split individual description handling to own classes to we can use
 * polymorphic dispatch and not have this big OCP violation.
 *
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DescriptionDeserializer implements Deserializer {

	protected $dataValueFactory;

	/**
	 * @var Deserializer
	 */
	protected $deserializer;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
		$this->deserializer = $this->newDeserializer();
	}

	protected function newDeserializer() {
		return new TypedObjectDeserializer(
			new DescriptionDeserializationStrategy(
				$this->dataValueFactory,
				$this
			),
			'description',
			'descriptionType'
		);
	}

	/**
	 * @see Deserializer::deserialize
	 *
	 * @since 0.1
	 *
	 * @param mixed $serialization
	 *
	 * @return object
	 * @throws DeserializationException
	 */
	public function deserialize( $serialization ) {
		return $this->deserializer->deserialize( $serialization );
	}

	/**
	 * @see Deserializer::canDeserialize
	 *
	 * @since 0.1
	 *
	 * @param mixed $serialization
	 *
	 * @return boolean
	 */
	public function canDeserialize( $serialization ) {
		return $this->deserializer->canDeserialize( $serialization );
	}

}