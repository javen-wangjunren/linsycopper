# AI Prompt: 为已有产品批量补充 FAQ 内容

> 使用 "Export Minimal (ID + Title)" 导出，只包含 `post_id` 和 `post_title`，AI 只添加 `faq` 字段，导入时只写 FAQ，其他字段不受影响。

---

## Prompt 模板

```markdown
## 角色
你是一位铜材行业（Copper Manufacturing）的产品文案专家，熟悉 ASTM 标准、铜合金牌号、工业应用场景。你服务于 Linsy Copper，一家面向欧美市场的铜材制造商。

## 任务
以下是一个产品 JSON 数组，每个对象目前只有 `post_id` 和 `post_title`。请为每个产品添加 `faq` 字段，除此之外不要做任何修改。

## 输入格式
```json
[
  {"post_id": 123, "post_title": "Copper Sheet C11000"},
  {"post_id": 124, "post_title": "Copper Bar C12200"}
]
```

## 你需要做的事
为每个产品添加 `faq` 字段，结构如下：

```json
{
  "post_id": 123,
  "post_title": "Copper Sheet C11000",
  "faq": {
    "title": "Frequently Asked Questions",
    "description": "Find answers to common questions about C11000 copper sheet specifications, ordering, and applications.",
    "list": [
      {
        "question": "...",
        "answer": "..."
      }
    ]
  }
}
```

## 要求

### 数量
- 每个产品恰好 4-5 个 FAQ

### 内容质量
1. **语言**：全英文，专业但易懂，面向工程师和采购人员
2. **问题要具体**：根据产品名称（post_title）中的牌号、类型、形态来提问，不要泛泛而问
3. **答案要有信息量**：引用该产品牌号的实际标准、性能数据、典型应用
4. **常见 FAQ 方向**（根据产品名称选择 4-5 个方向）：
   - 产品规格/标准（如：符合哪个 ASTM 标准？）
   - 材料性能（如：导电率？耐腐蚀性？机械性能？）
   - 应用场景（如：适合哪些行业？）
   - 加工/焊接（如：能否焊接？可加工性如何？）
   - 供货/交期（如：标准交期？起订量？）
   - 认证/合规（如：RoHS？REACH？是否有 MTR 报告？）
   - 与其他牌号对比（如：C11000 vs C12200 区别？）

### 格式要求
1. **严格 JSON**：不要 Markdown 代码块标记，不要解释文字
2. **只添加 `faq` 字段**：`post_id` 和 `post_title` 原样保留，不做任何修改
3. 只输出完整的 JSON 数组

## 输出示例

```json
[
  {
    "post_id": 123,
    "post_title": "Copper Sheet C11000",
    "faq": {
      "title": "Frequently Asked Questions",
      "description": "Find answers to common questions about C11000 copper sheet specifications, ordering, and applications.",
      "list": [
        {
          "question": "What is the difference between C11000 and C12200 copper?",
          "answer": "C11000 is electrolytic tough pitch (ETP) copper with >99.9% purity, while C12200 is phosphorus deoxidized copper (DHP) with slightly lower conductivity but better welding properties. C11000 is preferred for electrical applications, C12200 for plumbing and heat exchangers."
        },
        {
          "question": "What thickness range is available for C11000 copper sheet?",
          "answer": "Standard thickness ranges from 0.5mm to 12mm. Custom thicknesses outside this range can be produced upon request with minimum order quantities. Thinner gauges (0.1 - 0.5mm) are available as copper foil."
        },
        {
          "question": "Can C11000 copper sheet be used in marine environments?",
          "answer": "Yes, C11000 offers excellent corrosion resistance in marine and atmospheric environments. However, for prolonged saltwater exposure, we recommend protective coatings or considering C70600 (90-10 Cu-Ni) for superior seawater resistance."
        },
        {
          "question": "What is the typical lead time for C11000 copper sheet orders?",
          "answer": "Standard stock items ship within 3-5 business days. Custom sizes and large volume orders (10+ tons) typically require 2-3 weeks for production. We also maintain emergency stock for urgent requirements."
        },
        {
          "question": "Is C11000 copper sheet RoHS and REACH compliant?",
          "answer": "Yes, our C11000 copper sheet fully complies with RoHS Directive 2011/65/EU and REACH Regulation (EC) No 1907/2006. Full material certification and mill test reports are provided with every order."
        }
      ]
    }
  }
]
```

## 注意
- 只输出 JSON，不要任何其他文字
- 确保 `post_id` 原样保留
- FAQ 问题要基于该产品的牌号/类型，不要编造不存在的特性
- 只添加 `faq` 字段，不要添加其他任何字段
```

---

## 使用流程

1. **导出**：Tools > Product Import → 点击 **"Export Minimal (ID + Title)"** → 下载 JSON
2. **发给 AI**：将上面 Prompt + 导出的 JSON 一起发给 AI
3. **AI 返回**：收到只包含 `post_id` + `post_title` + `faq` 的 JSON 数组
4. **导入**：Tools > Product Import → 上传 JSON → 勾选 **"Update existing products"** → 点击 Upload & Import
   - 系统按 `post_id` 匹配已有产品
   - JSON 中只有 `faq` 字段，所以只写入 FAQ，其他字段完全不受影响