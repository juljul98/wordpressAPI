<?php

if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Authentication_List extends WP_List_Table {

	function __construct() {
		parent::__construct([
			'singular' => __( 'User', 'sp' ),
			'plural'   => __( 'Users', 'sp' ),
			'ajax'     => false
		]);
	}

	public function get_users( $per_page = 5, $page_number = 1 ) {

		global $wpdb;
		$sql = "SELECT ID ,user_login, user_pass, user_email FROM {$wpdb->prefix}users";
		if ( ! empty( $_REQUEST['orderby'] ) ) {
		    $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
		    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}
		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;

	}

	function get_columns() {
	    $columns = [
		    'cb'      => '<input type="checkbox" />',
		    'user_login'    => 'Username',
		    'user_pass'    =>  'Password',
		    'user_email' =>  'Email'
		    
		  ];
		return $columns;
	}

	public function column_default( $item, $column_name ) {
		  switch ( $column_name ) {
		  	case 'cb' :
		    case 'user_login':
		    case 'user_pass':
		    case 'user_email':
		      return $item[ $column_name ];
		    default:
		      return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public static function record_count() {
	    global $wpdb;
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}users";
		return $wpdb->get_var( $sql );
	}

	function column_name( $item ) {

  		$delete_nonce = wp_create_nonce( 'sp_delete_users' );
		$title = '<strong>' . $item['name'] . '</strong>';
	    $actions = [
		    'delete' => sprintf( '<a href="?page=%s&action=%s&users=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];
		return $title . $this->row_actions( $actions );
    }

	function column_cb( $item ) {
		return sprintf(
		   '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		 );
	}

	public function get_sortable_columns() {
		  $sortable_columns = array(
		    'user_login' => array( 'user_login', true ),
		    'user_pass' => array( 'user_pass', true ),
		    'user_email' => array( 'user_email', true )

		  );

		  return $sortable_columns;
	}

	function prepare_items() {

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'users_per_page', 2 );
		$current_page = $this->get_pagenum();
	    $total_items  = self::record_count();

		$this->set_pagination_args( [
		    'total_items' => $total_items, 
		    'per_page'    => $per_page, 
		   
		] );

		$this->items = self::get_users( $per_page, $current_page );
	}

	public function no_items() {
  		_e( 'No users avaliable.', 'sp' );
	}

	public static function delete_users( $id ) {
		global $wpdb;
		$wpdb->delete(
		   "{$wpdb->prefix}users",
		   [ 'ID' => $id ],
		   [ '%d' ]
		);
		return 'Na delete na Nigga';
	}

	public function get_bulk_actions() {
	    $actions = [
	      'bulk-delete' => 'Delete'
	    ];
	    return $actions;
	}

	public function process_bulk_action() {

		  if ( 'delete' === $this->current_action() ) {
		    $nonce = esc_attr( $_REQUEST['_wpnonce'] );
		    if ( ! wp_verify_nonce( $nonce, 'delete_users' ) ) {
		      die( 'Go get a life script kiddies' );
		    }
		    else {
		      self::delete_users( absint( $_GET['users'] ) );
		      wp_redirect( esc_url( add_query_arg() ) );
		      exit;
		    }
		  }
		  if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		       || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		  ) {
		    $delete_ids = esc_sql( $_POST['bulk-delete'] );
		    foreach ( $delete_ids as $id ) {
		      self::delete_users( $id );
		    }
		    wp_redirect( esc_url( add_query_arg() ) );
		    exit;
		  }
	}

}