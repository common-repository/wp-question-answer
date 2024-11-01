<?php namespace QuestionAnswer\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;
use QuestionAnswer\QuestionAnswerPlugin;

/**
 * Class Admin
 *
 * @package QuestionAnswer\Admin
 */
class Admin {

	/**
	 * @var FileManager
	 */
	private $fileManager;

	private $settings;

	/**
	 * Admin constructor.
	 *
	 * Register menu items and handlers
	 *
	 * @param FileManager $fileManager
	 */
	public function __construct( FileManager $fileManager ) {
		$this->fileManager = $fileManager;
        $this->settings = new Settings($fileManager);
        $this->registerHooks();
	}

    private function registerHooks()
    {
        add_filter('plugin_action_links_' . QuestionAnswerPlugin::BASE_NAME, array($this, 'qaActionsLink'));

    }



    public function qaActionsLink($links)
    {
        $action_links = array(
            'settings' => '<a href="' .
                wp_kses(esc_url(add_query_arg(array(
                    'autofocus' => array(
                        'section' => 'wpqa_settings',
                    ),
                    'url' => home_url(),
                ), admin_url('customize.php'))), array(
                    'a' => array(
                        'href' => array(),
                        'title' => array(),
                    ),
                ))

                . '" aria-label="' . esc_attr__('View WP Questions and Answers settings', 'wp-question-answer') . '">' . esc_html__('Settings', 'wp-question-answer') . '</a>',
        );

        return array_merge($action_links, $links);
    }



}