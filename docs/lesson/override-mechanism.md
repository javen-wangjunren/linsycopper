# Override Mechanism (覆盖/重写机制)

本文档详细阐述了 **"Default to Global, Override Locally" (默认全局，局部覆盖)** 这一核心设计模式，并以 CTA (Call to Action) 模块为例进行实战解析。

## 1. 核心设计理念

在构建大型企业网站时，我们经常面临两难选择：
*   **一致性 (Consistency)**: 大部分页面需要统一的 UI 和内容（如统一的页脚 CTA）。
*   **灵活性 (Flexibility)**: 某些特定页面（如行业着陆页）需要定制化的内容。

为了兼顾二者，我们采用了 **Override Mechanism**。

### 核心规则
1.  **Default (默认)**: 如果调用时不指定数据源，则默认读取 **Global Options**。
2.  **Override (覆盖)**: 如果调用时指定了特定的 `prefix`，则读取 **Current Post** 的数据，从而覆盖全局默认值。

## 2. 实战案例：CTA 模块 (Call to Action)

我们以全站通用的 CTA 模块为例，演示如何通过同一套代码实现“全局统一”和“局部定制”。

### 2.1 场景 A：全局默认 (Global Default)
**需求**: 在首页、关于页、服务列表页显示统一的 "Contact Us" 模块。

#### 后端配置 (inc/options-page.php)
我们在 `Global Modules` 设置页中填写了通用的 CTA 内容：
*   **Title**: "Ready to start?"
*   **Button**: "Get a Quote"

#### 前端调用 (front-page.php)
```php
// 不传递 'prefix' 参数
_3dp_render_block( 'blocks/global/cta/render', array( 
    'id' => 'home-cta' 
) );
```

#### 渲染逻辑 (render.php)
```php
// 1. 获取前缀: 空
$pfx = ''; 

// 2. 判定: 进入 Global 分支
if ( empty( $pfx ) ) {
    // 读取 Global Options
    $data = get_field('global_cta', 'option'); 
    // 结果: 显示 "Ready to start?"
}
```

---

### 2.2 场景 B：局部覆盖 (Local Override)
**需求**: 在 "Medical 3D Printing" 着陆页，我们需要显示更具针对性的 "Talk to a Medical Specialist"。

#### 后端配置 (ACF Field Group)
1.  创建一个新的字段组，应用到 `Page Template: Medical`。
2.  引入 CTA Clone 字段。
3.  **关键步骤**: 设置 Field Name Prefix 为 `medical_cta_`。
4.  在页面编辑后台，填写：
    *   **Title**: "Talk to a Medical Specialist"
    *   **Button**: "Book Consultation"

#### 前端调用 (page-medical.php)
```php
// 传递特定的 'prefix' 参数
_3dp_render_block( 'blocks/global/cta/render', array( 
    'id'     => 'medical-cta',
    'prefix' => 'medical_cta_' // <--- 触发覆盖机制的开关
) );
```

#### 渲染逻辑 (render.php)
```php
// 1. 获取前缀: 'medical_cta_'
$pfx = 'medical_cta_';

// 2. 判定: 进入 Local 分支 (因为 pfx 不为空)
if ( empty( $pfx ) ) {
    // ... 跳过 Global ...
} else {
    // 读取 Current Post 的 Local Data
    // get_field_value 会拼接前缀: 'medical_cta_' + 'cta_title'
    $data['title'] = get_field_value('cta_title', ..., 'medical_cta_');
    // 结果: 显示 "Talk to a Medical Specialist"
}
```

## 3. 架构优势

1.  **代码复用 (DRY)**: 我们不需要为 Medical 页面单独写一个 `cta-medical.php`。同一套 `render.php` 完美适配两种场景。
2.  **维护性 (Maintainability)**: 如果未来要修改 CTA 的样式（比如改背景色），只需要改 `render.php` 一个文件，全局和局部的 CTA 都会自动更新样式。
3.  **扩展性 (Scalability)**: 未来如果有 10 个不同的行业着陆页，只需要在后台配置 10 个不同的 Prefix，前端代码逻辑完全不用变。

## 4. 总结图解

```mermaid
graph TD
    subgraph "Template Call"
        A[Call _3dp_render_block] --> B{Has Prefix?}
    end

    subgraph "Render Logic"
        B -- No (Default) --> C[Load Global Data]
        B -- Yes (Override) --> D[Load Local Data with Prefix]
    end

    subgraph "Data Source"
        C --> E[wp_options (Global Settings)]
        D --> F[wp_postmeta (Current Page)]
    end

    subgraph "Result"
        E --> G[Standard UI]
        F --> H[Customized UI]
    end
```
