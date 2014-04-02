<?php

namespace Ask\Serializers;

use Ask\Language\Option\QueryOptions;
use Ask\Language\Option\SortExpression;
use Serializers\DispatchableSerializer;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryOptionsSerializer implements DispatchableSerializer {

	protected $componentSerializer;

	/**
	 * @param Serializer $componentSerializer
	 * This serializer needs to be able to serialize the various components that make up a QueryOptions object.
	 */
	public function __construct( Serializer $componentSerializer ) {
		$this->componentSerializer = $componentSerializer;
	}

	public function serialize( $object ) {
		$this->assertCanSerialize( $object );
		return $this->getSerializedOptions( $object );
	}

	protected function assertCanSerialize( $askObject ) {
		if ( !$this->isSerializerFor( $askObject ) ) {
			throw new UnsupportedObjectException( $askObject );
		}
	}

	protected function getSerializedOptions( QueryOptions $options ) {
		$expressionSerializer = $this->componentSerializer;

		return array(
			'objectType' => 'queryOptions',
			'limit' => $options->getLimit(),
			'offset' => $options->getOffset(),

			// TODO: create a dedicated serializer for sort options
			'sort' => array(
				'expressions' => array_map(
					function( SortExpression $expression ) use ( $expressionSerializer ) {
						return $expressionSerializer->serialize( $expression );
					},
					$options->getSort()->getExpressions()
				)
			),
		);
	}

	public function isSerializerFor( $askObject ) {
		return $askObject instanceof QueryOptions;
	}

}
