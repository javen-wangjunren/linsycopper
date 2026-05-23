# Blog Structure Documentation (Blog 架构文档)

本文件详细整理了当前项目中 **Blog Archive (文章列表页)** 与 **Single Blog (文章详情页)** 的前后端逻辑架构，旨在为后续维护及跨项目迁移提供参考指南。

---

## 1. Blog Archive (文章列表页)

文章列表页采用 WordPress 标准的 `home.php` 作为入口，结合 GeneratePress 的布局规范，将功能拆分为三个核心模块。

### 核心文件
- 入口文件: `home.php`
- 头部模块: `template-parts/blog-archive/header.php`
- 列表网格: `template-parts/blog-archive/grid.php`
- 分页模块: `template-parts/blog-archive/pagination.php`

### 业务逻辑
- **数据来源**: 标题与描述通过 ACF 在“设置 → 阅读”中指定的“文章页” ID 上进行配置。
- **分类筛选**: 使用工业感的 Tabs 样式进行分类过滤。通过 `get_query_var('category_name')` 获取当前分类，并动态高亮对应的 Tab。
- **内容展示**: 
    - 采用响应式网格布局 (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`)。
    - 卡片包含：特色图像、分类标签、日期、阅读时间（占位）、标题、摘要及作者信息。

---

## 2. Single Blog (文章详情页)

文章详情页由 `single.php` 控制，核心特点是引入了**动态目录 (TOC)** 逻辑和**工业级排版系统**。

### 核心文件
- 入口文件: `single.php`
- 详情头部: `template-parts/single-blog/header.php`
- 正文区域: `template-parts/single-blog/content.php`
- 侧边栏: `template-parts/single-blog/sidebar.php`
- 逻辑函数: `inc/blog-template-functions.php`

### 核心逻辑：动态目录 (TOC)
系统通过以下三步实现自动化目录：
1. **内容获取**: `_3dp_get_builder_content` 获取古腾堡编辑器的原始 HTML。
2. **数据解析**: `_3dp_get_post_toc` 扫描内容中的所有 `<h2>` 标签，生成包含 ID 和标题的数组，并处理重复标题的冲突。
3. **锚点注入**: `_3dp_add_ids_to_h2` 通过 `the_content` 滤镜，动态在前端渲染的 `<h2>` 标签中注入 `id` 属性，确保侧边栏点击可跳转。

---

## 3. 后端逻辑支持

所有的 Blog 专用辅助函数均存放于 `inc/blog-template-functions.php`。

- **`_3dp_get_builder_content($post_id)`**: 统一的内容提取入口。
- **`_3dp_get_post_toc($content)`**: 核心解析引擎，仅针对 H2 进行提取以保持目录简洁。
- **`_3dp_add_ids_to_h2($content)`**: 正则注入引擎，挂载在优先级 20 的 `the_content` 上。

---

## 4. 跨项目实现指南

若要在其他 WordPress 项目中复用此套架构，请遵循以下步骤：

### 第一步：环境准备
- **Tailwind CSS**: 确保安装了 `@tailwindcss/typography` 插件，用于处理正文排版（`prose` 类）。
- **ACF Pro (可选)**: 用于配置文章列表页的全局标题与描述。

### 第二步：逻辑移植
1. 将 `inc/blog-template-functions.php` 复制到新项目。
2. 在新项目的 `functions.php` 中引入该文件。
3. 确保 `the_content` 滤镜已正确注册，以便生成锚点。

### 第三步：模板构建
1. **Archive**: 
    - 创建 `home.php` 并使用 `get_template_part` 加载 Header, Grid, Pagination。
    - 参考本项目 `template-parts/blog-archive/grid.php` 中的 Loop 结构。
2. **Single**:
    - 创建 `single.php`，划分为 `main` (8列) 和 `aside` (4列) 布局。
    - 在 `aside` 中调用 `_3dp_get_post_toc` 获取数据并循环输出链接。
    - 在 `main` 中直接使用 `the_content()`，滤镜会自动处理 ID 注入。

### 第四步：样式适配
- 确保侧边栏的 `sticky` 属性生效，以便目录随页面滚动。
- 调整 `prose` 类的配置以符合新项目的视觉规范（颜色、字体、行高等）。
