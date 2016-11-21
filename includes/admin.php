<?php
/**
 * Admin Page & Options
 *
 * @author Getnudged
 */
 
/**
 * top level menu
 */
function helpful_options_page()
{
    // add top level menu page
    add_options_page(
        'Helpful',
        'Helpful',
        'manage_options',
        'helpful',
        'helpful_options_page_html'
    );
}
 
/**
 * register our options_page to the admin_menu action hook
 */
add_action('admin_menu', 'helpful_options_page');
 
/**
 * top level menu:
 * callback functions
 */
function helpful_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
 
    // show error/update messages
    settings_errors('helpful_messages');
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('helpful');
            do_settings_sections('helpful');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
 
/**
 * custom option and settings
 */
function helpful_settings_init()
{
    // register a new setting for "helpful" page
    register_setting('helpful', 'helpful_options');
 
    // register a new section in the "helpful" page
    add_settings_section(
        'helpful_section_texts',
        __('Texte bearbeiten'),
        'helpful_section_texts_cb',
        'helpful'
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_question_text',
        __('Frage'),
        'helpful_field_question_text_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_question_text',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_button_text_y',
        __('Antwort: Ja'),
        'helpful_field_button_text_y_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_button_text_y',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_button_text_n',
        __('Antwort: Nein'),
        'helpful_field_button_text_n_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_button_text_n',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_message_save',
        __('Meldung: Vielen Dank'),
        'helpful_field_message_save_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_message_save',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_count_single',
        __('Stimmen: Einzahl'),
        'helpful_field_count_single_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_count_single',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_count_more',
        __('Stimmen: Mehrzahl'),
        'helpful_field_count_more_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_count_more',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_table_pro',
        __('Tabellenspalte: Hilfreich'),
        'helpful_field_table_pro_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_table_pro',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_texts_cb" section
    add_settings_field(
        'helpful_field_table_con',
        __('Tabellenspalte: Nicht hilfreich'),
        'helpful_field_table_con_cb',
        'helpful',
        'helpful_section_texts',
        [
            'label_for'         => 'helpful_field_table_con',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new section in the "helpful" page
    add_settings_section(
        'helpful_section_design',
        __('Design bearbeiten'),
        'helpful_section_design_cb',
        'helpful'
    );
 
    // register a new field in the "helpful_section_design_cb" section
    add_settings_field(
        'helpful_field_button_text_color',
        __('Textfarbe (normal)'),
        'helpful_field_button_text_color_cb',
        'helpful',
        'helpful_section_design',
        [
            'label_for'         => 'helpful_field_button_text_color',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_design_cb" section
    add_settings_field(
        'helpful_field_button_background_color',
        __('Hintergrundfarbe (normal)'),
        'helpful_field_button_background_color_cb',
        'helpful',
        'helpful_section_design',
        [
            'label_for'         => 'helpful_field_button_background_color',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_design_cb" section
    add_settings_field(
        'helpful_field_button_text_color_h',
        __('Textfarbe (hover)'),
        'helpful_field_button_text_color_h_cb',
        'helpful',
        'helpful_section_design',
        [
            'label_for'         => 'helpful_field_button_text_color_h',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_design_cb" section
    add_settings_field(
        'helpful_field_button_background_color_h',
        __('Hintergrundfarbe (hover)'),
        'helpful_field_button_background_color_h_cb',
        'helpful',
        'helpful_section_design',
        [
            'label_for'         => 'helpful_field_button_background_color_h',
            'class'             => 'helpful_row',
        ]
    );
 
    // register a new field in the "helpful_section_design_cb" section
    add_settings_field(
        'helpful_field_button_border_radius',
        __('Rundung'),
        'helpful_field_button_border_radius_cb',
        'helpful',
        'helpful_section_design',
        [
            'label_for'         => 'helpful_field_button_border_radius',
            'class'             => 'helpful_row',
        ]
    );
}
 
/**
 * register our settings_init to the admin_init action hook
 */
add_action('admin_init', 'helpful_settings_init');
 
/**
 * custom option and settings:
 * callback functions
 */
 
// text section cb
function helpful_section_texts_cb($args)
{
    ?>
    <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Hier k&ouml;nnen Sie die einzelnen Texte bearbeiten.'); ?></p>
    <?php
}
 
// button yes text field callback
function helpful_field_button_text_y_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>"  
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_text_y']); ?>"
		   placeholder="Ja"
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird als Antwortm&ouml;glichkeit auf dem "Ja" Button angezeigt.'); ?>
    </p>
    <?php
}
 
// button no text field callback
function helpful_field_button_text_n_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>"  
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_text_n']); ?>"
		   placeholder="Nein"
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird als Antwortm&ouml;glichkeit  auf dem "Nein" Button angezeigt.'); ?>
    </p>
    <?php
}
 
// question text field callback
function helpful_field_question_text_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_question_text']); ?>"
		   placeholder="Was dieser Artikel hilfreich?"
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird als Frage vor den Buttons angezeigt.'); ?>
    </p>
    <?php
}
 
// message save text field callback
function helpful_field_message_save_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_message_save']); ?>"
		   placeholder="Vielen Dank. Ihre Bewertung wurde gespeichert."
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird angezeigt, sobald Ihr Besucher f&uuml;r Ihren Artikel abgestimmt hat.'); ?>
    </p>
    <?php
}
 
// single count text field callback
function helpful_field_count_single_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_count_single']); ?>"
		   placeholder="1 Person fand diesen Artikel hilfreich."
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird angezeigt, sobald mehr eine Stimme vorhanden ist.'); ?>
    </p>
    <?php
}
 
// more count text field callback
function helpful_field_count_more_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_count_more']); ?>"
		   placeholder="%d Personen fanden diesen Artikel hilfreich."
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird angezeigt, sobald mehr als eine Stimme vorhanden ist. (%d = Personenanzahl)'); ?>
    </p>
    <?php
}
 
// table pro text field callback
function helpful_field_table_pro_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_table_pro']); ?>"
		   placeholder="Hilfreich"
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird als Spaltenname f&uuml;r die positiven Stimmen in Ihrer Beitrags&uuml;bersicht Ihres /wp-admin angezeigt.'); ?>
    </p>
    <?php
}
 
// table contra text field callback
function helpful_field_table_con_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="regular-text"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_table_con']); ?>"
		   placeholder="Nicht hilfreich"
	/>
    <p class="description">
        <?= esc_html('Dieser Text wird als Spaltenname f&uuml;r die negativen Stimmen in Ihrer Beitrags&uuml;bersicht Ihres /wp-admin angezeigt.'); ?>
    </p>
    <?php
}
 
// design section cb
function helpful_section_design_cb($args)
{
    ?>
    <p id="<?= esc_attr($args['id']); ?>"><?= esc_html__('Hier k&ouml;nnen Sie bestimmte Elemente der Buttons designen.'); ?></p>
    <?php
}

// button text color field callback
function helpful_field_button_text_color_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="code"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_text_color']); ?>"
		   placeholder="#666666"
	/>
    <?php
}

// button background color field callback
function helpful_field_button_background_color_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="code"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_background_color']); ?>"
		   placeholder="#F5F5F5"
	/>
    <?php
}

// button text hover color field callback
function helpful_field_button_text_color_h_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="code"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_text_color_h']); ?>"
		   placeholder="#FFFFFF"
	/>
    <?php
}

// button background hover color field callback
function helpful_field_button_background_color_h_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>"
		   class="code" 
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_background_color_h']); ?>"
		   placeholder="#333333"
	/>
    <?php
}

// button border radius field callback
function helpful_field_button_border_radius_cb($args)
{
    // get the value of the setting we've registered with register_setting()
    $options = get_option('helpful_options');
    // output the field
    ?>
	
	<input type="text" 
		   id="<?= esc_attr($args['label_for']); ?>" 
		   class="code"
		   name="helpful_options[<?= esc_attr($args['label_for']); ?>]"
		   value="<?= esc_html($options['helpful_field_button_border_radius']); ?>"
		   placeholder="3px"
	/>
    <?php
}
