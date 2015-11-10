<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package desire-portfolio-filter
 */

if ( function_exists( '__autoload' ) ) {
	trigger_error( "DesirePortfolioFilterAutoload: It looks like your code is using an __autoload() function. DesirePortfolioFilterAutoload uses spl_autoload_register() which will bypass your __autoload() function and may break autoloading.", E_USER_WARNING );
}

spl_autoload_register( array( 'DesirePortfolioFilterAutoload', 'autoload' ) );

/**
 * Autoloader
 *
 * @package desire-portfolio-filter
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version $Revision: 1394956 $
 */
class DesirePortfolioFilterAutoload {

	/**
	 * Class mapping
	 */
	private static $classes = array(
		'DesirePortfolioTemplate' => '/src/DesirePortfolioTemplate.php'
	);

	/**
	 * Loads the class
	 *
	 * @param string $className The name of the class to load.
	 */
	public static function autoload( $className ) {
		if ( isset( self::$classes[ $className ] ) ) {
			include dirname( __FILE__ ) . self::$classes[ $className ];
		}
	}
}