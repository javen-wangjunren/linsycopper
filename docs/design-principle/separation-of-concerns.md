# 关注点分离 (Separation of Concerns) 在 WordPress 开发中的实践

**关注点分离 (SoC)** 是软件工程中最核心的设计原则之一。它的核心思想是：**将复杂的系统拆分为职责单一、互不重叠的模块。** 每个模块只关注自己的一件事，并且把它做好。

在我们的 WordPress 项目中，这一原则通过将 `header.php` 和 `footer.php` 从"执行者"转型为"调度者"得到了完美的体现。

---

## 1. 核心思想：调度者 vs 执行者

在传统的（或初学者的）WordPress 开发中，所有的逻辑往往被堆砌在一个文件中。

### 🚫 反模式：全能型文件 (The God Object)
一个文件包含了所有层面的代码：
*   **数据层**：从数据库或 ACF 获取字段。
*   **逻辑层**：复杂的 `if/else` 判断（比如判断是否是移动端，是否有 Logo）。
*   **视图层**：大量的 HTML 标签和 CSS 类名。
*   **表现层**：内联的 SVG 图标代码。

**后果**：文件变得像一团乱麻，修改任何一个小地方都可能引发全局崩坏。

### ✅ 最佳实践：分层架构 (Layered Architecture)
我们将系统拆分为两个清晰的角色：

1.  **调度者 (Dispatcher)**：负责宏观布局和任务分配。
    *   *口头禅*："那个谁，去把 Logo 拿来；那个谁，去把菜单渲染一下。"
    *   *代表文件*：`header.php`, `footer.php`
2.  **执行者 (Worker)**：负责具体细节的实现。
    *   *口头禅*："好的，我只负责把 Logo 图片加载出来，不管它放在哪里。"
    *   *代表文件*：`template-parts/**/*.php`

---

## 2. 案例分析：Header 的重构

### 重构前 (Before)
`header.php` 是一个 500 行的庞然大物。
*   如果你想修改移动端菜单的样式，你必须小心翼翼地绕过 Logo 的逻辑代码。
*   大脑必须同时处理"HTML 整体结构"和"SVG 图标路径"这两个完全不同维度的信息，**认知负荷极高**。

### 重构后 (After)
`header.php` 被精简为 100 行左右的**"指挥中心"**。

```php
// header.php (指挥官)
<header>
    <!-- 1. Logo 专员 -->
    <?php get_template_part( 'template-parts/header/logo' ); ?>

    <!-- 2. 桌面菜单专员 -->
    <?php get_template_part( 'template-parts/header/nav-desktop' ); ?>

    <!-- 3. 移动端菜单专员 -->
    <?php get_template_part( 'template-parts/header/nav-mobile' ); ?>
</header>
```

*   **物理隔离**：移动端的代码在 `nav-mobile.php` 里。你在这里怎么改，绝对不可能影响到桌面端。
*   **职责单一**：`header.php` 只关心布局顺序，不关心实现细节。

---

## 3. 案例分析：Footer 的重构

### 重构前 (Before)
`footer.php` 充满了重复代码（DRY Violation）。
*   为了显示 4 个不同的菜单，写了 4 遍几乎一模一样的 `wp_nav_menu` 代码。
*   左侧的联系方式逻辑（PHP 循环）夹杂在右侧菜单的布局代码中，阅读体验极差。

### 重构后 (After)
`footer.php` 变成了清爽的**"版面总监"**。

```php
// footer.php (版面总监)
<footer>
    <div class="grid...">
        <!-- 左侧：品牌与联系 -->
        <?php get_template_part( 'template-parts/footer/branding' ); ?>

        <!-- 右侧：导航菜单 -->
        <?php get_template_part( 'template-parts/footer/menus' ); ?>
    </div>
</footer>
```

*   **逻辑封装**：所有的菜单渲染逻辑都被封装在 `template-parts/footer/menus.php` 中的一个辅助函数里。
*   **视图清晰**：左侧的品牌信息（Branding）和右侧的菜单（Menus）被物理拆分。修改左侧内容时，右侧代码根本不会出现在你的视线里。

---

## 4. 总结：SoC 带来的三大红利

1.  **降低认知负荷 (Cognitive Load)**
    当你打开一个文件时，你面对的是**"结构"**而不是**"细节"**。你可以快速理解文件的意图，而不需要通读几百行代码。

2.  **降低耦合风险 (Risk Isolation)**
    修改一个模块（如移动端菜单），绝对不会意外破坏另一个模块（如桌面端菜单）。因为它们在物理上就是隔离的。

3.  **提升复用性 (Reusability)**
    封装好的组件（如 Logo 模块、菜单渲染函数）可以在项目的其他地方（如侧边栏、404 页面）直接复用，而不需要复制粘贴代码。
