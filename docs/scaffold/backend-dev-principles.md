# 后端开发核心原则与脚手架规范 (Backend Development Principles & Scaffold Standards)

本文档整理了在 WordPress 后端开发（特别是基于 ACF Pro + GeneratePress Child 架构）中必须遵守的核心原则。这些规范旨在确保代码的可维护性、数据的结构化以及“工业级”的后台用户体验。

## 0. 核心设计哲学 (Core Design Philosophy)

### 0.1 DRY 原则 (Don't Repeat Yourself)
**理念**：避免重复代码，实现“一处修改，全站同步”。
*   **实践**：
    *   **Global Options Page**：将全站通用的配置（如 CTA 文案、社交链接、404设置）集中管理。严禁在每个页面重复创建相同的字段。
    *   **ACF Clone**：复用已有的字段组（如 `hero_banner`），而不是重新定义。

### 0.2 实用主义编程 (Pragmatic Programming)
**理念**：根据业务场景选择最合理的架构，而不是盲目追求“完美”。
*   **Block vs Template Part 决策法**：
    *   **需要手动插入？** -> 做成 **Block**（如文章中的 CTA、产品卡片）。
    *   **位置固定？** -> 做成 **Template Part**（如首页 Hero、页脚导航）。不要为了“组件化”而把不需要移动的模块强行做成 Block。

### 0.3 组件纯度优先 (Component Purity First)
**原则**：当发现某个“原子组件 / component”带有不该存在的结构（例如自带 Section 容器、Header 标题区、页面级布局），应优先**修正组件本体**，而不是在外层新增大量“兼容代码”去适配错误结构。
*   **允许**：外层模块（Template Part）负责标题、描述、背景、分栏、间距等页面级布局；组件只负责自身输入控件与交互/提交逻辑。
*   **禁止**：为兼容错误组件而引入全局变量/特殊开关/多套分支渲染，导致调用方变复杂、维护成本上升。
*   **工作流**：发现结构不纯 -> 先提醒并提出“回归组件纯度”的重构方案 -> 再进行字段/模板开发。

---

## 4. 环境契约与编辑器管理 (Environment Contract & Editor Management)

### 4.1 集中化编辑器控制 (Centralized Editor Control)
**原则**：在 `inc/setup.php` 中统一管理全站的编辑器行为，严禁在各模块文件中分散禁用。
*   **SOP 规范**：
    *   **Page / CPT (Product, Industry)**：强制禁用古腾堡编辑器，并移除默认 `editor` 支持。
    *   **Post (Blog)**：保留古腾堡编辑器，支持自由撰写长文。
*   **代码实现**：
    ```php
    // 禁用特定类型的古腾堡
    add_filter( 'use_block_editor_for_post_type', function( $use_block_editor, $post_type ) {
        return in_array( $post_type, ['page', 'product', 'industry'] ) ? false : $use_block_editor;
    }, 100, 2 );

    // 移除默认 Editor 支持，确保 ACF 建模纯净
    add_action( 'init', function() {
        remove_post_type_support( 'page', 'editor' );
        // ...
    }, 100 );
    ```

### 4.2 工业级录入体验
*   **Classic Editor 优先**：除了博客外，所有核心建模页面必须使用 Classic Editor + ACF，确保“所见即所得”的数据结构。
*   **移除冗余**：移除不必要的默认字段（如 `editor`），避免录入人员混淆数据存放位置。

---

## 1. 字段命名空间与逻辑 (Field Naming & Logic)

### 1.1 语义化命名 (Semantic Naming)
**原则**：弃用模糊的命名。针对工业属性，字段名必须精准反映物理意义。
*   ❌ **错误**：`spec_1`, `data_value`, `info_text`
*   ✅ **正确**：`alloy_grade`, `conductivity_iacs`, `tensile_strength_ksi`

### 1.2 模块化命名与 Clone 策略 (Modular Naming & Cloning)
**原则**：确保字段名的全局唯一性，以便在 Clone 时无需使用前缀。
*   **命名格式**：`{模块缩写}_{字段功能}`
    *   例如：Hero Banner 模块的标题 -> Name: `hero_title`, Key: `field_hero_title`
    *   例如：Feature List 模块的描述 -> Name: `feature_desc`, Key: `field_feature_desc`
*   **Clone 策略**：在构建页面模板（Page Templates）时，直接 Clone 已有的模块字段组。
    *   **Prefix 设置**：由于上述命名已确保唯一性，**不需要开启 Prefix**。这能让数据结构更扁平，前端调用更简单（直接 `get_field('hero_title')` 而不是 `get_field('hero_hero_title')`）。

### 1.3 字段非必填 (Optional Fields)
**原则**：所有字段默认均**不是**必填项。
*   **配置**：`'required' => 0`
*   **目的**：给予内容录入人员最大的灵活性，避免因缺少某张图片或文案而无法保存页面。前端代码必须做好 `if( get_field() )` 的判空处理。

### 1.4 单位分离 (Unit Separation)
**原则**：对于技术参数，**数值**与**单位**应尽量分离，或在字段配置中固定。
*   **要求**：在 ACF 的 `append` 属性中写死单位（如 `%`, `m/K`, `ksi`）。
*   **目的**：确保前端调用 `font-mono` 渲染时格式统一，同时保持数据库中存储的是纯净数值（便于未来可能的计算或筛选）。

---

## 2. 工业级后台体验 (Admin UX for Industrial Precision)

### 2.1 引导式填单 (Instructional UX)
**原则**：后台不仅仅是输入框，更是操作指南。在字段的 `instructions` 中直接写入设计系统规范。
*   **例子**：在产品主图字段注明：“请上传一张宏观仓库实拍图，背景建议带有深色遮罩效果，以符合‘仓储式信任感’风格。”

### 2.2 字段宽度布局 (Field Width)
**原则**：严禁所有字段垂直堆叠。模拟“实验室报告”的排版感，提高屏效。
*   **操作**：利用 `wrapper => ['width' => '25']`（或 33/50）将相关的参数（如化学元素、百分比、最小值、最大值）排在同一行。

### 2.3 页面模板的层级结构 (Page Template Hierarchy)
**原则**：在构建复杂页面（如 Homepage, Landing Page）的后台时，必须遵循 **Tab -> Accordion -> Field** 的三层结构，确保后台整洁且数据扁平。

*   **🧱 第一层：Tab (顶级大区分类 - 横向)**
    *   **作用**：把超长页面切分成几个心理区块，消除客户填写的恐惧感。
    *   **命名示例**：`Overview` (概览), `Technical Specs` (技术规格), `Resources` (相关资源)。
    *   **数据影响**：**0**。它只是视觉切片。

*   **🔽 第二层：Accordion (模块容器 - 纵向折叠)**
    *   **作用**：代替传统的 Group，把属于同一个模块的字段“视觉打包”。
    *   **规则**：
        *   每个具体模块（如 Hero Banner）必须用 `'type' => 'accordion'` 包裹。
        *   **默认状态**：首个模块设为 Open（展开），其余默认 Closed（折叠），保持页面清爽。
        *   **禁令**：**绝对不允许使用 Group 字段作为模块容器**（会导致数据嵌套，增加前端复杂度）。
    *   **数据影响**：**0**。数据依然在根目录。

*   **📝 第三层：纯净的字段 (数据本体)**
    *   **作用**：装填具体内容。
    *   **规则**：所有的内容字段必须直接放在 Accordion 下方。
    *   **Clone 规范**：如果是从基础模块 Clone 过来的，**绝对不要开启 Prefix**。
    *   **拥抱 Seamless**：Clone 字段时，必须设置 `'display' => 'seamless'`（无边框模式）。**绝对不允许出现 `'display' => 'group'`**，否则 ACF 会在数据库中创建一个嵌套数组，破坏数据的扁平化结构。

---

## 3. 结构化数据建模 (Structured Spec Modeling)

### 3.1 参数表矩阵 (Technical Matrix)
**原则**：处理多组技术参数（如化学成分、物理性能）时，必须使用结构化布局。
*   **Repeater 布局**：`layout` 必须设置为 `table`。这最符合工业从业者查看 **MTR (材质报告)** 的习惯。
*   **折叠逻辑**：所有 Repeater 必须设置 `collapsed` 指向核心字段（如型号名称），确保后台页面加载时不会展开长列表，保持整洁。

### 3.2 应用场景图标化 (Iconography)
**原则**：应用场景字段不应只是文本，应与视觉元素绑定。
*   **操作**：使用 `Select` 或 `Checkbox` 关联预设的工业图标（如 Aerospace, Automotive），确保前端输出的一致性，避免拼写错误或风格不统一。

### 3.3 大数据量规避 (Avoid Heavy Repeaters)
**原则**：ACF Repeater 适合小规模列表（如 3-5 个 Features）。
*   **红线**：对于超大规模的矩阵数据（如 50 行 x 10 列的参数表），**禁止使用 ACF Repeater**。
*   **替代方案**：
    *   **ACF Table Field**：使用插件将表格存储为一个 JSON 字符串，极大减少数据库压力。
    *   **硬编码**：对于极其复杂且不常变动的表格，直接在前端模板中硬编码 HTML 表格。

---

## 4. 绝对禁区 (Strictly Forbidden)

### 4.1 严禁前端渗透
*   **规则**：后端 PHP 代码（尤其是 ACF 定义文件）中禁止出现任何 HTML 标签或 CSS 样式。
*   **例外**：仅允许在 `instructions` 中使用极少量的格式化标签（如 `<b>` 或 `<br>`），除此之外必须保持数据纯净。

### 4.2 严禁死数据
*   **规则**：禁止使用简单的文本域（Textarea）输入复杂的参数表或列表。
*   **要求**：必须通过 `Repeater` 进行结构化存储。
*   **目的**：为未来的 **SEO Schema (结构化数据)** 标记预留空间，机器无法理解 Textarea 中的表格文本，但能理解 Repeater 数据。

### 4.3 禁止默认编辑器冲突
*   **规则**：所有由 ACF 驱动的页面模板或 CPT，必须在 PHP 中关闭古腾堡编辑器。
*   **代码**：使用 `use_block_editor_for_post_type` 过滤器返回 `false`。
*   **目的**：防止后台同时出现“古腾堡编辑器”和“ACF 字段组”，导致内容录入混乱。

### 4.4 媒体字段返回格式 (Media Return Format)
*   **规则**：所有 Image / File 类型的字段，**Return Format 必须强制选择 "Image ID"**。
*   **禁止**：严禁选择 "Image Array" 或 "Image URL"。
*   **理由**：前端需要 ID 来生成 `srcset` (响应式图片) 或获取不同尺寸的缩略图。返回 URL 会导致前端无法利用 WordPress 的图片优化功能，且容易引发代码与配置的类型不匹配错误。

---

## 5. 附录：脚手架文件清单 (Scaffold Checklist)

在迁移或新建项目时，请确保以下核心文件符合上述规范：

*   `functions.php`: 主题入口，负责加载所有核心模块。
*   `inc/setup.php`: 负责关闭默认编辑器、注册菜单、配置主题支持。
*   `inc/assets.php`: 负责加载 Tailwind CSS 和 JS 资源。
*   `inc/helpers.php`: 包含 `get_flat_field` 和 `_starter_render_block` 等核心工具函数。
*   `inc/acf/fields.php`: 负责自动加载字段定义。
*   `inc/acf/field/*.php`: 具体的字段定义文件，需检查命名和布局。
