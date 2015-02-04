<?php

class Hrm_Init{
	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new Hrm_Init();
        }

        return self::$_instance;
    }

    function register_post_type() {
    	  register_post_type( 'hrm_project', array(
            'label' => __( 'Project', 'hrm' ),
            'description' => __( 'project manager post type', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),
            'labels' => array(
                'name' => __( 'Project', 'hrm' ),
                'singular_name' => __( 'Project', 'hrm' ),
                'menu_name' => __( 'Project', 'hrm' ),
                'add_new' => __( 'Add Project', 'hrm' ),
                'add_new_item' => __( 'Add New Project', 'hrm' ),
                'edit' => __( 'Edit', 'hrm' ),
                'edit_item' => __( 'Edit Project', 'hrm' ),
                'new_item' => __( 'New Project', 'hrm' ),
                'view' => __( 'View Project', 'hrm' ),
                'view_item' => __( 'View Project', 'hrm' ),
                'search_items' => __( 'Search Project', 'hrm' ),
                'not_found' => __( 'No Project Found', 'hrm' ),
                'not_found_in_trash' => __( 'No Project Found in Trash', 'hrm' ),
                'parent' => __( 'Parent Project', 'hrm' ),
            ),
        ) );

        register_post_type( 'hrm_task', array(
            'label' => __( 'Task', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),

        ) );

        register_post_type( 'hrm_file', array(
            'label' => __( 'File', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),

        ) );

        register_post_type( 'hrm_Punch', array(
            'label' => __( 'Punch', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),
        ) );

		register_post_type( 'hrm_punch', array(
            'label' => __( 'Punch', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),
        ));

        register_post_type( 'hrm_rating', array(
            'label' => __( 'Rating', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),
        ));

        register_post_type( 'hrm_rating_parent', array(
            'label' => __( 'Rating', 'hrm' ),
            'public' => false,
            'show_in_admin_bar' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_admin_bar' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => ''),
            'query_var' => true,
            'supports' => array('title', 'editor'),
        ));
    }
}