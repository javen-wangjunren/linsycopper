# WordPress 架构反思：走出 Block vs Template Part 的误区

> **"做成 Block 的模块，就不应该用于 Page Template 的调用；Block 就是用于古腾堡的。"**

这是一个关于从 Shopify/Wix 模块化思维转型到 WordPress 主题开发时的经典架构误区。本文档旨在记录这一弯路，作为未来开发的警示与指南。

## 1. 误区复盘：过度工程的陷阱

### 背景
开发者习惯了 Shopify/Wix 等 SaaS 平台的 "Section/Module" 概念，认为“一切皆模块，一切皆应可复用”。

### 错误路径
1.  **盲目 Block 化**：认为只要是页面上的一个功能块（如 Hero Banner, CTA），就必须注册为 ACF Block。
2.  **硬编码调用**：实际上并未使用古腾堡编辑器（Gutenberg Editor），而是直接在 PHP 模板文件（如 `page-home.php`）中硬编码调用这些 Block。
3.  **制造困难**：WordPress 原生不提供在 PHP 中便捷调用 Block 的方法。
4.  **填坑修补**：
    *   为了在 PHP 中调用 Block，编写了复杂的 helper 函数 `_3dp_render_block`。
    *   为了解决字段冲突，引入了 ACF Clone 和复杂的 Prefix（前缀）逻辑。
    *   导致了 `page-contact.php` 等模板中出现了 `prefix => 'contact_hero_clone_'` 这种晦涩的代码。

### 核心矛盾
**工具与场景的错位**：试图用设计给 **"动态内容流" (Gutenberg)** 的工具，强行解决 **"静态页面架构" (Page Templates)** 的问题。

---

## 2. 核心决策准则：黄金法则

在决定一个功能模块该怎么写之前，只需问一个问题：

**“运营人员是否需要在后台编辑器中手动插入、拖拽这个模块？”**

### 场景 A：需要手动插入 -> 使用 Block (区块)
*   **适用页面**：博客文章 (Blog Posts)、通用页面 (General Pages)、营销着陆页 (Landing Pages)。
*   **特征**：内容结构不固定，运营人员拥有布局控制权。
*   **例子**：
    *   文章中插入的“产品卡片”
    *   着陆页的“CTA 按钮”
    *   通用的“FAQ 手风琴”

### 场景 B：不需要手动插入 -> 使用 Template Part (模板部件)
*   **适用页面**：首页 (Homepage)、关于页 (About Us)、联系页 (Contact)、页眉/页脚。
*   **特征**：页面结构由设计师定稿，开发者在 PHP 中写死，运营只负责填内容。
*   **例子**：
    *   首页的 Hero Banner
    *   联系页的表单区域
    *   列表页的分页组件 (Pagination)
    *   **Featured Materials Section** (All Capabilities Page 专用)

---

## 3. 技术实现对比

| 维度 | Template Part 模式 (推荐) | Block 模式 (误区) |
| :--- | :--- | :--- |
| **文件结构** | **简单**。<br>1. 渲染文件: `template-parts/xxx.php` (含 HTML + Logic)<br>2. 字段定义: 直接嵌套在 Page Field Group 中 | **复杂**。<br>1. 渲染文件: `blocks/xxx/render.php`<br>2. 字段定义: `inc/acf/field/xxx.php` (独立文件)<br>3. 注册文件: `inc/acf/blocks.php` |
| **字段管理** | **嵌套 (Nested)**。<br>字段定义直接写在页面配置里 (如 `page-all-capabilities.php`)，不需要 Clone。 | **独立 (Standalone)**。<br>字段定义是独立的 Group，必须通过 `Clone` 引入到页面配置中。 |
| **调用方式** | `get_template_part('partials/hero')` | `_3dp_render_block('blocks/hero')` (自定义封装) |
| **数据来源** | **上下文感知** (Context-Aware)<br>直接读取当前页字段，或通过 `set_query_var` 传参 | **自给自足** (Self-Contained)<br>依赖 Block 自身的字段，需处理 Clone/Prefix |
| **代码量** | 少 (纯 PHP include) | 多 (需注册 Block, 处理 JSON, 处理渲染回调) |
| **复用性** | **低**。通常绑定特定页面的字段结构。 | **高**。可以在任何页面复用。 |

### 深度剖析：Featured Materials 案例

以 `Featured Materials` 为例，我们采用了 **Template Part** 模式，其特征如下：

1.  **没有独立的 render.php**：
    它的渲染逻辑直接写在 `template-parts/page-all-capabilities/featured-materials.php` 里。不需要像 Block 那样创建一个专门的 render 文件。

2.  **没有独立的 Field Group**：
    它的字段定义直接**嵌套**在 `inc/acf/pages/page-all-capabilities.php` 这个大字段组里。
    *   **优点**：结构紧凑，字段名 (`featured_materials`) 是确定的，不需要处理 Prefix。
    *   **缺点**：无法在其他页面直接复用这组字段（除非复制粘贴代码）。

---

## 4. 最佳实践指南

### 对于新项目
1.  **Template Parts First (模版优先)**：默认将所有模块写成 Template Part。
2.  **按需升级**：只有当明确需求指出“这个模块需要在博客文章里随便插”时，再将其封装为 Block。

### 对于当前项目 (补救措施)
1.  **保持现状**：已有的 `_3dp_render_block` 封装虽然繁琐，但逻辑自洽且运行良好，**不建议重构**。
2.  **新模块开发**：对于新开发的、仅用于固定模板的模块（如 `pagination.php`, `contact-section.php`），严格遵循 Template Part 模式。
3.  **混合架构**：接受项目中同时存在 Block 和 Template Part 的现状，这是实用主义的体现。

---

**总结**：软件架构没有绝对的对错，只有适合与不适合。理解了 Block 与 Template Part 的边界，就是打通了 WordPress 开发的任督二脉。
