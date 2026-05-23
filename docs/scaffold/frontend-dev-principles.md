# 前端开发核心原则与脚手架规范 (Frontend Development Principles & Scaffold Standards)

本文档定义了在 WordPress 前端开发（特别是基于 GeneratePress Child + Tailwind CSS + ACF 架构）中必须遵守的 **“视觉优先” (Visual First)** 开发原则和代码规范。

## 0. 核心设计哲学 (Core Design Philosophy)

### 0.1 关注点分离 (Separation of Concerns - SoC)
**理念**：将复杂的系统拆分为职责单一的模块。
*   **调度者 (Dispatcher)**：`header.php`, `footer.php`。只负责宏观布局（“这里放 Logo，那里放菜单”），不负责具体实现。
*   **执行者 (Worker)**：`template-parts/**/*.php`。负责具体的 HTML 渲染和逻辑。
*   **收益**：修改一个模块（如移动端菜单）绝不会意外破坏另一个模块（如桌面端菜单）。

### 0.2 组件化思维 (Componentization)
**理念**：将 UI 拆解为可复用的原子组件。
*   **实践**：不要在 `page-home.php` 里写 500 行 HTML。将其拆解为 `hero.php`, `features.php`, `cta.php`，然后通过 `_starter_render_block` 进行组装。

### 0.3 组件纯度优先 (Component Purity First)
**原则**：组件（Atom/Component）必须保持“无布局侵入”，外层模块负责排版。遇到组件结构不纯时，优先修正组件，而不是写额外代码去适配。
*   **组件必须**：只包含自身的表单控件/卡片内容/交互逻辑；不包含页面级 `<section>`、主间距（如 `pt-[100px]`）、分栏栅格、模块标题区等。
*   **外层模块必须**：负责 Section 容器、标题/描述、背景、分栏、模块级间距与对齐，并负责数据绑定（`get_flat_field`）。
*   **红线**：不要为“错误结构的组件”添加全局变量开关/特殊分支，让所有调用方背负复杂性；应先回归组件纯度，再继续开发。

### 0.4 样式主权划分 (Style Sovereignty)
**目标**：让设计稿拥有“视觉主权”，主题只提供“地基”，避免 GeneratePress 的 `body/button/h1-h6/a/ul/ol` 默认样式反复干扰还原。

**基本结论**：如果主题与模块都在“定义视觉”，就一定会打架；必须把职责拆开，并用“作用域隔离”让冲突不可发生。

*   **主题（GeneratePress）负责：地基**
    *   页面结构骨架：header/footer/main 的宏观结构与容器宽度
    *   基础性能与兼容：基础 reset（少量）、脚本加载、SEO title 等
    *   特例：Blog（文章内容区）允许使用主题/排版体系（可读性优先）
*   **模块（template-parts / blocks）负责：视觉**
    *   字体、字号、行高、颜色、间距、标题体系、段落体系
    *   按钮/链接/hover/active/focus-visible 的完整交互
    *   列表（ul/ol）缩进、marker、间距（不要继承主题默认）

**落地策略：Scope First（推荐）**
*   每个模块最外层必须加一个稳定 scope（例如 `lc-scope` 或更具体如 `lc-hub` / `lc-taxonomy`）。
*   在 `src/input.css` 用 `@layer components` 写“只在 scope 内生效”的排版与 reset：
    *   `.lc-scope a { ... }`（链接颜色/下划线/hover）
    *   `.lc-scope button, .lc-scope .lc-btn { ... }`（按钮不依赖主题 `.button`）
    *   `.lc-scope h1-h6, p { ... }`（标题/正文体系由模块自定义）
    *   `.lc-scope ul, ol { margin:0; padding:0; list-style: none; }` 或按设计稿自定义 marker/缩进

**落地策略：App Mode（全站级隔离，非 Blog）**
*   对非 Blog 页面启用 `body.lc-app`（只在 `.site-content` 里生效）：
    *   让主题的全局 link 颜色/hover 行为失效，链接默认 `color: inherit`
    *   模块必须显式声明链接与按钮颜色（例如 Tailwind 的 `text-white hover:text-*`）
*   Blog（文章）不加 `lc-app`，保留主题/排版接管，避免影响文章可读性与编辑体验。

---

## 1. 核心理念 (Core Philosophy)

### 1.1 视觉优先 (Visual First)
**原则**：一切开发始于视觉还原，终于数据绑定。
*   **流程**：Static HTML/Tailwind -> Component Extraction -> PHP Integration。
*   **红线**：禁止在没有完美还原设计稿的情况下直接写 PHP 逻辑。

### 1.2 零干扰集成 (Zero-Interference Integration)
**原则**：PHP 代码不应破坏 HTML 结构或引入额外的 DOM 层级。
*   **手段**：使用专门设计的辅助函数 (`get_flat_field`) 和渲染引擎 (`_starter_render_block`) 来保持模板的纯净。

### 1.3 非主题化交互控件 (No Theme UI Dependencies)
**原则**：模块内的交互控件（按钮/链接/分页/Tab）不得依赖主题类（例如 `.button`）的默认视觉。

*   **强约束**：模块按钮一律使用项目自定义组件类（例如 `lc-btn` / `lc-card-btn` / `lc-hub-cta-btn`），并在组件层锁定样式。
*   **必要手段**：遇到主题强覆盖时，可对按钮类使用 `display/align-items/justify-content/text-align` 或极端情况下 `all: unset` 重建。
*   **无障碍红线**：使用 `all: unset` 时必须补齐 `cursor/padding/background/border-radius/:focus-visible`，并保证键盘可聚焦。

---

## 2. 数据获取与绑定 (Data Binding)

### 2.1 极简字段获取 (`get_flat_field`)
**规范**：前端模板中**严禁**直接使用 `get_field()` 进行复杂的判空逻辑。必须统一使用 `get_flat_field`。

*   **函数签名**：`get_flat_field( $field_name, $block, $default )`
*   **优势**：
    1.  **自带兜底**：自动处理 `null`, `false`, `''`，直接返回默认值。
    2.  **上下文智能**：自动识别是在 Block 还是 Page Template 环境中运行。
    3.  **代码整洁**：消灭 90% 的 `if ( ! empty(...) )` 代码。

*   **❌ 错误写法 (Old Way)**:
    ```php
    $title = get_field('hero_title');
    if ( ! $title ) {
        $title = 'Default Title';
    }
    ```

*   **✅ 正确写法 (Scaffold Way)**:
    ```php
    $title = get_flat_field('hero_title', $block, 'Default Title');
    ```

### 2.2 附录：核心函数参考实现 (Reference Implementation)
为了避免“智能判断”成为黑盒，以下是 `get_flat_field` 和 `_starter_render_block` 的标准实现逻辑。在排查数据获取问题时，请优先检查此逻辑。

```php
/**
 * 极简字段获取函数 (get_flat_field)
 * 逻辑：优先从 $block 数组取值 -> 其次尝试取 _context_post_id -> 最后兜底取当前页 ID
 */
function get_flat_field( $field_name, $block = array(), $default = null ) { 
    // 1. 优先: 直接从 Block 数组拿 (性能最高，不查数据库) 
    if ( isset( $block[ $field_name ] ) && $block[ $field_name ] !== '' ) { 
        return $block[ $field_name ]; 
    } 

    // 2. 其次: 检查是否有显式传递的上下文 ID
    $post_id = isset( $block['_context_post_id'] ) ? $block['_context_post_id'] : false; 
    
    // 3. 兜底: 如果没有上下文 ID，尝试获取当前页面 ID
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // 查库获取
    $value = get_field( $field_name, $post_id ); 

    // 4. 返回: 真实值或默认值
    return ( $value !== null && $value !== false && $value !== '' ) ? $value : $default; 
}

/**
 * 模块独立渲染函数 (_starter_render_block)
 * 逻辑：加载模板文件，并利用 PHP 函数作用域隔离特性，确保变量不污染全局。
 */
function _starter_render_block( $template_path, $block_data = array() ) {
    // 将数据赋值给 $block 变量，这是模版中约定的标准变量名
    $block = $block_data;
    
    // 自动补全文件后缀
    if ( substr( $template_path, -4 ) !== '.php' ) {
        $template_path .= '.php';
    }

    // 定位并加载模版
    // 使用 locate_template 允许子主题覆盖
    $located = locate_template( $template_path );

    if ( $located ) {
        include $located;
    } else {
        // 开发环境下提示缺失模版
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            echo "<!-- Template not found: {$template_path} -->";
        }
    }
}
```

### 2.3 模块化渲染 (`_starter_render_block`)
**规范**：页面模板 (Page Template) 禁止直接编写 HTML 结构，必须通过“组装”模块来实现。

*   **函数签名**：`_starter_render_block( $template_path, $data = array() )`
*   **作用域机制**：
    1.  **隔离**：`$data` 数组会被赋值给模板内的局部变量 `$block`。模板内无法访问父级作用域的变量（除非是 `global`），确保了真正的隔离。
    2.  **传递**：如果未传递 `$data`，模板内的 `$block` 将为空数组。此时 `get_flat_field` 会自动回退到使用 `get_the_ID()` 获取当前页面的字段。

*   **示例 A：默认上下文 (Default Context)**
    *   场景：渲染当前页面（如 Home Page）的 Hero 模块，数据直接从当前页面获取。
    ```php
    // page-home.php
    _starter_render_block( 'blocks/global/hero/render' ); 
    // render.php 内部: $block 为空，get_flat_field 自动取当前页 ID
    ```

*   **示例 B：显式数据传递 (Explicit Data Passing)**
    *   场景：在 Home Page 渲染“关于我们”页面的 Hero，或者在循环中渲染 Card。
    ```php
    // page-home.php
    $about_page_id = 123;
    _starter_render_block( 'blocks/global/hero/render', array(
        '_context_post_id' => $about_page_id, // 告诉 get_flat_field 去取哪个页面的数据
        'custom_title'     => 'Override Title', // 传递自定义数据
    ));
    // render.php 内部: $block 包含上述数据
    ```

### 2.4 循环中的上下文陷阱 (Context in Loops)
**红线**：在 `WP_Query` 或 `foreach` 循环中调用 `_starter_render_block` 时，**必须**显式传递 `_context_post_id`。
*   **理由**：`get_flat_field` 默认使用的 `get_the_ID()` 依赖于全局 `$post`。在自定义循环中，如果未严格设置 `setup_postdata`，极易取到错误的（父级页面）ID。
*   **正确示例**：
    ```php
    // 在 Custom Loop 中
    while ( $query->have_posts() ) : $query->the_post();
        _starter_render_block( 'blocks/card', array(
            '_context_post_id' => get_the_ID() // 👈 必须显式传递！
        ));
    endwhile;
    ```

---

## 3. 模板结构规范 (Template Structure)

### 3.1 渲染模版标准结构 (Render Template Anatomy)
每个模块的 `render.php` 必须遵循以下三段式结构：

1.  **初始化 (Initialization)**: 获取数据。
2.  **预处理 (Preprocessing)**: 处理复杂的逻辑或数组（可选）。
3.  **视图渲染 (View Rendering)**: 纯净的 HTML + PHP 输出。

```php
<?php
// I. 初始化
// 确保 $block 存在 (兼容非 Block 环境)
$block = isset($block) ? $block : [];

// 获取数据 (使用 get_flat_field)
$title = get_flat_field('hero_title', $block, 'Welcome');
$img   = get_flat_field('hero_image', $block);

// II. 预处理
$bg_url = $img ? wp_get_attachment_image_url($img, 'full') : '...placeholder...';
?>

<!-- III. 视图渲染 -->
<section class="relative">
    <h1><?php echo esc_html($title); ?></h1>
    <img src="<?php echo esc_url($bg_url); ?>">
</section>
```

### 3.2 预处理的红线 (Preprocessing Boundaries)
**原则**：`render.php` 是视图层，不是控制器。
*   **✅ 允许的操作**：
    *   **格式转换**：Image ID -> URL, Timestamp -> Date String。
    *   **简单的判空**：设置默认图片或文本。
    *   **数组重组**：将 ACF Repeater 数据映射为更简单的 Key-Value 数组。
*   **❌ 禁止的操作**：
    *   **数据库查询**：严禁 `WP_Query` 或 `get_posts`（应在 Controller 或 Helper 中完成）。
    *   **复杂逻辑**：禁止嵌套超过 2 层的 `if/foreach` 逻辑。
    *   **业务计算**：如价格计算、库存检查等（应封装为 Helper 函数）。

### 3.3 变量命名约定
*   **$block**: 模块数据的标准容器变量名（由 `_starter_render_block` 自动注入）。
*   **无前缀变量**: 在 `render.php` 内部，变量名应简洁直接（如 `$title`, `$images`），不要带模块前缀（如 `$hero_title`），因为作用域已隔离。

---

## 4. 最佳实践 (Best Practices)

### 4.1 默认值策略
**原则**：所有文本类字段都必须提供合理的默认值。
*   **理由**：避免客户在未填写内容时看到空白页面，同时方便开发阶段预览效果。

### 4.2 图片处理
**原则**：图片字段获取的是 ID，必须转换为 URL 或 `srcset`。
*   **兜底**：必须提供 Unsplash 或本地占位图作为图片兜底。
*   **防御性编程**：虽然要求后端配置为 "Return ID"，但前端最好在使用 `wp_get_attachment_image_url` 前做一个简单的类型检查 (`is_numeric`)，防止因配置错误（返回了数组或 URL）导致 PHP 报错。

### 4.3 交互逻辑分层 (Interaction Layering)
**原则**：根据交互复杂度选择合适的技术栈，避免“一把梭”。
*   **Alpine.js (推荐)**：适用于**组件内**的轻量级状态管理。
    *   ✅ **适用场景**：Mobile Menu, Dropdown, Modal, Tabs, Accordion。
    *   ❌ **不适用场景**：复杂的 DOM 操作（如拖拽排序）、高性能动画（如 GSAP ScrollTrigger）、跨组件状态同步。
*   **Vanilla JS / 专用库**：对于复杂场景，应编写独立的 JS 模块或引入专用库（如 Swiper, GSAP）。
*   **禁止**：为了简单的 UI 交互引入 jQuery。

---

## 5. 失败复盘：Industry 模块踩坑总结 (Lessons Learned)

本节用于记录真实项目中发生过的“反复修改仍不生效”的典型原因，目的是建立可复用的排查顺序与工程性防线。

### 5.1 数据绑定类失败 (ACF / PHP / JSON)

**现象 A：后台明明填了内容，前端一直为空**
*   **根因 1：字段名不匹配**（例如后台是 `industry_slide_desc`，前端读成 `industry_description`）
    *   **经验**：先在后台 DOM（如 textarea 的 `id/name`）确认真实 field name，再回到 PHP 逐字段对齐。
*   **根因 2：`get_flat_field` 的上下文误用**
    *   典型错误：把 `post_id` 直接当第二参数传给 `get_flat_field($field, $block, $default)`，导致函数回退到当前页 ID，读取到错误内容。
    *   **经验**：跨 Post/Loop 读取必须显式传 `_context_post_id`，不要“猜”函数支持的参数形态。

**现象 B：页面渲染结构看着正常，但 Alpine 的 `x-text`/`:src` 不工作**
*   **根因 1：把 JSON 直接塞进 `x-data="..."` 导致属性被引号截断**
    *   例如 JSON 内含双引号，最终 HTML attribute 变成“半截 JS + 一堆破碎属性”，Alpine 初始化失败。
    *   **经验**：大 JSON 不要内联进 attribute。优先输出到 `window.__VAR__ = {...}`，`x-data` 只引用变量。
*   **根因 2：浏览器兼容导致表达式报错（可选链 `?.` 等）**
    *   Alpine 表达式一旦语法错误，整个组件会静默失效。
    *   **经验**：在模板中尽量使用最保守语法（`a && a.b ? a.b : ''`），避免依赖可选链。
*   **根因 3：内容完全依赖 `x-text`，一旦 Alpine 没跑就变“空壳 UI”**
    *   例如按钮只有 `x-text` 没有 fallback 文本时，会只剩一个“色块”。
    *   **经验**：关键 CTA 文案必须有默认值；重要信息至少提供首屏 PHP fallback（Alpine 只做增强）。

**现象 C：标题出现 `&#038;` 等奇怪字符**
*   **根因：HTML 实体被二次转义**
    *   WordPress/ACF -> JSON -> `x-text` 会把 `&#038;` 当普通字符串渲染。
    *   **经验**：入 JSON 前做 `wp_specialchars_decode`/`html_entity_decode`，确保前端拿到干净文本。

### 5.2 视觉覆盖类失败 (背景图 / 高度 / 响应式)

**现象 D：背景图上下/底部露出底色（尤其移动端、窗口缩放后更明显）**
*   **根因 1：背景图只铺在“内部舞台容器”，而 Section 还有 `pt/pb`**
    *   Section 的 padding 区域会露出底色，导致看起来“图片没铺满模块”。
*   **根因 2：使用 `min-height` + 内部绝对定位时，容器高度随断点变化造成覆盖不一致**
    *   不同屏幕高度下，内容区高度变化会把背景推开，露出底色。
*   **经验**（推荐稳定结构）：
    *   背景层永远放在 `section` 里：`absolute inset-0`
    *   背景使用 `background-size: cover; background-position: center;` 或 `img` 的 `object-cover`
    *   前景内容独立 `relative z-10`，不要让“内容容器”决定背景是否覆盖。

### 5.3 主题样式干扰类失败 (Buttons / Links)

**现象 E：按钮/链接 hover、边框、下划线被主题接管**
*   **根因：GeneratePress 对 `a/button` 有默认样式与 hover 行为，且优先级可能覆盖模块内 class**
*   **经验**：
    *   模块内交互控件（按钮/分页点/箭头）应使用模块专属 class，并在组件层用 `all: unset !important;` 重建基础样式
    *   需要保留无障碍：必须补上 `:focus-visible` ring（Action Color `#F97C30`）

### 5.4 推荐排查顺序 (Debug Order)

当遇到“后台有值但前端不显示 / 反复改不生效”，按以下顺序排查：
1.  **字段名**：后台 DOM `name/id` → PHP 读取字段名是否一致
2.  **上下文**：`get_flat_field` 是否在正确 post_id 上读取（Loop 必传 `_context_post_id`）
3.  **数据形态**：Image 返回是否为 ID（再转 URL），Link 是否为 array
4.  **表达式安全**：避免可选链；在浏览器 Console 看 Alpine 是否报错
5.  **注入方式**：大 JSON 不内联 attribute；改为 `window` 变量引用
6.  **主题干扰**：按钮/链接是否需要模块专属 class + `all: unset`
7.  **覆盖策略**：背景层是否 `absolute inset-0`，确保任何断点都 cover

---

## 6. 规范清单：避免“主题 vs 设计稿打架”

### 6.1 必须做 (Must)
*   **模块必须有 Scope**：每个模块外层都有 `lc-*` scope 类（不依赖页面级容器）。
*   **模块必须自带 Typography**：标题/正文/列表/链接/按钮都在模块内声明，不吃主题默认。
*   **链接默认不继承主题颜色**：在 App Mode（`body.lc-app`）下，链接默认 `color: inherit`，模块自己指定颜色。
*   **按钮不使用主题 `.button`**：避免主题 hover/边框/颜色接管。
*   **“居中”必须同时锁两件事**：`text-align: center` 只控制文本；如果 `mx-auto` 被主题覆盖为 `margin: 0`，block 仍会贴左，必须用组件类锁死 `margin-inline: auto`（例如 `.lc-section-header > h2/p`）。

### 6.2 禁止做 (Must Not)
*   **禁止**：为了“快速看起来差不多”而改动主题全局排版（会造成全站回归灾难）。
*   **禁止**：在模块内部依赖 `.entry-content` 等主题结构类去实现布局（结构一变就崩）。
*   **禁止**：用零散的 inline style 当作常态（只允许作为临时排障，最终要回到模块 class + scope）。

### 6.3 推荐做 (Should)
*   **建立两套模式**
    *   App Pages：模块视觉主权（`body.lc-app` + scope reset）
    *   Blog Pages：内容可读性优先（允许主题/排版接管）
*   **建立组件库**
    *   `lc-btn`（primary/secondary/ghost）
    *   `lc-link`（default/muted/invert）
    *   `lc-prose`（仅 Blog/文章正文使用）
    *   `lc-section-header`（标题区：锁死 `text-align + margin-inline`，避免主题覆盖 `mx-auto`）
