<?php
/**
 * BOM Cpt Tests.
 *
 * @since   0.0.0
 * @package BOM
 */
class BOM_Cpt_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'BOM_Cpt') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  0.0.0
	 */
	function test_class_access() {
		$this->assertInstanceOf( 'BOM_Cpt', bom()->cpt' );
	}

	/**
	 * Test to make sure the CPT now exists.
	 *
	 * @since  0.0.0
	 */
	function test_cpt_exists() {
		$this->assertTrue( post_type_exists( 'bom-cpt' ) );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  0.0.0
	 */
	function test_sample() {
		$this->assertTrue( true );
	}
}
