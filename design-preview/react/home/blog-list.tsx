import Link from 'next/link';

export default function BlogList() {
  const blogPosts = [
    {
      id: 1,
      category: 'TECHNICAL',
      title: 'Understanding Copper Alloy Classifications: C10100 vs C11000',
      excerpt: 'A comprehensive guide to selecting the right copper grade for electrical applications, comparing purity levels and conductivity specifications.',
      date: '2026-01-15',
      readTime: '6 min',
      author: 'Technical Team',
      authorRole: 'Material Specialist',
      authorImage: 'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      image: 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80',
      tags: ['Specifications', 'Material Science']
    },
    {
      id: 2,
      category: 'INDUSTRY',
      title: 'Aerospace Grade Bronze: Meeting AS9100D Standards',
      excerpt: 'How our manufacturing processes ensure compliance with aerospace industry requirements for bronze components in critical applications.',
      date: '2026-01-10',
      readTime: '8 min',
      author: 'Quality Assurance',
      authorRole: 'Compliance Manager',
      authorImage: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      image: 'https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80',
      tags: ['Aerospace', 'Certification']
    },
    {
      id: 3,
      category: 'APPLICATION',
      title: 'Marine Environment Corrosion Resistance: Naval Brass Solutions',
      excerpt: 'Exploring C46400 naval brass performance in saltwater environments and best practices for marine component manufacturing.',
      date: '2026-01-05',
      readTime: '5 min',
      author: 'Engineering Dept',
      authorRole: 'Lead Engineer',
      authorImage: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
      image: 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80',
      tags: ['Marine', 'Corrosion']
    },
  ];

  return (
    <section className="bg-[#F2F4F7] py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Centered Header */}
        <div className="mb-16 text-center">
          <p className="mb-2 font-mono text-sm font-semibold uppercase tracking-wider text-[#F97C30]">
            KNOWLEDGE BASE
          </p>
          <h2 className="text-balance text-3xl font-bold text-[#1F2937] md:text-4xl lg:text-5xl">
            Technical Resources & Insights
          </h2>
          <p className="mx-auto mt-4 max-w-2xl text-lg text-[#6B7280]">
            Learn how to leverage copper alloys and advanced manufacturing techniques for your applications.
          </p>
        </div>

        {/* Blog Grid - 3 Columns */}
        <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
          {blogPosts.map((post) => (
            <article
              key={post.id}
              className="group flex flex-col overflow-hidden rounded-sm border border-[#E5E7EB] bg-white transition-all hover:border-[#0B3570] hover:shadow-xl"
            >
              {/* Featured Image */}
              <div className="relative h-56 w-full overflow-hidden bg-gray-200">
                <img
                  src={post.image || "/placeholder.svg"}
                  alt={post.title}
                  className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                />
                <div className="absolute inset-0 ring-1 ring-inset ring-[#0B3570]/5" />
              </div>

              {/* Content - Grows to fill space */}
              <div className="flex flex-1 flex-col justify-between p-6">
                {/* Meta Info */}
                <div>
                  <div className="mb-3 flex items-center gap-3">
                    <time className="font-mono text-xs font-semibold text-[#0B3570]">
                      {new Date(post.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                    </time>
                    <span className="rounded-full bg-[#0B3570] px-3 py-1 font-mono text-xs font-semibold text-white">
                      {post.category}
                    </span>
                  </div>

                  {/* Title */}
                  <h3 className="mb-3 text-xl font-bold leading-snug text-[#1F2937] transition-colors group-hover:text-[#0B3570]">
                    {post.title}
                  </h3>

                  {/* Excerpt */}
                  <p className="line-clamp-3 text-[#6B7280]">
                    {post.excerpt}
                  </p>
                </div>

                {/* Author Info - Bottom */}
                <div className="mt-6 border-t border-[#E5E7EB] pt-4">
                  <div className="flex items-center gap-3">
                    <img
                      src={post.authorImage || "/placeholder.svg"}
                      alt={post.author}
                      className="h-10 w-10 rounded-full object-cover"
                    />
                    <div>
                      <p className="font-semibold text-[#1F2937]">{post.author}</p>
                      <p className="text-xs text-[#6B7280]">{post.authorRole}</p>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          ))}
        </div>

        {/* View All Button */}
        <div className="mt-12 text-center">
          <Link
            href="/blog"
            className="inline-block rounded-sm border-2 border-[#0B3570] px-8 py-3 font-mono text-sm font-semibold text-[#0B3570] transition-colors hover:bg-[#0B3570] hover:text-white"
          >
            VIEW ALL ARTICLES →
          </Link>
        </div>
      </div>
    </section>
  );
}
