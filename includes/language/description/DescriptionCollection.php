<?php

namespace Ask\Language\Description;

/**
 * Description of a collection of many descriptions.
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
 * @ingroup Ask
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class DescriptionCollection implements Description {

	/**
	 * @since 0.1
	 *
	 * @var Description[]
	 */
	protected $descriptions;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 *
	 * @param Description[] $descriptions
	 */
	public function __construct( array $descriptions ) {
		$this->descriptions = $descriptions;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getSize() {
		$size = 0;

		foreach ( $this->descriptions as $description ) {
			$size += $description->getSize();
		}

		assert( $size >= 0 );

		return $size;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since 0.1
	 *
	 * @return integer
	 */
	public function getDepth() {
		$depth = 0;

		foreach ( $this->descriptions as $description ) {
			$depth = max( $depth, $description->getDepth() );
		}

		assert( $depth >= 0 );

		return $depth;
	}

	/**
	 * Returns the descriptions that make up this collection of descriptions.
	 *
	 * @since 0.1
	 *
	 * @return Description[]
	 */
	public function getDescriptions() {
		return $this->descriptions;
	}

}