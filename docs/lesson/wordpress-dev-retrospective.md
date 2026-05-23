# WordPress 开发复盘与标准化流程指南

**适用技术栈：ACF + Tailwind + Theme 开发**

---

## 一、核心问题总结（本质不是技术，是流程）

本次开发的根本问题：

👉 **没有建立“模块渲染闭环”，就批量生产模块**

### 实际开发顺序（错误）

```
设计稿
→ AI生成字段
→ 注册 block
→ 写 render
→ 写 template
→ 批量模块
→ 最后测试
```

本质：先建工厂，再造第一件产品。

---

### 正确开发顺序（必须遵守）

```
设计稿
→ 单模块最小闭环
→ 测试验证
→ 固化规范
→ 再批量生产
```

---

## 二、工程问题分类（抽象层面）

### 1️⃣ Shopify 组件化思维误用

错误认知：

> WordPress = 页面组件系统

真实情况：

> WordPress = 模板驱动 CMS

Block 是 UI 单元，不是页面架构单元。

---

### 2️⃣ 没有最小可运行模块（MVP Module）

任何模块必须满足：

* 后端字段存在
* 可输入数据
* 可渲染
* 有样式
* 在真实页面展示

必须在真实页面测试，而不是仅编辑器预览。

---

### 3️⃣ 数据架构后置（严重问题）

错误方式：

```
UI → 字段设计
```

正确方式：

```
内容模型 → 字段设计 → UI呈现
```

否则必然出现：

* 字段冗余
* clone 冲突
* prefix 修补
* 数据复用困难

---

### 4️⃣ 多源 CSS 冲突

同时存在：

* 主题 CSS
* Tailwind utilities
* 运行时工具
* 未编译 CSS
* 自定义 CSS

工程上称为：

👉 多权威样式系统冲突

必须保证：

> 单一权威样式来源

---

### 5️⃣ 没有 Layout Contract（布局契约）

模块开发前必须定义：

* spacing scale
* container width
* section padding
* background system
* grid system
* breakpoint

否则页面必然拼贴感严重。

---

### 6️⃣ 渲染层级混乱

原生层：

```
theme template
block render
acf field
```

自定义层：

```
custom render caller
prefix mapping
clone resolution
```

层级过多 → 维护性极差。

---

## 三、标准开发流程（工业级 SOP）

---

### STEP 1 — 建立设计系统（优先级最高）

必须先定义：

* container width
* spacing scale
* color tokens
* typography scale
* grid rules
* breakpoints

写入：

```
tailwind.config.js
```

这是唯一视觉规则。

---

### STEP 2 — 内容模型设计（不是字段）

先定义页面内容实体：

示例：

```
hero
feature list
testimonial
capability
cta
```

然后定义：

每个实体最小数据结构。

不是 UI 控件。

---

### STEP 3 — 单模块 MVP（强制流程）

严格顺序：

```
1 创建字段
2 写 render
3 写样式
4 放入真实 template
5 输入真实数据
6 前端验证
```

通过后才能进入模块库。

---

### STEP 4 — 模块结构标准化

推荐目录结构：

```
blocks/
  hero/
    fields.json
    render.php
    style.css
```

统一接口：

```
render_block($data)
```

---

### STEP 5 — 模板职责单一

Template 只负责：

```
页面结构
模块顺序
```

禁止：

```
字段逻辑
样式逻辑
复杂计算
```

---

### STEP 6 — CSS 单一来源原则

必须保证：

```
Tailwind compiled CSS
```

是唯一布局控制来源。

主题只负责：

```
reset
base typography
```

---

### STEP 7 — Spacing Contract（必须文档化）

示例：

```
section: py-20
container: max-w-7xl mx-auto
module gap: 8
```

模块禁止自定义 spacing。

---

## 四、推荐页面构建架构

推荐：

```
ACF Flexible Content
```

结构：

```
page_builder
   hero
   feature
   testimonial
```

模板：

```
while have_rows
   include render file
```

避免：

* block 注册系统
* clone prefix 复杂映射
* 自定义 render 调度器

---

## 五、黄金开发顺序（必须固定）

```
1 设计系统
2 内容模型
3 页面线框（仅布局）
4 单模块 MVP
5 模块库建设
6 页面组装
7 内容填充
8 全站 spacing 调整
9 性能优化
10 代码重构
```

---

## 六、必须建立的项目文档

每个项目必须包含：

```
目录结构说明
数据流图
模块开发规范
CSS规则
命名规范
render流程
template职责
spacing系统
```

否则无法复用架构。

---

## 七、模块开发最小闭环 Checklist

```
[ ] 字段定义合理
[ ] 数据可输入
[ ] render 正确
[ ] Tailwind 样式生效
[ ] container 正确
[ ] spacing 合规
[ ] 移动端正常
[ ] 真实页面测试
```

全部通过才能进入模块库。

---

## 八、架构设计原则（长期遵守）

### SOC — 单一职责

一个文件只做一件事。

### DRY — 不重复

公共逻辑必须抽象。

### Data First

数据结构优先于 UI。

### Layout Contract

布局规则优先于组件自由度。

### Single Style Authority

单一 CSS 控制源。

---

## 九、推荐项目目录结构（简化版）

```
theme/
 ├ setup/
 ├ templates/
 ├ blocks/
 │   ├ hero/
 │   ├ feature/
 ├ inc/
 │   ├ helpers/
 │   ├ render/
 ├ assets/
 │   ├ css/
 │   ├ js/
```

---

## 十、长期优化目标（成熟工程）

* 模块生成脚本
* 设计 token 自动同步
* render helper 抽象
* spacing 自动校验
* 组件文档系统
* 预览系统

---

## 十一、最重要的工程原则

```
先让一个模块完美运行
再复制
永远不要批量开发未验证模块
```

---

## 文档结束

---
