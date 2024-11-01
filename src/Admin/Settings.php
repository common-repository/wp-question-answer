<?php namespace QuestionAnswer\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;

class Settings
{

    const OPTIONS = 'wp_question_answer';

    const SETTINGS_PAGE = 'anchor_smooth_scroll_page';

    /**
     * @var FileManager
     */
    private $fileManager;


    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function register()
    {
        register_setting(self::OPTIONS, self::OPTIONS, array(
            'sanitize_callback' => array($this, 'updateSettings'),
        ));

        add_settings_section('menu_settings', __('', 'anchor_smooth_scroll'), array(
            $this,
            'menuSection',
        ), self::SETTINGS_PAGE);

    }

    public function show()
    {
        print('<form action="' . admin_url('options.php') . '" method="post">');

        //settings_errors();

        settings_fields(self::OPTIONS);

        do_settings_sections(self::SETTINGS_PAGE);

        submit_button();
        print('</form>');
    }

    public function menuSection()
    {
        $this->fileManager->includeTemplate('admin/section/menu-settings.php', array(
            'offset' => $this->getOption('offset'),
            'scroll_duration' => $this->getOption('scroll_duration'),
            'custom_anchor_selector' => $this->getOption('custom_anchor_selector'),
            'remove_anchor_highlight' => $this->getOption('remove_anchor_highlight'),
            'disable_theme_scroll' => $this->getOption('disable_theme_scroll'),
            'only_reload' => $this->getOption('only_reload')
        ));
    }


    public function updateSettings($settings)
    {
        return $settings;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        if (!isset($this->options)) {
            $this->options = get_option(self::OPTIONS);
        }

        return isset($this->options[ $key ])? $this->options[ $key ] : $default;
    }
}
