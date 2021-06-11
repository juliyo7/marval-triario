<?php
/**
 * Jet Smart Filters Indexer Data class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Smart_Filters_Indexer_Data' ) ) {


	/**
	 * Define Jet_Smart_Filters_Indexer_Data class
	 */
	class Jet_Smart_Filters_Indexer_Data {

		public $providers_query_args = array();
		public $indexed_data = array();

		/**
		 * Table name
		 *
		 * @var string
		 */
		public $table = 'smart_filters';

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			add_filter( 'jet-smart-filters/render/ajax/data', array( $this, 'prepare_ajax_data' ) );
			add_filter( 'jet-smart-filters/filters/localized-data', array( $this, 'prepare_localized_data' ) );

		}

		/**
		 * Prepare data for ajax actions
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function prepare_ajax_data( $args ) {

			$query_args = jet_smart_filters()->query->get_query_args();
			$key        = $query_args['jet_smart_filters'];

			$this->providers_query_args[ $key ] = $query_args;

			$args['jetFiltersIndexedData'] = $this->prepare_provider_counts();

			return $args;

		}

		/**
		 * Prepare localized data
		 *
		 * @param $args
		 *
		 * @return mixed
		 */
		public function prepare_localized_data( $args ) {

			$this->setup_queries_from_request();
			$args['jetFiltersIndexedData'] = $this->prepare_provider_counts();

			return $args;

		}

		/**
		 * Setup query arguments from request
		 * @return [type] [description]
		 */
		public function setup_queries_from_request() {

			$request_query_args = jet_smart_filters()->query->get_query_args();
			$default_queries = jet_smart_filters()->query->get_default_queries();

			foreach ( $default_queries as $provider => $queries ) {
				foreach ( $queries as $query_id => $query_args ) {

					if ( ! empty( $request_query_args ) && $request_query_args['jet_smart_filters'] === $provider . '/' . $query_id ) {
						$query_args = array_merge( $query_args, $request_query_args );
					}

					$this->providers_query_args[ $provider . '/' . $query_id ] = $query_args;
				}
			}
		}

		/**
		 * Return all counters for different providers
		 *
		 * @return array|mixed
		 */
		public function prepare_provider_counts() {

			$providers_counts     = array();
			$providers_post_types = $this->get_providers_post_types();
			$this->indexed_data   = $this->get_data();

			foreach ( $providers_post_types as $provider => $post_type ) {
				foreach ( $post_type as $key => $current_posts ) {
					$providers_counts = $this->get_posts_counts( $providers_counts, $provider, $current_posts );
				}
			}

			return $providers_counts;

		}

		/**
		 * Return counters for prepared provider
		 *
		 * @param $posts_number
		 * @param $provider
		 * @param $current_posts
		 *
		 * @return mixed
		 */
		public function get_posts_counts( $posts_number, $provider, $current_posts ) {

			foreach ( $this->indexed_data as $query_type => $posts ) {

				$args    = explode( '/', $query_type );
				$row_key = $this->raw_key( array( $provider, $args[2], $args[3], ) );

				$posts_number[ $row_key ] = count( array_intersect( $posts, $current_posts ) );

			}

			return $posts_number;

		}

		/**
		 * Return indexed data from database
		 *
		 * @return array
		 */
		public function get_data() {

			$data = array();

			if ( jet_smart_filters()->db->is_table_exists( $this->table ) ) {
				$rows = jet_smart_filters()->db->query( $this->table );

				foreach ( $rows as $row ) {
					$data[ $row['filter_key'] ] = unserialize( $row['filter_posts'] );
				}
			}

			return $data;

		}

		/**
		 * Return providers post types
		 *
		 * @return array
		 */
		public function get_providers_post_types() {

			$providers_args = $this->get_providers_query_args();
			$posts          = array();

			foreach ( $providers_args as $key => $args ) {
				if ( isset( $args['post_type'] ) ) {
					$post_type              = $args['post_type'];
					$args['fields']         = 'ids';
					$args['posts_per_page'] = - 1;
					unset( $args['jet_smart_filters'] );

					if ( is_array( $post_type ) ) {
						foreach ( $post_type as $type ) {
							$posts[ $key ][ $type ] = get_posts( $args );
						}
					} else {
						$posts[ $key ][ $post_type ] = get_posts( $args );
					}
				}
			}

			return $posts;

		}

		public function get_providers_query_args() {
			return $this->providers_query_args;
		}

		/**
		 * Return raw key
		 *
		 * @param $args
		 *
		 * @return string
		 */
		public function raw_key( $args ) {
			return implode( '/', $args );
		}

	}

}
