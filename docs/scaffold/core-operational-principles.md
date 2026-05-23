# 核心操作原则与决策指南 (Core Operational Principles)

本文档提炼了项目开发中必须遵守的**高阶操作原则**。它不是具体代码规范（Code Style），而是**架构决策指南**，用于在遇到分歧时提供裁决依据。

---

## 1. 开发流程原则 (Development Workflow)

### 1.1 视觉优先 (Visual First)
**原则**：一切开发始于视觉还原，终于数据绑定。
*   **操作**：先写 HTML/Tailwind，看着页面定字段。
*   **红线**：禁止在没有完美还原设计稿的情况下直接写 PHP 逻辑或定义 ACF 字段。
*   **收益**：避免 "盲目定义字段 -> 发现前端实现不了 -> 修改字段 -> 迁移数据" 的返工循环。

### 1.2 单模块闭环 (Single Module Closure)
**原则**：开发应以“模块”为单位，而不是以“层”为单位。
*   **操作**：不要一次性把所有页面的 HTML 写完，再写所有页面的 PHP。应该：`Hero HTML` -> `Hero ACF` -> `Hero PHP` -> `Verify` -> `Next Module`。
*   **收益**：降低认知负载，确保每个完成的模块都是可交付的 MVP。

---

## 2. 架构决策原则 (Architectural Decisions)

### 2.1 Block vs Template Part 决策树
**原则**：根据内容的**动态性**决定技术选型。
*   **使用 Block**：
    *   需要内容编辑人员在文章中**自由拖拽排序**（如：博客文章中的 CTA 卡片）。
    *   需要在不同页面**复用且内容不同**（如：产品卡片）。
*   **使用 Template Part**：
    *   位置**固定**（如：页眉、页脚、侧边栏）。
    *   结构**固化**（如：首页 Hero，虽然内容可变，但永远在顶部）。
*   **误区**：不要为了“组件化”而把页脚这种固定结构强行做成 Block，Template Part 性能更好且更容易维护。

### 2.2 配置与内容分离 (Config vs Content)
**原则**：Options Page 只存配置，Page/Post 存内容。
*   **Global Options (Options Page)**：存放全站通用的、**不依赖特定上下文**的数据（Logo, Social Links, API Keys, 默认 404 文案）。
*   **Page Content (Post Meta)**：存放**特定于该页面**的数据（首页 Hero 标题、关于页团队介绍）。
*   **红线**：禁止在 Options Page 中存储“关于我们”页面的具体内容。

---

## 3. 数据流向原则 (Data Flow & Override)

### 3.1 默认全局，局部覆盖 (Default to Global, Override Locally)
**原则**：利用 Global Modules 作为“兜底默认值”，Local Modules 作为“特定覆盖值”。
*   **场景**：全站页脚有一个 CTA。
    *   **默认**：读取 Global Options 中的 "Contact Us"。
    *   **覆盖**：在 "Medical" 页面，通过本地字段覆盖为 "Talk to a Doctor"。
*   **代码体现**：
    ```php
    // 自动回退逻辑
    $title = get_flat_field('cta_title', $block, get_field('global_cta_title', 'option'));
    ```

### 3.2 数据单向流动 (Unidirectional Data Flow)
**原则**：数据应总是从**上层（Controller/Page）**流向**下层（View/Render）**。
*   **操作**：`render.php` 不应自己去查询数据（如 `WP_Query`），它应该只渲染传入的 `$block` 数据。
*   **收益**：模块变得纯粹且可测试。

---

## 4. 维护性原则 (Maintainability)

### 4.1 DRY (Don't Repeat Yourself)
**原则**：避免重复代码，实现“一处修改，全站同步”。
*   **实践**：使用 ACF Clone 复用字段定义；使用 `_starter_render_block` 复用渲染逻辑。

### 4.2 显式优于隐式 (Explicit over Implicit)
**原则**：在关键逻辑处（如 Loop 上下文），显式传递参数比依赖隐式全局变量更安全。
*   **操作**：在 `WP_Query` 循环中调用模块时，**必须**显式传递 `_context_post_id`。
