<?php
/**
 * Admin Filters & Columns (后台列表页增强)
 * ==========================================================================
 * 文件作用:
 * 定制 WordPress 后台文章列表页 (Admin List Table) 的功能。
 * 包括：增加自定义筛选器、添加自定义列、批量操作等。
 *
 * 核心逻辑:
 * 1. Material 列表: 增加 "批量发布" 功能。
 * 2. Material 列表: 增加 Process 和 Type 的分类筛选器。
 * 3. Surface Finish 列表: 增加 "Related Capabilities" 列。
 * 4. Surface Finish 列表: 增加 "按 Capability 筛选" 的功能。
 * 5. 通用: 移除不必要的 "日期筛选" (Disable Months Dropdown)。
 *
 * 架构角色:
 * [Admin Infrastructure]
 * 这个文件只影响 WP Admin 后台的体验，不影响前端页面渲染。
 * 它属于 "基础设施" 代码，旨在提高内容管理员 (Content Editor) 的工作效率。
 *
 * 🚨 避坑指南:
 * 1. `pre_get_posts` 钩子极其强大但也危险，必须严格限定 `is_admin()`, `is_main_query()` 以及 `post_type`，
 *    否则可能导致前端页面崩溃或数据混乱。
 * 2. ACF Relationship 字段存储的是序列化数组，因此 Meta Query 只能用 `LIKE` 进行模糊匹配。
 * ==========================================================================
 * 
 * @package GeneratePress_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

