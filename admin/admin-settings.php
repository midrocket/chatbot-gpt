<?php

function midrocket_chatbot_gpt_add_admin_menu()
{
    add_menu_page(
        'Chatbot GPT Settings',
        'Chatbot Settings',
        'manage_options',
        'midrocket_chatbot_gpt_settings',
        'midrocket_chatbot_gpt_settings_page'
    );
}
add_action('admin_menu', 'midrocket_chatbot_gpt_add_admin_menu');

function midrocket_chatbot_gpt_settings_page()
{
    ?>
<div class="wrap">
    <h2>Chatbot GPT</h2>
    <h2 class="nav-tab-wrapper">
        <a href="#main-settings" class="nav-tab nav-tab-active" id="main-settings-tab">Main Settings</a>
        <a href="#style-settings" class="nav-tab" id="style-settings-tab">Style</a>
        <a href="#knowledge-settings" class="nav-tab" id="knowledge-settings-tab">Knowledge</a>
        <a href="#api-settings" class="nav-tab" id="api-settings-tab">API Settings</a>
    </h2>
    <div id="main-settings" class="tab-content">
        <form action="options.php" method="post">
            <?php
            settings_fields('midrocket_chatbot_gpt_options_group');
            do_settings_sections('midrocket_chatbot_gpt_settings_main');
            submit_button();
    ?>
        </form>
    </div>
    <div id="style-settings" class="tab-content" style="display: none;">
        <form action="options.php" method="post">
            <?php
            settings_fields('midrocket_chatbot_gpt_options_group');
            do_settings_sections('midrocket_chatbot_gpt_settings_style');
            submit_button();
            ?>
        </form>
    </div>
    <div id="knowledge-settings" class="tab-content" style="display: none;">
        <form action="options.php" method="post">
            <?php
            settings_fields('midrocket_chatbot_gpt_options_group');
            do_settings_sections('midrocket_chatbot_gpt_settings_knowledge');
            submit_button();
            ?>
        </form>
    </div>
    <div id="api-settings" class="tab-content" style="display: none;">
        <form action="options.php" method="post">
            <?php
            settings_fields('midrocket_chatbot_gpt_options_group');
            do_settings_sections('midrocket_chatbot_gpt_settings_api');
            submit_button();
            ?>
        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a.nav-tab, a.open-tab').click(function(e) {
            e.preventDefault();
            $('.nav-tab').removeClass('nav-tab-active');
            $tab = $(this).data('target-tab') ?? $(this);
            $($tab).addClass('nav-tab-active');
            $('.tab-content').hide();
            $('#' + $(this).attr('href').substring(1)).show();
        });
    });
</script>
<?php
}

function midrocket_chatbot_gpt_settings_init()
{
    register_setting('midrocket_chatbot_gpt_options_group', 'midrocket_chatbot_gpt_options', 'midrocket_chatbot_gpt_options_validate');

    // Main Settings
    add_settings_section(
        'midrocket_chatbot_gpt_settings_main_section',
        'Main Settings',
        'midrocket_chatbot_gpt_main_settings_section_callback',
        'midrocket_chatbot_gpt_settings_main'
    );

    add_settings_field(
        'midrocket_chatbot_gpt_rules_prompt',
        'System Prompt',
        'midrocket_chatbot_gpt_rules_prompt_render',
        'midrocket_chatbot_gpt_settings_main',
        'midrocket_chatbot_gpt_settings_main_section'
    );

    // Knowledge / Automatic Knowledge
    add_settings_section(
        'midrocket_chatbot_gpt_settings_knowledge_a_section',
        'Automatic Knowledge',
        'midrocket_chatbot_gpt_knowledge_settings_a_section_callback',
        'midrocket_chatbot_gpt_settings_knowledge'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_knowledge_automatic',
        'Generate Knowledge',
        'midrocket_chatbot_gpt_knowledge_automatic_render',
        'midrocket_chatbot_gpt_settings_knowledge',
        'midrocket_chatbot_gpt_settings_knowledge_a_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_separator_knowledge_a',
        '',
        'midrocket_chatbot_gpt_separator_render',
        'midrocket_chatbot_gpt_settings_knowledge',
        'midrocket_chatbot_gpt_settings_knowledge_a_section'
    );

    // Knowledge / Manage Knowledge
    add_settings_section(
        'midrocket_chatbot_gpt_settings_knowledge_m_section',
        'Manage Knowledge',
        'midrocket_chatbot_gpt_knowledge_settings_m_section_callback',
        'midrocket_chatbot_gpt_settings_knowledge'
    );

    // Style / Labels
    add_settings_section(
        'midrocket_chatbot_gpt_settings_labels_section',
        'Labels',
        'midrocket_chatbot_gpt_labels_section_callback',
        'midrocket_chatbot_gpt_settings_style'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_bot_title',
        'Bot Title',
        'midrocket_chatbot_gpt_bot_title_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_labels_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_intro_message',
        'Intro Message',
        'midrocket_chatbot_gpt_intro_message_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_labels_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_send_button',
        'Send Button',
        'midrocket_chatbot_gpt_send_button_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_labels_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_message_placeholder',
        'Message Placeholder',
        'midrocket_chatbot_gpt_message_placeholder_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_labels_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_separator_labels',
        '',
        'midrocket_chatbot_gpt_separator_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_labels_section'
    );

    // Style / Visibility
    add_settings_section(
        'midrocket_chatbot_gpt_settings_visibility_section',
        'Visibility',
        'midrocket_chatbot_gpt_visibility_section_callback',
        'midrocket_chatbot_gpt_settings_style'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_autoload_footer',
        'Autoload widget',
        'midrocket_chatbot_gpt_autoload_footer_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_visibility_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_opened_by_default',
        'Opened by Default',
        'midrocket_chatbot_gpt_opened_by_default_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_visibility_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_position',
        'Position',
        'midrocket_chatbot_gpt_position_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_visibility_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_separator_visibility',
        '',
        'midrocket_chatbot_gpt_separator_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_visibility_section'
    );

    // Style / Mode
    add_settings_section(
        'midrocket_chatbot_gpt_settings_mode_section',
        'Mode',
        'midrocket_chatbot_gpt_mode_section_callback',
        'midrocket_chatbot_gpt_settings_style'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_default_mode',
        'Default Mode',
        'midrocket_chatbot_gpt_default_mode_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_mode_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_dark_mode_toggle',
        'Show Dark Mode Toggle',
        'midrocket_chatbot_gpt_dark_mode_toggle_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_mode_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_separator_visibility',
        '',
        'midrocket_chatbot_gpt_separator_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_mode_section'
    );
    

    // Style / Customization
    add_settings_section(
        'midrocket_chatbot_gpt_settings_customization_section',
        'Customization',
        'midrocket_chatbot_gpt_customization_section_callback',
        'midrocket_chatbot_gpt_settings_style'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_icon',
        'Custom Bot Icon',
        'midrocket_chatbot_gpt_icon_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_customization_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_button_color',
        'Button Text Color',
        'midrocket_chatbot_gpt_button_color_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_customization_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_button_background_color',
        'Button Background Color',
        'midrocket_chatbot_gpt_button_background_color_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_customization_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_header_color',
        'Header Text Color',
        'midrocket_chatbot_gpt_header_color_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_customization_section'
    );   
    add_settings_field(
        'midrocket_chatbot_gpt_header_background_color',
        'Header Background Color',
        'midrocket_chatbot_gpt_header_background_color_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_customization_section'
    );    

    // Style / Customization
    add_settings_section(
        'midrocket_chatbot_gpt_settings_custom_code_section',
        'Custom code',
        'midrocket_chatbot_gpt_custom_code_section_callback',
        'midrocket_chatbot_gpt_settings_style'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_custom_css',
        'Custom CSS',
        'midrocket_chatbot_gpt_custom_css_render',
        'midrocket_chatbot_gpt_settings_style',
        'midrocket_chatbot_gpt_settings_custom_code_section'
    );

    // API
    add_settings_section(
        'midrocket_chatbot_gpt_settings_api_section',
        'API Settings',
        'midrocket_chatbot_gpt_api_settings_section_callback',
        'midrocket_chatbot_gpt_settings_api'
    );

    add_settings_field(
        'midrocket_chatbot_gpt_api_key',
        'OpenAI API Key',
        'midrocket_chatbot_gpt_api_key_render',
        'midrocket_chatbot_gpt_settings_api',
        'midrocket_chatbot_gpt_settings_api_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_model',
        'GPT Version',
        'midrocket_chatbot_gpt_model_render',
        'midrocket_chatbot_gpt_settings_api',
        'midrocket_chatbot_gpt_settings_api_section'
    );
    add_settings_field(
        'midrocket_chatbot_gpt_separator_api',
        '',
        'midrocket_chatbot_gpt_separator_render',
        'midrocket_chatbot_gpt_settings_api',
        'midrocket_chatbot_gpt_settings_api_section'
    );
    

}
add_action('admin_init', 'midrocket_chatbot_gpt_settings_init');

function midrocket_chatbot_gpt_separator_render() {
    echo '<hr>';
}

function midrocket_chatbot_gpt_style_settings_section_callback()
{
    echo '';
}

function midrocket_chatbot_gpt_api_settings_section_callback()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    $api_key = isset($options['api_key']) ? $options['api_key'] : null;
    if(!$api_key) {
        echo '<div class="notice notice-info">
            <p>You can obtain your API Key from OpenAI in <a href="https://platform.openai.com/api-keys" target="_blank"><strong>API Keys</strong></a> <a href="https://platform.openai.com/api-keys" target="_blank" style="text-decoration: none"><i class="fi fi-rr-up-right-from-square"></i></a>.</p>
        </div>';
    }
    echo '<div>
            <p>You can obtain your API Key from OpenAI in <a href="https://platform.openai.com/api-keys" target="_blank"><strong>API Keys</strong></a> <a href="https://platform.openai.com/api-keys" target="_blank" style="text-decoration: none"><i class="fi fi-rr-up-right-from-square"></i></a>.</p>
        </div>';
}

function midrocket_chatbot_gpt_main_settings_section_callback()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    $api_key = isset($options['api_key']) ? $options['api_key'] : null;
    if(!$api_key) {
        echo '<div class="notice notice-warning">
                <p>Please set-up your OpenAI <a href="#api-settings" class="open-tab" data-target-tab="#api-settings-tab"><strong>API Key</strong></a>.</p>
              </div>';
    }
}

// Knowledge
function midrocket_chatbot_gpt_knowledge_settings_a_section_callback()
{
    echo '<p>In this section you can generate all the questions and answers needed to your model from your internal pages content. Select the pagues you wish the model to take into consideration for Knowledge.</p>';
}

function midrocket_chatbot_gpt_knowledge_automatic_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
<div class="cgpt-flex"><button type="button" class="button button-secondary button-disabled">Start generating automatic
        Q&amp;A</button>
    <p class="csoon">Coming soon</p>
</div>
<?php
}

function midrocket_chatbot_gpt_knowledge_settings_m_section_callback()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    $knowledge = isset($options['knowledge']) ? $options['knowledge'] : [];

    echo '<p>In this section you can add all the Knowledge to your model so the Chatbot already knows the answer to specified questions. Automatic generated knowledge will be shown here.</p>';
    ?>
<div id="knowledge-repeater">
    <?php foreach ($knowledge as $index => $qa): ?>
    <div class="knowledge-pair" data-index="<?php echo esc_html($index); ?>">
        <div class="knowledge-summary">
            <span
                class="knowledge-question-title"><?php echo esc_html($qa['question']); ?></span>
            <div class="knowledge-actions">
                <button type="button"
                    class="button button-secondary button-remove remove-knowledge-pair">Remove</button>
                <button type="button" class="button button-secondary edit-knowledge-pair">Edit</button>
            </div>
        </div>
        <div class="knowledge-edit-form" style="display: none;">
            <input type="text"
                name="midrocket_chatbot_gpt_options[knowledge][<?php echo esc_html($index); ?>][question]"
                value="<?php echo esc_attr($qa['question']); ?>"
                placeholder="What is the price of a t-shirt?" />
            <textarea
                name="midrocket_chatbot_gpt_options[knowledge][<?php echo esc_html($index); ?>][answer]"
                placeholder="Prices range from $9 to $18. White t-shirts cost $9, green ones $12, and blue ones $18."
                rows="4"><?php echo esc_textarea($qa['answer']); ?></textarea>
        </div>
    </div>
    <?php endforeach; ?>
    <button type="button" id="add-knowledge-pair" class="button button-secondary">Add New Question</button>
</div>
<?php

}

// Style / Labels
function midrocket_chatbot_gpt_labels_section_callback() {
    echo '<p>Customize the labels used by the chatbot.</p>';
}
function midrocket_chatbot_gpt_bot_title_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="text" name="midrocket_chatbot_gpt_options[bot_title]" value="<?php echo esc_attr($options['bot_title'] ?? ''); ?>" placeholder="GreenTrends' Bot">
    <?php
}
function midrocket_chatbot_gpt_intro_message_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type='text' class='long-input' name='midrocket_chatbot_gpt_options[intro_message]'
        value='<?php echo esc_html($options['intro_message']) ?? ''; ?>'
        placeholder="Hi, I'm GreenTrend Chatbot! Do you have any questions?">
    <?php
}

function midrocket_chatbot_gpt_send_button_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="text" name="midrocket_chatbot_gpt_options[send_button]" value="<?php echo esc_attr($options['send_button'] ?? ''); ?>" placeholder="Send">
    <?php
}
function midrocket_chatbot_gpt_message_placeholder_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type='text' class='long-input' name='midrocket_chatbot_gpt_options[message_placeholder]'
        value='<?php echo esc_html($options['message_placeholder']) ?? ''; ?>'
        placeholder="Write your message here...">
    <?php
}


// Style / Visibility
function midrocket_chatbot_gpt_visibility_section_callback() {
    echo '<p>Adjust visibility settings for the chatbot. <strong>Do not apply in shortcode version [chatbot].</strong></p>';
}

function midrocket_chatbot_gpt_autoload_footer_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[autoload_footer]" value="0">
    <input type="checkbox" name="midrocket_chatbot_gpt_options[autoload_footer]" <?php checked(isset($options['autoload_footer']) ? $options['autoload_footer'] : 0); ?> value="1">
    <?php
}

function midrocket_chatbot_gpt_opened_by_default_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[opened_by_default]" value="0">
    <input type="checkbox" name="midrocket_chatbot_gpt_options[opened_by_default]" <?php checked(isset($options['opened_by_default']) ? $options['opened_by_default'] : 0); ?> value="1">
    <?php
}
function midrocket_chatbot_gpt_position_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <select name="midrocket_chatbot_gpt_options[position]">
        <option value="bottom_right" <?php selected(isset($options['position']) ? $options['position'] : '', 'bottom_right'); ?>>Bottom right</option>
        <option value="bottom_left" <?php selected(isset($options['position']) ? $options['position'] : '', 'bottom_left'); ?>>Bottom left</option>
    </select>
    <?php
}

// Style / Mode
function midrocket_chatbot_gpt_mode_section_callback() {
    echo '<p>Adjust style settings for the chatbot mode.</p>';
}

function midrocket_chatbot_gpt_default_mode_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <select name="midrocket_chatbot_gpt_options[default_mode]">
        <option value="light" <?php selected(isset($options['default_mode']) ? $options['default_mode'] : '', 'light'); ?>>Light</option>
        <option value="dark" <?php selected(isset($options['default_mode']) ? $options['default_mode'] : '', 'dark'); ?>>Dark</option>
    </select>
    <?php
}

function midrocket_chatbot_gpt_dark_mode_toggle_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[dark_mode_toggle]" value="0">
    <input type="checkbox" name="midrocket_chatbot_gpt_options[dark_mode_toggle]" <?php checked(isset($options['dark_mode_toggle']) ? $options['dark_mode_toggle'] : 0); ?> value="1">
    <?php
}

// Style / Customization
function midrocket_chatbot_gpt_customization_section_callback() {
    echo '<p>Customize the appearance of the chatbot. This customizations do not apply in <strong>Dark Mode.</strong></p>';
}

function midrocket_chatbot_gpt_icon_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    $icon_url = !empty($options['icon']) ? esc_url($options['icon']) : '';
    ?>
    <div class="midrocket-chatbot-icon-preview">
        <?php if (!empty($icon_url)): ?>
            <div class="box-preview">
                <img src="<?php echo esc_html($icon_url); ?>" alt="Icon Preview" style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>
    </div>
    <input type="hidden" id="midrocket_chatbot_gpt_icon" name="midrocket_chatbot_gpt_options[icon]" value="<?php echo esc_attr($icon_url); ?>">
    <button type="button" class="button midrocket-chatbot-upload-icon"><?php esc_html_e('Upload/Choose Icon', 'midrocket-chatgpt'); ?></button>
    <button type="button" class="button midrocket-chatbot-remove-icon button-remove" style="<?php echo empty($icon_url) ? 'display:none;' : ''; ?>"><?php esc_html_e('Remove Icon', 'midrocket-chatgpt'); ?></button>
    <script>
    jQuery(document).ready(function($) {
        $('.midrocket-chatbot-upload-icon').click(function(e) {
            e.preventDefault();
            var customUploader = wp.media({
                title: 'Select Icon',
                button: {
                    text: 'Use this icon'
                },
                multiple: false
            }).on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                // if (attachment.width !== attachment.height) {
                //     alert('Please select a square icon.');
                //     return;
                // }
                $('#midrocket_chatbot_gpt_icon').val(attachment.url);
                $('.midrocket-chatbot-icon-preview').html('<div class="box-preview"><img src="' + attachment.url + '" alt="Icon Preview" style="max-width: 100px; max-height: 100px;"></div>');
                $('.midrocket-chatbot-remove-icon').show();
            }).open();
        });

        $('.midrocket-chatbot-remove-icon').click(function(e) {
            e.preventDefault();
            $('#midrocket_chatbot_gpt_icon').val('');
            $('.midrocket-chatbot-icon-preview').html('');
            $(this).hide();
        });
    });
    </script>
    <?php
}

function midrocket_chatbot_gpt_button_color_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[button_color]" value="0">
    <input type='text' class='color-picker' name='midrocket_chatbot_gpt_options[button_color]' value='<?php echo esc_attr($options['button_color'] ?? ''); ?>' >
    <?php
}
function midrocket_chatbot_gpt_button_background_color_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[button_background_color]" value="0">
    <input type='text' class='color-picker' name='midrocket_chatbot_gpt_options[button_background_color]' value='<?php echo esc_attr($options['button_background_color'] ?? ''); ?>' >
    <?php
}
function midrocket_chatbot_gpt_header_color_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[header_color]" value="0">
    <input type='text' class='color-picker' name='midrocket_chatbot_gpt_options[header_color]' value='<?php echo esc_attr($options['header_color'] ?? ''); ?>' >
    <?php
}
function midrocket_chatbot_gpt_header_background_color_render() {
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type="hidden" name="midrocket_chatbot_gpt_options[header_background_color]" value="0">
    <input type='text' class='color-picker' name='midrocket_chatbot_gpt_options[header_background_color]' value='<?php echo esc_attr($options['header_background_color'] ?? ''); ?>' >
    <?php
}

// Style / Custom code
function midrocket_chatbot_gpt_custom_code_section_callback() {
    echo '<p>Customize the appearance of the chatbot using css code.</p>';
}
function midrocket_chatbot_gpt_custom_css_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <textarea name='midrocket_chatbot_gpt_options[custom_css]' rows='10'
            cols='75'><?php echo esc_html($options['custom_css']) ?? ""; ?></textarea>
    <?php
}


// API Settings
function midrocket_chatbot_gpt_api_key_render() {
    $options        = get_option('midrocket_chatbot_gpt_options');
    ?>
    <div class="cgpt-flex">
        <input type='text' id='midrocket_chatbot_gpt_api_key' name='midrocket_chatbot_gpt_options[api_key]' value='<?php echo esc_attr($options['api_key'] ?? ''); ?>'>
        <button type="button" id="midrocket_chatbot_gpt_connect_btn" class="button button-secondary">
            <?php echo esc_html_e('Test connection', 'midrocket-chatgpt'); ?>
            <span class="spinner is-active"></span>
        </button>
        <span id="midrocket_chatbot_gpt_api_key_status"></span>
    </div>
    
    <?php
}


function midrocket_chatbot_gpt_model_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <select name='midrocket_chatbot_gpt_options[gpt_model]'>
        <option value='gpt-3.5-turbo' <?php selected(isset($options['gpt_model']) ? $options['gpt_model'] : '', 'gpt-3.5-turbo'); ?>>GPT-3.5
            Turbo</option>
        <option value='gpt-4' <?php selected(isset($options['gpt_model']) ? $options['gpt_model'] : '', 'gpt-4'); ?>>GPT-4
        </option>
    </select>
    <?php
}

function midrocket_chatbot_gpt_company_name_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <input type='text' class='long-input' name='midrocket_chatbot_gpt_options[company_name]'
        value='<?php echo esc_html($options['company_name']) ?? ""; ?>'>
    <?php
}


function midrocket_chatbot_gpt_rules_prompt_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <div class="input-example">
        <textarea name='midrocket_chatbot_gpt_options[rules_prompt]' rows='10'
            cols='75'><?php echo esc_html($options['rules_prompt']) ?? ""; ?></textarea>
        <?php example_collapsible(RULES_PROMPT); ?>
    </div>
    <?php
}

function midrocket_chatbot_gpt_specific_content_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <div class="input-example">
        <textarea name='midrocket_chatbot_gpt_options[specific_content]' rows='10' cols='75'
            placeholder="Paste here all the content the chatbot should know to give answers"><?php echo esc_html($options['specific_content']) ?? ""; ?></textarea>
        <?php example_collapsible(SPECIFIC_CONTENT_EXAMPLE); ?>
    </div>
    <?php
}

function midrocket_chatbot_gpt_tematic_prompt_render()
{
    $options = get_option('midrocket_chatbot_gpt_options');
    ?>
    <div class="input-example">
        <textarea name='midrocket_chatbot_gpt_options[tematic_prompt]' rows='10'
            cols='75'><?php echo !empty($options['tematic_prompt']) ? esc_html($options['tematic_prompt']) : '(Ejemplo actual) '.esc_html(TEMATIC_PROMPT); ?></textarea>
        <?php example_collapsible(TEMATIC_PROMPT); ?>
    </div>
    <?php
}

function midrocket_chatbot_gpt_options_validate($input)
{
    $current_options = get_option('midrocket_chatbot_gpt_options');

    // API
    if(isset($input['api_key'])) {
        $current_options['api_key'] = sanitize_text_field($input['api_key']);
    }
    if(isset($input['gpt_model']) && in_array($input['gpt_model'], ['gpt-3.5-turbo', 'gpt-4'])) {
        $current_options['gpt_model'] = $input['gpt_model'];
    }

    // Style
    if(isset($input['bot_title'])) {
        $current_options['bot_title'] = sanitize_text_field($input['bot_title']);
    }
    if(isset($input['intro_message'])) {
        $current_options['intro_message'] = sanitize_textarea_field($input['intro_message']);
    }
    if(isset($input['send_button'])) {
        $current_options['send_button'] = sanitize_text_field($input['send_button']);
    }
    if(isset($input['message_placeholder'])) {
        $current_options['message_placeholder'] = sanitize_textarea_field($input['message_placeholder']);
    }
    if(isset($input['autoload_footer'])) {
        $current_options['autoload_footer'] = isset($input['autoload_footer']) ? (bool) $input['autoload_footer'] : false;
    }
    if(isset($input['opened_by_default'])) {
        $current_options['opened_by_default'] = isset($input['opened_by_default']) ? (bool) $input['opened_by_default'] : false;
    }
    if(isset($input['default_mode'])) {
        $current_options['default_mode'] = in_array($input['default_mode'], ['light', 'dark']) ? $input['default_mode'] : 'light';
    }
    if(isset($input['dark_mode_toggle'])) {
        $current_options['dark_mode_toggle'] = isset($input['dark_mode_toggle']) ? (bool) $input['dark_mode_toggle'] : false;
    }
    if(isset($input['position'])) {
        $current_options['position'] = in_array($input['position'], ['bottom_right', 'bottom_left']) ? $input['position'] : 'bottom_right';
    }
    if(isset($input['icon'])) {
        $current_options['icon'] = sanitize_text_field($input['icon'] ?? '');
    }
    if (isset($input['button_color'])) { // Check HEX:  && preg_match('/^#[a-fA-F0-9]{6}$/', $input['button_color'])
        $current_options['button_color'] = $input['button_color']; 
    }
    if (isset($input['button_background_color'])) {
        $current_options['button_background_color'] = $input['button_background_color'];
    }
    if (isset($input['header_color'])) {
    $current_options['header_color'] = $input['header_color'];
}
    if (isset($input['header_background_color'])) {
        $current_options['header_background_color'] = $input['header_background_color'];
    }
    if(isset($input['custom_css'])) {
        $current_options['custom_css'] = sanitize_textarea_field($input['custom_css']);
    }

    // Main
    if(isset($input['rules_prompt'])) {
        $current_options['rules_prompt'] = sanitize_textarea_field($input['rules_prompt']);
    }
    // Knowledge
    if (isset($input['knowledge']) && is_array($input['knowledge'])) {
        $current_options['knowledge'] = [];
        foreach ($input['knowledge'] as $index => $qa) {
            if (!empty($qa['question']) && !empty($qa['answer'])) {
                $current_options['knowledge'][] = [
                    'question' => sanitize_text_field($qa['question']),
                    'answer' => sanitize_textarea_field($qa['answer']),
                ];
            }
        }
    }

    return $current_options;
}


function example_collapsible($content, $example_title = null)
{
    ?>
<div class="example">
    <div class="collapsible-title collapsible">
        <strong><?php echo esc_html($example_title) ?? 'Show example'; ?></strong><i
            class="fi fi-rr-plus"></i><i class="fi fi-rr-minus"></i></div>
    <div class="collapsible-content">
        <p><?php echo esc_html($content); ?></p>
    </div>
</div>
<?php
}
function midrocket_chatbot_gpt_enqueue_color_picker($hook_suffix) {
    // Asegúrate de que este script se carga solo en la página de configuración de tu plugin
    if('toplevel_page_midrocket_chatbot_gpt_settings' !== $hook_suffix)
        return;

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_media(); // Esto permitirá que el botón de subida funcione
    add_action('admin_footer', 'midrocket_chatbot_gpt_color_picker_script'); // Agrega el script al final de la página
}

add_action('admin_enqueue_scripts', 'midrocket_chatbot_gpt_enqueue_color_picker');

function midrocket_chatbot_gpt_color_picker_script() {
    ?>
    <script>
        jQuery(document).ready(function($){
            $('.color-picker').wpColorPicker();
        });
    </script>
    <?php
}
