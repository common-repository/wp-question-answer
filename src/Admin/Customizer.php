<?php
namespace QuestionAnswer\Admin;


/**
 * Class Customizer
 *
 * @package QuestionAnswer\Admin
 */



class Customizer
{


    public function __construct()
    {

        $this->registerHooks();
    }

    public function registerHooks(){
        add_action('customize_register', array($this, 'addSection'));
        add_action('customize_register', array($this, 'addSettings'));
    }

    public function addSection($wp_customize){


        $wp_customize->add_section( 'wpqa_settings' , array(
            'title'      => __('Q&A Settings', 'wp-question-answer'),
            'priority'   => 200,
        ) );

    }


    public function addSettings($wp_customize){


        $selectOptions = array('choices' => array(
            'questions' => __( 'Questions and answers' ),
            'categories' => __( 'Q & A with categories' ),
        ),
            'default' => 'questions',
        );

        $this->addSetting('qa_select_template', 'select', 'Select template', $wp_customize, $selectOptions);


        $selectOptions = array('choices' => array(
            'qa_visible' => __( 'Questions and answers are visible' ),
            'question_link' => __( 'Questions - links, answers are hidden' ),
//            'ansver_show_on_click' => __( 'Answers are shown on click' ),
        ),
            'default' => 'qa_visible',

        );

        $this->addSetting('qa_display_settings', 'select', 'Display Settings', $wp_customize, $selectOptions);

    }

    private function addSetting($name, $type, $label, $wp_customize, $args = array())
    {

        $default = array(
            'default' => '',
            'description' => ''
        );
        $args = array_merge($default, $args);

        switch ($type) {
            case 'text':
                $wp_customize->add_setting($name);
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.' . $name
                ));
                $wp_customize->add_control($name, array(
                        'label' => __($label, 'wp-question-answer'),
                        'section' => 'wpqa_settings',
                        'type' => $type,
                    )
                );
                break;

            case 'select':
                $wp_customize->add_setting($name, array(
                    'capability' => 'edit_theme_options',
                    //'sanitize_callback' => 'themeslug_sanitize_select',
                    'default' => $args['default'],
                ));

                $wp_customize->add_control($name, array(
                    'type' => 'select',
                    'section' => 'wpqa_settings',
                    'label' => __($label, 'wp-question-answer'),
                    'description' => __($args['description'], 'wp-question-answer'),
                    'choices' => $args['choices'],
                ));
                break;
        }

    }







}