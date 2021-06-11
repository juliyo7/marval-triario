<?php
/**
 * Database manager
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Smart_Filters_DB' ) ) {

	/**
	 * Define Jet_Smart_Filters_DB class
	 */
	class Jet_Smart_Filters_DB {

		/**
		 * Return table name by key
		 *
		 * @param  string $table table key.
		 * @return string
		 */
		public static function tables( $table = null, $return = 'all' ) {

			global $wpdb;

			$prefix = 'jet_';

			$tables = array(
				'smart_filters' => array(
					'name'        => $wpdb->prefix . $prefix . 'smart_filters_indexer',
					'query'       => "
						id bigint(20) NOT NULL AUTO_INCREMENT,
						filter_key text,
						filter_posts longtext,
						PRIMARY KEY (id)
					",
				),
			);

			if ( ! $table && 'all' === $return ) {
				return $tables;
			}

			switch ( $return ) {
				case 'all':
					return isset( $tables[ $table ] ) ? $tables[ $table ] : false;

				case 'name':
					return isset( $tables[ $table ] ) ? $tables[ $table ]['name'] : false;

				case 'query':
					return isset( $tables[ $table ] ) ? $tables[ $table ]['query'] : false;
			}

			return false;

		}

		/**
		 * Create all tables on activation
		 */
		public static function create_all_tables() {

			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();

			foreach ( self::tables() as $table ) {

				$table_name  = $table['name'];
				$table_query = $table['query'];

				if ( $table_name !== $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) ) {
					$sql = "CREATE TABLE $table_name (
						$table_query
					) $charset_collate;";

					require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

					dbDelta( $sql );
				}

			}

		}

		/**
		 * Drop all tables on deactivation
		 */
		public static function drop_all_tables() {

			foreach ( self::tables() as $table ) {

				global $wpdb;

				$table_name  = $table['name'];

				$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

			}

		}


		/**
		 * Insert or update row into table
		 *
		 * @param  array  $data [description]
		 * @return [type]       [description]
		 */
		public function update( $table, $data = array(), $format = array() ) {

			$prepared_data = array();

			foreach ( $data as $key => $value ) {
				if ( is_array( $value ) ) {
					$prepared_data[ $key ] = maybe_serialize( $value );
				} else {
					$prepared_data[ $key ] = $value;
				}
			}

			global $wpdb;

			$table_name = $this->tables( $table, 'name' );
			$result     = false;

			if ( ! isset( $prepared_data['id'] ) ) {

				$inserted = $wpdb->insert( $table_name, $prepared_data, $format );

				if ( $inserted ) {
					$result = $wpdb->insert_id;
				}

			} else {

				$where        = array( 'id' => $prepared_data['id'] );
				$where_format = array( '%d' );
				$wpdb->update( $table_name, $prepared_data, $where, $format, $where_format );
				$result = $prepared_data['id'];

			}

			return $result;
		}

		public function drop( $table ) {
			global $wpdb;
			$table_name = $this->tables( $table, 'name' );
			$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );
		}

		/**
		 * Check if table is exists
		 *
		 * @param  string  $table Table name.
		 * @return boolean
		 */
		public function is_table_exists( $table = null ) {

			global $wpdb;

			$table_name = $this->tables( $table, 'name' );

			if ( ! $table_name ) {
				return false;
			}

			return ( strtolower( $table_name ) === strtolower( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) ) );
		}

		/**
		 * Create table if allowed
		 * @return [type] [description]
		 */
		public function create_table( $table = null ) {

			global $wpdb;

			$charset_collate = $wpdb->get_charset_collate();
			$table_data      = $this->tables( $table );

			if ( ! $table_data ) {
				return;
			}

			$table_name  = $table_data['name'];
			$table_query = $table_data['query'];

			$sql = "CREATE TABLE $table_name (
				$table_query
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			dbDelta( $sql );

		}

		/**
		 * Returns total rows count in requested table
		 *
		 * @param  string   $table  Table name.
		 * @return int
		 */
		public function count( $table ) {

			global $wpdb;

			$table_name = $this->tables( $table, 'name' );
			return $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		}

		/**
		 * Clear all table data
		 *
		 * @param  string   $table  Table name.
		 */
		public function clear_table( $table ) {

			global $wpdb;

			$table_name = $this->tables( $table, 'name' );

			$wpdb->query("TRUNCATE TABLE {$table_name}");

		}

		/**
		 * Query data from passed table by passed args
		 *
		 * @param  string   $table  Table name.
		 * @param  array    $args   Args array.
		 * @param  callable $filter Callback to filter results.
		 * @return array
		 */
		public function query( $table = null, $args = array(), $filter = null ) {

			global $wpdb;

			$table_name = $this->tables( $table, 'name' );
			$query      = "SELECT * FROM $table_name";

			if ( ! empty( $args ) ) {

				$query .= ' WHERE ';
				$glue   = '';

				foreach ( $args as $key => $value ) {

					if ( ! is_array( $value ) ) {
						$query .= sprintf( '`%1$s` = \'%2$s\'', esc_sql( $key ), esc_sql( $value ) );
					} else {
						$value  = array_map( 'esc_sql', $value );
						$query .= sprintf( '`%1$s` IN (%2$s)', esc_sql( $key ), implode( ',' , $value ) );
					}

					$query .= $glue;
					$glue   = ' AND ';

				}

			}

			$query .= " ORDER BY id DESC";
			$raw    = $wpdb->get_results( $query, ARRAY_A );

			if ( ! $raw ) {
				$raw = array();
			}

			if ( ! $filter ) {
				return $raw;
			} else {
				return array_map( $filter, $raw );
			}

		}

	}

}
