# 全局模块架构设计 (Global Module Architecture)

本文档详细描述了 `header.php` 和 `footer.php` 的架构设计，展示了如何通过**关注点分离 (SoC)** 原则，实现前后端逻辑的解耦与高效调度。

## 1. 核心架构图 (System Overview)

整个系统分为三层：
1.  **数据层 (Data Layer)**: ACF Options Page 负责管理全局静态数据。
2.  **调度层 (Dispatcher Layer)**: `header.php` / `footer.php` 负责宏观布局和组件调用。
3.  **表现层 (Presentation Layer)**: `template-parts` 负责具体的 HTML 渲染。

```mermaid
graph TD
    %% Define Styles
    classDef acf fill:#e1f5fe,stroke:#01579b,stroke-width:2px;
    classDef dispatcher fill:#fff9c4,stroke:#fbc02d,stroke-width:2px;
    classDef part fill:#e8f5e9,stroke:#2e7d32,stroke-width:2px;
    classDef wp fill:#f3e5f5,stroke:#7b1fa2,stroke-width:1px,stroke-dasharray: 5 5;

    %% Data Layer (ACF)
    subgraph Data_Layer ["数据层 (ACF Options)"]
        ACF_Header["Header Settings<br>(CTA, Menus)"]:::acf
        ACF_Footer["Footer Settings<br>(Branding, Contacts)"]:::acf
    end

    %% Dispatcher Layer
    subgraph Dispatcher_Layer ["调度层 (Dispatchers)"]
        HeaderPHP["header.php<br>(指挥官)"]:::dispatcher
        FooterPHP["footer.php<br>(版面总监)"]:::dispatcher
    end

    %% Presentation Layer
    subgraph Presentation_Layer ["表现层 (Template Parts)"]
        %% Header Parts
        Part_Logo["template-parts/header/logo"]:::part
        Part_Nav["template-parts/header/nav-desktop"]:::part
        Part_Mobile["template-parts/header/nav-mobile"]:::part
        
        %% Footer Parts
        Part_Branding["template-parts/footer/branding"]:::part
        Part_Contacts["template-parts/footer/contact-info"]:::part
        Part_Menus["template-parts/footer/menus"]:::part
    end

    %% WordPress Core
    subgraph WP_Core ["WordPress Core"]
        WP_Menu["WP Nav Menu System"]:::wp
        WP_Customize["Customizer (Logo)"]:::wp
    end

    %% Data Flow
    ACF_Header -->|"get_field()"| HeaderPHP
    ACF_Footer -->|"get_field()"| Part_Branding & Part_Contacts
    
    WP_Menu -->|"get_primary_menu_tree()"| HeaderPHP
    WP_Menu -->|"wp_nav_menu()"| FooterPHP

    WP_Customize -->|"get_custom_logo()"| Part_Branding

    %% Dispatch Flow
    HeaderPHP -->|"get_template_part()"| Part_Logo
    HeaderPHP -->|"get_template_part()"| Part_Nav
    HeaderPHP -->|"get_template_part()"| Part_Mobile

    FooterPHP -->|"get_template_part()"| Part_Branding
    FooterPHP -->|"get_template_part()"| Part_Contacts
    FooterPHP -->|"wp_nav_menu()"| Part_Menus
```

---

## 2. Header 详细流程 (Header Flow)

Header 作为一个高交互区域，需要同时处理数据获取、状态管理 (Alpine.js) 和组件分发。

```mermaid
graph LR
    %% Styles
    classDef step fill:#fff,stroke:#333,stroke-width:1px;
    classDef logic fill:#e3f2fd,stroke:#1565c0,stroke-width:2px;

    Start(("开始渲染")) --> Init["1. 初始化变量<br>(Menu Tree, CTA Data)"]:::step
    Init --> State["2. Alpine.js 状态<br>(openMenu, mobileOpen)"]:::logic
    
    State --> Layout{{"3. 布局分发"}}
    
    Layout --"Logo 区域"--> Logo["渲染 Logo<br>(SVG/Image)"]:::step
    Layout --"Desktop Nav"--> Nav["循环 Menu Tree<br>渲染 Mega Menu"]:::step
    Layout --"Actions"--> Actions["渲染 CTA 按钮<br>& Mobile Toggle"]:::step
    
    Nav --"Hover Event"--> MegaMenu["加载 template-parts/<br>header/mega-menu"]:::logic
    
    Actions --"Click Event"--> MobileDrawer["触发 template-parts/<br>header/nav-mobile"]:::logic
```

---

## 3. Footer 详细流程 (Footer Flow)

Footer 侧重于静态内容的展示，数据来源主要为 ACF Global Settings。

```mermaid
graph TD
    %% Styles
    classDef acf_source fill:#e0f7fa,stroke:#006064,stroke-width:2px;
    classDef render fill:#f1f8e9,stroke:#33691e,stroke-width:2px;

    %% Sources
    ACF_Brand["ACF: Footer Branding"]:::acf_source
    ACF_Contact["ACF: Contact List"]:::acf_source
    ACF_Titles["ACF: Menu Titles"]:::acf_source
    WP_Menus["WP: Nav Menus"]:::acf_source

    %% Main Render
    Footer_Main["footer.php Main Grid"]

    %% Data Injection
    ACF_Brand -->|"Inject Data"| Part_Brand["template-parts/footer/branding"]:::render
    ACF_Contact -->|"Inject Data"| Part_Contact["template-parts/footer/contact-info"]:::render
    
    ACF_Titles -->|"Get Titles"| Footer_Main
    WP_Menus -->|"Get Menus"| Footer_Main

    %% Composition
    Part_Brand --> Footer_Main
    Part_Contact --> Footer_Main
    
    Footer_Main --> Final["最终 HTML 输出"]
```

---

## 4. 文件职责清单

| 文件路径 | 角色 | 职责描述 | 数据来源 |
| :--- | :--- | :--- | :--- |
| `inc/field/global/header.php` | **数据定义** | 定义 Header 的 ACF 字段（如 CTA 按钮、自定义代码）。 | N/A |
| `inc/field/global/footer.php` | **数据定义** | 定义 Footer 的 ACF 字段（品牌、联系方式、版权）。 | N/A |
| `header.php` | **调度者** | 负责 `<header>` 标签结构，初始化 Alpine.js 状态，调度各个子部件。 | `get_primary_menu_tree()`, ACF Options |
| `footer.php` | **调度者** | 负责 `<footer>` 栅格布局，调用 WP 菜单函数和子部件。 | ACF Options, `wp_nav_menu()` |
| `template-parts/header/*` | **执行者** | 负责具体的 HTML 渲染（如 Mega Menu 面板、移动端抽屉）。 | 父级传递变量 (`set_query_var`) |
| `template-parts/footer/*` | **执行者** | 负责渲染特定的内容块（如 Branding 信息、联系方式列表）。 | 直接调用 `get_field(..., 'option')` |

## 5. 扩展性说明

*   **新增菜单列**: 只需在 `inc/setup.php` 注册新位置，并在 `footer.php` 添加对应调用即可。
*   **修改联系方式**: 客户可直接在后台 "Global Settings > Footer" 中添加/删除/排序联系方式，无需修改代码。
*   **更换 Logo**: 客户在 Customizer 或 Global Settings 中上传新图，全站自动更新。
