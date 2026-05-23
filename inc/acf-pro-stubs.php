<?php
/**
 * ACF Pro Stubs
 * 用于解决Intelephense等IDE无法识别ACF函数的问题
 * 仅包含函数声明，不包含实现，主要是空函数
 * 这个文件只是定义了acf相关的函数，
 * 因为我的打开的文件夹并没有包含acf，
 * 需要用了acf的一些函数就报错，
 * 所以就创建了这么一个文件，并没有实际的函数功能，只是为了消除错误用的
 */

function add_action( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}
function add_filter( $hook, $callback, $priority = 10, $accepted_args = 1 ) {}

function __( $text, $domain = 'default' ) {
    return $text;
}

function register_post_type( $post_type, $args = array() ) {}
function register_taxonomy( $taxonomy, $object_type, $args = array() ) {}
function get_terms( $args = array(), $deprecated = '' ) { return array(); }
function is_wp_error( $thing ) { return false; }
function term_exists( $term, $taxonomy = '', $parent = 0 ) { return false; }
function wp_insert_term( $term, $taxonomy, $args = array() ) { return array(); }

function get_header() {}
function get_footer() {}
function get_template_part( $slug, $name = null, $args = array() ) {}
function esc_html( $text = '' ) { return $text; }
function esc_attr( $text = '' ) { return $text; }
function esc_url( $url = '' ) { return $url; }
function wp_kses_post( $data ) { return $data; }
function wp_kses( $string, $allowed_html = array(), $allowed_protocols = array() ) { return $string; }
function wp_create_nonce( $action = -1 ) { return ''; }
function set_query_var( $var, $value = '' ) {}
function get_query_var( $var, $default = '' ) { return $default; }
function wp_reset_postdata() {}
function get_permalink( $post_id = 0 ) { return ''; }
function get_the_ID() { return 0; }
function get_the_title( $post_id = 0 ) { return ''; }
function get_post_thumbnail_id( $post_id = 0 ) { return 0; }
function has_post_thumbnail( $post = null ) { return false; }
function get_the_post_thumbnail( $post = null, $size = 'post-thumbnail', $attr = array() ) { return ''; }
function wp_get_attachment_image_url( $id, $size = 'thumbnail' ) { return ''; }
function wp_get_attachment_image( $id, $size = 'thumbnail', $icon = false, $attr = array() ) { return ''; }
function wp_get_post_terms( $post_id, $taxonomy, $args = array() ) { return array(); }
function wp_set_object_terms( $object_id, $terms, $taxonomy, $append = false ) { return array(); }
function get_post_type( $post = null ) { return ''; }
function get_term_by( $field, $value, $taxonomy = '', $output = 'OBJECT', $filter = 'raw' ) { return false; }
function the_title() { echo ''; }

class WP_Query {
    public $found_posts = 0;
    public function __construct( $args = array() ) {}
    public function have_posts() { return false; }
    public function the_post() {}
}

/**
 * ACF 字段组相关函数
 */

/**
 * 添加本地字段组
 * @param array $field_group
 * @return int|false
 */
function acf_add_local_field_group( $field_group ) {};

/**
 * 获取本地字段组
 * @param string $key
 * @return array|false
 */
function acf_get_local_field_group( $key ) {};

/**
 * 删除本地字段组
 * @param string $key
 * @return bool
 */
function acf_remove_local_field_group( $key ) {};

/**
 * ACF 区块相关函数
 */

/**
 * 注册区块
 * @param array $settings
 * @return array|false
 */
function acf_register_block_type( $settings ) {};

/**
 * 获取区块类型
 * @param string $name
 * @return array|false
 */
function acf_get_block_type( $name ) {};

/**
 * 获取所有区块类型
 * @return array
 */
function acf_get_block_types() {};

/**
 * 删除区块类型
 * @param string $name
 * @return bool
 */
function acf_unregister_block_type( $name ) {};

/**
 * ACF 字段值相关函数
 */

/**
 * 获取字段值
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @param bool $format_value
 * @return mixed
 */
function get_field( $selector, $post_id = false, $format_value = true ) {};

/**
 * 获取多个字段值
 * @param array $selectors
 * @param int|string|WP_Post|null $post_id
 * @param bool $format_value
 * @return array
 */
function get_fields( $post_id = false, $format_value = true ) {};

/**
 * 设置字段值
 * @param string $selector
 * @param mixed $value
 * @param int|string|WP_Post|null $post_id
 * @param bool $format_value
 * @return bool
 */
function update_field( $selector, $value, $post_id = false ) {};

/**
 * 更新多个字段值
 * @param array $field_values
 * @param int|string|WP_Post|null $post_id
 * @return bool
 */
function update_fields( $field_values, $post_id = false ) {};

/**
 * 删除字段值
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return bool
 */
function delete_field( $selector, $post_id = false ) {};

/**
 * 检查字段是否存在
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return bool
 */
function have_rows( $selector, $post_id = false ) {};

/**
 * 循环字段行
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return bool
 */
function the_row( $selector = false, $post_id = false ) {};

/**
 * 重置字段行循环
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return bool
 */
function reset_rows( $selector = false, $post_id = false ) {};

/**
 * 获取当前行
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return array|false
 */
function get_row( $selector = false, $post_id = false ) {};

/**
 * 获取当前行索引
 * @return int
 */
function get_row_index() {};

/**
 * 获取子字段值
 * @param string $selector
 * @param bool $format_value
 * @return mixed
 */
function get_sub_field( $selector, $format_value = true ) {};

/**
 * 设置子字段值
 * @param string $selector
 * @param mixed $value
 * @param bool $format_value
 * @return bool
 */
function update_sub_field( $selector, $value ) {};

/**
 * 删除子字段值
 * @param string $selector
 * @return bool
 */
function delete_sub_field( $selector ) {};

/**
 * ACF 表单相关函数
 */

/**
 * 渲染ACF表单
 * @param array $args
 * @return string
 */
function acf_form( $args = array() ) {};

/**
 * 获取ACF表单
 * @param array $args
 * @return string
 */
function acf_get_form( $args = array() ) {};

/**
 * 保存ACF表单
 * @param array $post_id
 * @return bool
 */
function acf_form_head() {};

/**
 * ACF 其他常用函数
 */

/**
 * 格式化值
 * @param mixed $value
 * @param int|string|WP_Post|null $post_id
 * @param array $field
 * @return mixed
 */
function acf_format_value( $value, $post_id, $field ) {};

/**
 * 格式化值用于API
 * @param mixed $value
 * @param int|string|WP_Post|null $post_id
 * @param array $field
 * @return mixed
 */
function acf_format_value_for_api( $value, $post_id, $field ) {};

/**
 * 获取字段对象
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return array|false
 */
function get_field_object( $selector, $post_id = false ) {};

/**
 * 获取字段组
 * @param string $selector
 * @param int|string|WP_Post|null $post_id
 * @return array|false
 */
function get_field_group( $selector, $post_id = false ) {};

/**
 * 获取所有字段
 * @param string $field_group_key
 * @return array
 */
function acf_get_fields( $field_group_key ) {};

/**
 * 获取字段
 * @param string $field_key
 * @return array|false
 */
function acf_get_field( $field_key ) {};

/**
 * 添加本地字段
 * @param array $field
 * @return int|false
 */
function acf_add_local_field( $field ) {};

/**
 * 删除本地字段
 * @param string $key
 * @return bool
 */
function acf_remove_local_field( $key ) {};

/**
 * ACF 初始化相关函数
 */

/**
 * 检查ACF是否初始化
 * @return bool
 */
function acf_is_loaded() {};

/**
 * 获取ACF版本
 * @return string
 */
function acf_get_setting( $name ) {};

/**
 * 设置ACF设置
 * @param string $name
 * @param mixed $value
 * @return mixed
 */
function acf_update_setting( $name, $value ) {};

/**
 * ACF 翻译相关函数
 */

/**
 * 翻译文本
 * @param string $text
 * @param string $context
 * @param string $domain
 * @return string
 */
function acf_i18n_text( $text, $context = '', $domain = 'acf' ) {};

/**
 * 翻译字段标签
 * @param string $label
 * @param array $field
 * @return string
 */
function acf_translate_field( $field ) {};

/**
 * ACF 图片相关函数
 */

/**
 * 获取图片URL
 * @param int $attachment_id
 * @param string $size
 * @param bool $icon
 * @return string
 */
function acf_get_attachment_url( $attachment_id, $size = 'thumbnail', $icon = false ) {};

/**
 * 获取图片信息
 * @param int $attachment_id
 * @param string $size
 * @param bool $icon
 * @return array|false
 */
function acf_get_attachment_image_src( $attachment_id, $size = 'thumbnail', $icon = false ) {};

/**
 * 渲染图片
 * @param int $attachment_id
 * @param string $size
 * @param bool $icon
 * @param array $attr
 * @return string
 */
function acf_get_attachment_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = array() ) {};

/**
 * ACF 区块渲染相关函数
 */

/**
 * 渲染区块
 * @param array $block
 * @param string $content
 * @param bool $is_preview
 * @param int $post_id
 */
function acf_render_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {};

/**
 * 获取区块渲染模板
 * @param array $block
 * @return string|false
 */
function acf_get_block_render_template( $block ) {};

/**
 * ACF 选项页相关函数
 */

/**
 * 添加选项页
 * @param array $args
 * @return string|false
 */
function acf_add_options_page( $args = array() ) {};

/**
 * 添加子选项页
 * @param array $args
 * @return string|false
 */
function acf_add_options_sub_page( $args = array() ) {};

/**
 * 获取选项页
 * @param string $slug
 * @return array|false
 */
function acf_get_options_page( $slug ) {};

/**
 * 获取所有选项页
 * @return array
 */
function acf_get_options_pages() {};

/**
 * 删除选项页
 * @param string $slug
 * @return bool
 */
function acf_remove_options_page( $slug ) {};
