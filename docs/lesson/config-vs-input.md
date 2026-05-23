# Tailwind CSS: input.css vs tailwind.config.js 深度对比

这是你在开发中打交道最多的两个文件。它们的分工非常明确：一个是**"原材料"**，一个是**"设计蓝图"**。

## 1. 核心定位对比

| 特性 | [tailwind.config.js](../tailwind.config.js) | [src/input.css](../src/input.css) |
| :--- | :--- | :--- |
| **形象比喻** | **设计蓝图 (大脑)** | **特殊施工队 (双手)** |
| **主要作用** | 定义"有什么" (颜色、字体、间距) | 处理"怎么办" (复杂样式、冲突修复、第三方插件) |
| **生成产物** | 不直接生成 CSS，而是指导 CSS 的生成 | 最终编译成浏览器能看的 CSS 代码 |
| **修改频率** | 高 (每次定义新颜色或调整间距) | 中 (遇到布局 Bug 或定制第三方组件时) |
| **核心逻辑** | JavaScript 配置对象 | 标准 CSS + Tailwind 指令 (@apply, @layer) |

---

## 2. 详细功能解析

### [tailwind.config.js](../tailwind.config.js) —— 定义规则
**"我规定这个网站只能用这几种蓝色，内边距标准是 24px。"**

*   **设计系统 (Design System)**: 所有的颜色 (`theme.extend.colors`)、字体、断点都在这里定义。
*   **原子类生成器**: 如果你写了 `colors: { primary: '#0047AB' }`，Tailwind 就会自动生成 `bg-primary`, `text-primary`, `border-primary` 等一系列工具类。
*   **全局配置**: 比如 `important: true` (强制覆盖) 和 `content` (扫描路径)。

**代码示例:**
```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        'brand-blue': '#0047AB', // 定义颜色
      },
      borderRadius: {
        'card': '12px', // 定义圆角
      }
    }
  }
}
```

### [src/input.css](../src/input.css) —— 解决例外
**"有些地方光靠工具类搞不定，比如我要强制隐藏侧边栏，或者给 Fluent Forms 表单写样式。"**

*   **全局重置 (Reset)**: 这里的 `@layer base` 用于覆盖浏览器和 GeneratePress 主题的默认样式（如移除链接下划线、隐藏侧边栏）。
*   **复杂选择器**: 当你需要选中 `父元素:hover > 子元素` 这种复杂关系时，或者定制第三方插件（如 Fluent Forms）的样式时，必须写在这里。
*   **组合类 (@apply)**: 把一堆 Tailwind 类组合成一个新类。比如 `.btn-primary { @apply bg-blue-500 text-white py-2 px-4; }`。

**代码示例:**
```css
/* src/input.css */
@layer base {
  /* 强制隐藏侧边栏，这是 tailwind.config.js 做不到的 */
  #right-sidebar {
    display: none !important;
  }
}

@layer components {
  /* 定制 Fluent Forms 插件样式 */
  .fluentform .ff-el-form-control {
    @apply border-gray-300 rounded-md; /* 使用 config 里定义的工具类 */
  }
}
```

---

## 3. 什么时候改哪个？

### 修改 [tailwind.config.js](../tailwind.config.js) 的情况：
1.  **新增颜色**：UI 设计师给了一个新的"深空灰"。
2.  **调整间距**：觉得默认的 `p-4` 太小，想加一个 `p-card` (32px)。
3.  **添加字体**：引入了一个新的 Google Font。
4.  **修改断点**：决定把手机端的断点从 640px 改到 768px。

### 修改 [src/input.css](../src/input.css) 的情况：
1.  **布局崩坏**：GeneratePress 的侧边栏突然跑出来了，需要写 CSS 强制隐藏。
2.  **插件样式**：安装了 Fluent Forms 或 Woocommerce，它们的默认样式太丑，无法直接在 HTML 里加 Tailwind 类，只能在这里用 CSS 选择器覆盖。
3.  **全局标签样式**：想让所有的 `<h1>` 标签都默认变成 50px 大小，不想每个 `<h1>` 都手写 `class="text-5xl"`。
4.  **伪元素**：需要用到 `::before` 或 `::after` 这种复杂的伪元素效果。

## 总结
*   **能用 [tailwind.config.js](../tailwind.config.js) 解决的，绝不写 CSS。** (保持原子化)
*   **实在搞不定的（第三方插件、全局重置、复杂交互），才去 [src/input.css](../src/input.css) 写代码。**
