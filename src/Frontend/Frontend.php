<?php namespace QuestionAnswer\Frontend;

use Premmerce\SDK\V2\FileManager\FileManager;
use WP_Query;

/**
 * Class Frontend
 *
 * @package QuestionAnswer\Frontend
 */
class Frontend {


	/**
	 * @var FileManager
	 */
	private $fileManager;

	public function __construct( FileManager $fileManager ) {
        $this->registerHooks();
		$this->fileManager = $fileManager;
	}

    private function registerHooks()
    {
        add_shortcode('questions_page', array($this, 'QuestionsPage'));

    }


    /**
     * Include questions page template
     */
    public function QuestionsPage()
    {

        $template = get_theme_mod('qa_select_template', 'questions');
        $displaySettings = get_theme_mod('qa_display_settings', 'questions');

        if( $template == 'questions') {
            $args = apply_filters('inprocess_pre_get_questions', array(
                'post_type'   => 'question',
                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                'posts_per_page' => -1
            ));

            $query = new WP_Query($args);

            if (!is_wp_error($query)) {
                return   $this->fileManager->renderTemplate("frontend/questions-page.php", array(
                    'questions' => $query,
                    'display' => $displaySettings
                ));
            }

        }else {
            $args = array(
                'taxonomy' => 'question_cat',
                'hide_empty' => true,
            );
            $terms = get_terms($args);


            $html = '';

            foreach ($terms as $term) {

                $html .=   $this->fileManager->renderTemplate("frontend/term-title.php", array('term' => $term));

                    $args = array(
                        'post_type' => 'question',
                        'posts_per_page' => -1,
                        'tax_query' => array(array(
                            'taxonomy' => $term->taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id
                        )),
                        'post_parent' => 0
                    );

                    $query = new WP_Query($args);

                $html .=   $this->fileManager->renderTemplate("frontend/questions-page.php", array(
                    'questions' => $query,
                    'display' => $displaySettings
                ));

            }

            return $html;
        }

    }

    public static function qaPagenavi($query = false) {

        if(!$query){
            global $wp_query;
            $query = $wp_query;
        }
        $big = 999999999;

        $args = array(
            'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format'  => '',
            'current' => max( 1, get_query_var('paged') ),
            'total'   => $query->max_num_pages,
            'prev_text'    => '&larr;',
            'next_text'    => '&rarr;',
            //'type'         => 'list',
            'end_size'     => 3,
            'mid_size'     => 3
        );

        $result = paginate_links( $args );

        $result = str_replace( '/page/1/', '', $result );

        echo $result;
    }


}