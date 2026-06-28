<?php
if (!defined('ABSPATH')) exit;

class HFRCM_Block_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'hfrcm_block'; }
    public function get_title() { return 'HealthFlow Block'; }
    public function get_icon() { return 'eicon-h-stack'; }
    public function get_categories() { return ['general']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Block Settings',
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('block_type', [
            'label' => 'Block Type',
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'hero',
            'options' => [
                'hero' => 'Hero Section',
                'section_header' => 'Section Header',
                'feature_grid' => 'Feature Cards Grid',
                'stat_bar' => 'Stats Bar',
                'cta' => 'Call to Action',
            ],
        ]);

        $this->add_control('title', [
            'label' => 'Title',
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Enter Title Here',
            'condition' => ['block_type' => ['hero', 'section_header', 'cta']],
        ]);

        $this->add_control('subtitle', [
            'label' => 'Subtitle / Label',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Section Label',
            'condition' => ['block_type' => ['hero', 'section_header', 'cta']],
        ]);

        $this->add_control('description', [
            'label' => 'Description',
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => 'Enter description here.',
            'condition' => ['block_type' => ['hero', 'section_header', 'cta']],
        ]);

        $this->add_control('btn_text', [
            'label' => 'Button Text',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Click Here',
            'condition' => ['block_type' => ['hero', 'cta']],
        ]);

        $this->add_control('btn_link', [
            'label' => 'Button Link',
            'type' => \Elementor\Controls_Manager::URL,
            'default' => [
                'url' => '/book-a-consultation/',
                'is_external' => false,
                'nofollow' => false,
            ],
            'condition' => ['block_type' => ['hero', 'cta']],
        ]);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control('item_title', [
            'label' => 'Title / Number',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Item Title',
        ]);
        $repeater->add_control('item_desc', [
            'label' => 'Description',
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Item description goes here.',
        ]);
        $repeater->add_control('item_icon', [
            'label' => 'Icon (Emoji or HTML)',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '⚙️',
        ]);

        $this->add_control('items', [
            'label' => 'Grid Items',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['item_title' => 'Item 1', 'item_desc' => 'Description 1', 'item_icon' => '⚙️'],
                ['item_title' => 'Item 2', 'item_desc' => 'Description 2', 'item_icon' => '📊'],
                ['item_title' => 'Item 3', 'item_desc' => 'Description 3', 'item_icon' => '🔒'],
            ],
            'condition' => ['block_type' => ['feature_grid', 'stat_bar']],
            'title_field' => '{{{ item_title }}}',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $type = $settings['block_type'];
        $title = $settings['title'];
        $subtitle = $settings['subtitle'];
        $desc = $settings['description'];
        $btn = $settings['btn_text'];
        $link = !empty($settings['btn_link']['url']) ? $settings['btn_link']['url'] : '#';

        if ($type === 'hero') {
            echo '<section class="hero" style="position:relative; z-index:1;"><div class="container"><div class="hero-content">';
            if ($subtitle) echo '<span class="section-label"><span class="dot"></span> ' . esc_html($subtitle) . '</span>';
            echo '<h1>' . wp_kses_post($title) . '</h1>';
            echo '<div class="hero-desc">' . wp_kses_post($desc) . '</div>';
            if ($btn) echo '<div class="hero-btns"><a href="'.esc_url($link).'" class="btn btn-primary btn-lg">'.esc_html($btn).' <span class="arrow">&rarr;</span></a></div>';
            echo '</div></div></section>';
        } 
        elseif ($type === 'section_header') {
            echo '<div class="container text-center" style="padding: 60px 0 30px;"><div class="fade-in">';
            if ($subtitle) echo '<span class="section-label"><span class="dot"></span> ' . esc_html($subtitle) . '</span>';
            echo '<h2 class="section-title">' . wp_kses_post($title) . '</h2>';
            echo '<div class="section-subtitle mx-auto">' . wp_kses_post($desc) . '</div>';
            echo '</div></div>';
        }
        elseif ($type === 'cta') {
            echo '<section class="section section-primary"><div class="container text-center"><div class="fade-in">';
            echo '<h2 style="font-size:clamp(1.8rem,3.5vw,2.6rem);color:#fff;margin-bottom:18px;">' . wp_kses_post($title) . '</h2>';
            echo '<div style="color:rgba(255,255,255,0.85);font-size:1.1rem;max-width:600px;margin:0 auto 36px;">' . wp_kses_post($desc) . '</div>';
            if ($btn) echo '<a href="'.esc_url($link).'" class="btn btn-white btn-lg">'.esc_html($btn).' <span class="arrow">&rarr;</span></a>';
            echo '</div></div></section>';
        }
        elseif ($type === 'feature_grid') {
            echo '<div class="container" style="padding-bottom: 60px;"><div class="why-grid">';
            foreach ($settings['items'] as $item) {
                echo '<div class="card"><div class="card-icon">'.wp_kses_post($item['item_icon']).'</div>';
                echo '<h3 class="card-title">'.esc_html($item['item_title']).'</h3>';
                echo '<p class="card-text">'.wp_kses_post($item['item_desc']).'</p></div>';
            }
            echo '</div></div>';
        }
        elseif ($type === 'stat_bar') {
            echo '<section class="stats-bar section-primary section-sm"><div class="container"><div class="stats-grid">';
            foreach ($settings['items'] as $item) {
                echo '<div class="stat-item"><div class="stat-number">'.esc_html($item['item_title']).'</div><div class="stat-label">'.wp_kses_post($item['item_desc']).'</div></div>';
            }
            echo '</div></div></section>';
        }
    }
}
