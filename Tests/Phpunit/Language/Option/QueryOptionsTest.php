<?php

namespace Ask\Tests\Phpunit\Language\Option;

use Ask\Language\Option\QueryOptions;

/**
 * @covers Ask\Language\Option\QueryOptions
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @file
 * @ingroup AskTests
 *
 * @group Ask
 * @group AskOption
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class QueryOptionsTest extends \Ask\Tests\Phpunit\AskTestCase {

	/**
	 * @since 0.1
	 *
	 * @return QueryOptions[]
	 */
	protected function getInstances() {
		$instances = array();

		$instances[] = new QueryOptions(
			100,
			0
		);

		$instances[] = new QueryOptions(
			5,
			100
		);

		$instances[] = new QueryOptions(
			9000,
			42,
			new \Ask\Language\Option\SortOptions( array() )
		);

		return $instances;
	}

	/**
	 * @since 0.1
	 *
	 * @return QueryOptions[][]
	 */
	public function instanceProvider() {
		return $this->arrayWrap( $this->getInstances() );
	}

	/**
	 * @dataProvider instanceProvider
	 *
	 * @since 0.1
	 *
	 * @param QueryOptions $object
	 */
	public function testReturnTypeOfGetArrayValue( QueryOptions $object ) {
		$array = $object->getArrayValue();
		$this->assertPrimitiveStructure( $array );
	}

}
