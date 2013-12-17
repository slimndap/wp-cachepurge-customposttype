<?php
class Settings_purgepagecache_customposttype
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
		$this->options = get_option( 'purgepagecache-customposttype' );
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		
   }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
       // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Purge Page Cache', 
            'manage_options', 
            'purgepagecache-customposttype-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
 		print_r($this->options);
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Purge Page Cache for Custom Post Types</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'purgepagecache-customposttype_group' );   
                do_settings_sections( 'purgepagecache-customposttype-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'purgepagecache-customposttype_group', // Option group
            'purgepagecache-customposttype', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'purgepagecache-customposttype-post_types', // ID
            __('Custom Post Types','purgepagecache-customposttype'), // Title
            array( $this, 'post_types' ), // Callback
            'purgepagecache-customposttype-admin' // Page
        );  


		$args = array(
		   'public'   => true,
		   '_builtin' => false
		);
		
		$output = 'objects'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'
		
		$post_types = get_post_types( $args, $output, $operator ); 
		
		foreach ( $post_types  as $post_type ) {
			$args = array(
				'post_type' => $post_type->name
			);
	        add_settings_field(
	            'post_type_'.$post_type->name, // ID
	            $post_type->name, // Title 
	            array( $this, 'post_type'), // Callback
	            'purgepagecache-customposttype-admin', // Page
	            'purgepagecache-customposttype-post_types', // Section 
	             $args
	        );      
		}
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
    print_r($input);
        $new_input = array();

        if( isset( $input['post_type'] ) ) {
			$new_input['post_type'] = $input['post_type'];
		}

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function post_types()
    {
    }

    public function post_type($args)
    {
        printf(
            '<input type="text" id="post_type_'.$args['post_type'].'" name="post_type[]" value="'.$args['post_type'].'" %s />',
    		(isset( $this->options['post_type'] ) && (esc_attr( $this->options['post_type'])=='yes')) ? 'checked="checked"' : ''
        );
    }

}

if( is_admin() )
    $Settings_purgepagecache_customposttype = new Settings_purgepagecache_customposttype();