<?php namespace QuestionAnswer;

use Premmerce\SDK\V2\FileManager\FileManager;
use QuestionAnswer\Admin\Admin;
use QuestionAnswer\Admin\Customizer;
use QuestionAnswer\Frontend\Frontend;
use QuestionAnswer\Admin\Settings;

/**
 * Class QuestionAnswerPlugin
 *
 * @package QuestionAnswer
 */
class QuestionAnswerPlugin {

    const DOMAIN = 'wp-question-answer';

    const BASE_NAME = 'wp-question-answer/question-answer.php';

    const VERSION = '1.0.0';

	/**
	 * @var FileManager
	 */
	private $fileManager;

    /**
     * @var options
     */
    private $options;

	/**
	 * QuestionAnswerPlugin constructor.
	 *
     * @param string $mainFile
	 */
    public function __construct($mainFile) {

        $this->fileManager = new FileManager($mainFile);
        $this->options = get_option( Settings::OPTIONS );

        add_action('plugins_loaded', [ $this, 'loadTextDomain' ]);

	}

	/**
	 * Run plugin part
	 */
	public function run() {

        $this->registerHooks();

		if (is_admin()) {
			new Admin( $this->fileManager );
		} else {
			new Frontend( $this->fileManager );
		}
        new Customizer();



	}

    private function registerHooks()
    {
        add_action('init', array($this, 'createQuestionPostType'));
    }





    /**
     * Configurate and register brands taxonomy
     */
    public function createQuestionPostType()
    {

        $labels = array(
            'name'              => __('Сategories', 'wp-question-answer'),
            'singular_name'     => __('Сategori', 'wp-question-answer'),
        );
        // параметры
        $args = array(
            'show_in_nav_menus' => true,
            'show_admin_column'  => true,
            'show_in_quick_edit' => true,
            'label'  => '',
            'labels' => $labels,
            'hierarchical' => true,
        );

        register_taxonomy('question_cat','question', $args );


        register_post_type('question',
            array(

                'labels' => array(
                    'name' => __('Questions', 'wp-question-answer'),
                    'singular_name' => __('Question', 'wp-question-answer'),
                    'add_new' => __('Add question', 'wp-question-answer'),
                    'add_new_item' => __('Add new question', 'wp-question-answer'),
                    'edit_item' => __('Edit question', 'wp-question-answer'),
                    'new_item' => __('New question', 'wp-question-answer'),
                    'view_item' => __('View question', 'wp-question-answer'),
                    'search_items' => __('Search questions', 'wp-question-answer'),
                    'not_found' => __('Questions not found', 'wp-question-answer')
                ),
                'public' => true,
                'hierarchical' => false,
                'supports' => array( 'title', 'editor'),
                'menu_position' => 50,
                'menu_icon' =>'dashicons-format-status',
                'rewrite'             => array( 'slug'=>'questions', 'with_front'=>false, 'pages'=>false, 'feeds'=>false, 'feed'=>false ),
                'has_archive'         => true

            ));

        if($this->options['plugin_first_load']){
            flush_rewrite_rules();
            $this->options['plugin_first_load'] = false;
            update_option(Settings::OPTIONS, $this->options);
        }


    }



    /**
     * Load plugin translations
     */
    public function loadTextDomain()
    {
        $name = $this->fileManager->getPluginName();
        load_plugin_textdomain('wp-question-answer', false, $name . '/languages/');
    }

	/**
	 * Fired when the plugin is activated
	 */
	public function activate() {
		// TODO: Implement activate() method.

        if (! get_page_by_title('Question & Answer')) {
            $post_data = array(
                'post_title'   => 'Question & Answer',
                'post_content' => '[questions_page]',
                'post_status'  => 'publish',
                'post_author'  => 1,
                'post_type'    => 'page',
            );

            wp_insert_post($post_data);
        }


        $this->options['plugin_first_load'] = true;
        update_option(Settings::OPTIONS, $this->options);

	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate() {
		// TODO: Implement deactivate() method.
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall() {
		// TODO: Implement uninstall() method.

        delete_option(Settings::OPTIONS);
	}
}