# 整体设计风格总结

**风格名**： **Industrial Material Realism (工业材质实录风)** 。

**核心关键词**： **现货信任 (Stock Trust)**、**材质本色 (Materiality)**、**高密度 (High Density)**、**精密参数 (Precision Specs)** 。

---

# 设计风格系统规范

### 1. 核心设计哲学 (Core Philosophy)

**仓储式信任感 (Warehouse Trust)**：通过大面积的深色色块（深蓝）与真实的金属仓库背景结合，模拟“大厂库存”的物理压迫感，建立 B2B 贸易中至关重要的现货供应能力信心 。

**参数驱动的决策逻辑 (Spec-Driven Logic)**：拒绝空洞的装饰，将合金牌号（Alloy Grade）、化学成分、物理参数等“干货”置于视觉中心，让数据直接服务于工程师和采购经理的决策 。

**材质映射美学 (Material Mapping)**：将品牌色直接映射到产品材质（红铜色、黄铜色），减少认知成本，通过颜色引导用户快速锁定产品大类 。

### 2. 视觉元素规范 (Visual Elements)

* **品牌色彩系统 (Color System)**：
* 

**主色 (Primary)**： `#0B3570` (深海蓝)。应用于 Header、Footer、Hero 区域背景，奠定稳重、专业的工业基调 。

**行动色 (Action)**： `#F97C30` (红铜色)。专门用于 “Request a Quote” 按钮、电话链接及核心交互点，利用高对比度驱动转化 。

**点缀色 (Accent)**： `#F4BD5D` (黄铜金)。应用于表格底边框、Icon 线条、关键高亮标签，体现金属质感 。

**背景层级 (Background)**： 纯白 (`#FFFFFF`) 内容区配合工业浅灰 (`#F2F4F7`) 的模块底色，形成清晰的物理分割感 。

* **字体层级 (Typography)**：
* 
* **Global Inheritance (全局继承)**： 字体家族 (Font Family)、字号 (Size)、字重 (Weight) 统一由 **GeneratePress 主题设置** 控制，Tailwind 不再强制覆盖 H1-H6 的基础样式，确保与 CMS 全局排版一致 。
* **Color Consistency (色彩统一)**： 所有自定义模块中的标题 (Heading) 元素，必须添加 `text-heading` 类，以继承设计系统的标准深灰色 (`#1F2937`) 。
* **Natural Text (自然呼吸)**： **严禁使用 `uppercase` 和 `tracking-widest`**。保持字体的原生呼吸感，体现工业设计的真实与直接。
*
```javascript
  // tailwind.config.js
  fontFamily: {
    sans: ["Geist", "Geist Fallback", "system-ui", "-apple-system", "sans-serif"], // 正文/标题
    mono: ["Geist Mono", "Geist Mono Fallback", "monospace"], // 牌号/参数
  },
  colors: {
    heading: "#1F2937", // 强制用于所有自定义模块标题
  }
```

* **几何规范 (Geometry)**：

**微圆角 (Micro-Radius)**： 容器和卡片统一使用 `rounded-sm (2px)` 或 `rounded (4px)` 。**严禁使用 12px 以上的大圆角**，以保持金属切割般的硬朗轮廓 。

**斑马纹逻辑 (Zebra Striping)**： 数据表格采用 `even:bg-gray-50` 策略，确保长表单阅读时视线不产生漂移 。

**统一垂直间距 (Uniform Vertical Rhythm)**：
* **Top Padding**: 所有独立内容区块 (Section) 的顶部内边距 (Padding-Top) 必须锁定为 **100px** (对应 Tailwind class `pt-[100px]`)。
* **目的**: 消除不同模块拼接时的视觉跳跃感，建立稳定、专业的阅读节奏 (Visual Consistency) 。

**交互反馈 (Interaction Feedback)**：
* **激活态**: 必须使用 **2px** 的 `#F97C30` (Action 色) 边框或背景反馈。例如：`hover:border-2 hover:border-action-copper`。


### 3. 布局与信息流 (Layout & Logic)

* **嵌入式控制台 (Embedded Console)**：
* 首页首屏 (Hero Section) 不再使用纯装饰大图，而是直接嵌入“库存查找器 (Stock Finder)”。将交互路径前置，模拟“云端工厂操作台”的即时性 。
* **底部标签化展示 (Bottom-Labeling)**：
* 产品卡片采用“图片+底部物理标签”模式（如：图片底部的“Cu > 99.9%”黑条）。这种布局模仿仓库货架上的标签卡，实现“一秒识别材质” 。
* **高密度信息矩阵 (High-Density Specs)**：
* 详情页采用 Tab 切换（规格、化学成分、机械性能），在最小的视口内承载最大的技术信息量，减少页面跳转 。

### 4. 交互反馈 (Interaction)

* **深色遮罩增强 (Dark Overlay)**：
* Hero 区域图片通过深蓝遮罩处理，确保白色文字和橙色 CTA 按钮在任何背景图下均保持物理级的清晰度 。
* **状态锚点指示 (Status Anchors)**：
* 在复杂的参数表格中，鼠标悬停行需呈现 `bg-gold-light` 反馈，模拟扫描仪定位感，增强用户在海量数据中的控制力 。

### 5. 响应式策略 (Responsive Strategy)

* **移动端缩减原则 (Condense on Mobile)**：
* 手机端自动将横向的“库存查找器”折叠为垂直堆叠模式，并优化数据表格为横向滚动，确保在窄屏下参数依然完整且易读 。
* **触控友好型 CTA**：
* 底部移动端常驻“快速询盘”悬浮条，使用 `bg-action` (红铜色)，确保转化漏斗在触屏设备上始终开启 。
