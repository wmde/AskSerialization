<?php

namespace Ask\Deserializers;

use Ask\Deserializers\Exceptions\DeserializationException;
use Ask\Deserializers\Strategies\SelectionRequestDeserializationStrategy;
use DataValues\DataValueFactory;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SelectionRequestDeserializer extends TypedObjectDeserializer {

	protected $dataValueFactory;
	protected $deserializer;

	public function __construct( DataValueFactory $dataValueFactory ) {
		$this->dataValueFactory = $dataValueFactory;
		$this->deserializer = $this->newDeserializer();
	}

	protected function newDeserializer() {
		return new StrategicDeserializer(
			new SelectionRequestDeserializationStrategy(
				$this->dataValueFactory,
				$this
			),
			'selectionRequest',
			'selectionRequestType'
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
