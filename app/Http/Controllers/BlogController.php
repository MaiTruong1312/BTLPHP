<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the published blog posts.
     */
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        // Mảng bài viết mẫu tĩnh
        $samplePosts = [
            'how-to-perfect-job-search-tips' => [
                'title' => 'How to Perfect Your Job Search: 10 Essential Tips',
                'author' => 'JobPortal Team',
                'date' => 'December 04, 2024',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">10 Essential Tips for a Successful Job Search</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">Finding the right job can be challenging in today\'s competitive market. Whether you\'re a recent graduate or an experienced professional, a strategic approach can significantly improve your chances of landing your dream role.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">1. Customize Your Resume and Cover Letter</h3>
                    <p class="text-gray-700 leading-relaxed">Don\'t send the same resume to every employer. Tailor your application to match the job description and company culture. Highlight relevant skills and experiences that align with the position.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">2. Optimize Your Online Presence</h3>
                    <p class="text-gray-700 leading-relaxed">Your LinkedIn profile is often the first impression you make on recruiters. Keep it up-to-date, professional, and complete with a high-quality photo and compelling headline.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">3. Network Effectively</h3>
                    <p class="text-gray-700 leading-relaxed">Build relationships with professionals in your industry. Attend networking events, join professional associations, and reach out to contacts. Many jobs are filled through referrals before they\'re posted publicly.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">4. Research Companies Thoroughly</h3>
                    <p class="text-gray-700 leading-relaxed">Before applying, understand the company\'s mission, culture, and recent achievements. This knowledge will help you tailor your application and prepare for interviews.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">5. Use Job Search Platforms Strategically</h3>
                    <p class="text-gray-700 leading-relaxed">Use multiple job boards and set up alerts for positions that match your criteria. Consider using specialized platforms for your industry.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">6. Prepare for Interviews</h3>
                    <p class="text-gray-700 leading-relaxed">Practice common interview questions, research the company, and prepare thoughtful questions to ask. Mock interviews with friends can help build confidence.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">7. Follow Up Consistently</h3>
                    <p class="text-gray-700 leading-relaxed">After applying, follow up after one week if you haven\'t heard back. Send thank-you notes after interviews within 24 hours.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">8. Develop Your Skills</h3>
                    <p class="text-gray-700 leading-relaxed">Take online courses, certifications, or workshops to improve your qualifications. Many companies value candidates who show a commitment to continuous learning.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">9. Track Your Applications</h3>
                    <p class="text-gray-700 leading-relaxed">Keep detailed records of the positions you\'ve applied to, including dates and contact information. This helps you stay organized and follow up effectively.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">10. Stay Positive and Persistent</h3>
                    <p class="text-gray-700 leading-relaxed">Job searching can take time. Maintain a positive attitude, celebrate small wins, and remember that rejection is a normal part of the process.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">Remember, successful job hunting is about quality over quantity. Focus on finding roles that genuinely interest you and where you can add real value.</p>
                </div>
                </div>'
            ],
            'top-tech-trends-2024' => [
                'title' => 'Top Technology Trends Transforming Hiring in 2024',
                'author' => 'HR Expert',
                'date' => 'December 02, 2024',
                'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">How Technology is Reshaping Recruitment</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">The hiring landscape is undergoing a dramatic transformation driven by cutting-edge technologies. Companies are adopting innovative solutions to streamline recruitment, improve candidate experience, and make better hiring decisions.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Artificial Intelligence in Recruitment</h3>
                    <p class="text-gray-700 leading-relaxed">AI-powered tools are revolutionizing resume screening, candidate matching, and initial assessments. These systems can analyze thousands of applications in seconds, identifying the most qualified candidates based on predefined criteria.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Video Interviewing Platforms</h3>
                    <p class="text-gray-700 leading-relaxed">Remote and asynchronous video interviews have become mainstream. These platforms save time for both employers and candidates, while providing deeper insights into candidate communication skills.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Skills-Based Hiring</h3>
                    <p class="text-gray-700 leading-relaxed">Companies are shifting focus from credentials to skills. Platforms that assess practical abilities are gaining popularity, enabling companies to hire based on what candidates can actually do.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Talent Analytics</h3>
                    <p class="text-gray-700 leading-relaxed">Data-driven recruitment is becoming standard. Predictive analytics help identify which candidates are likely to succeed and stay with the company long-term.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Virtual Reality for Training</h3>
                    <p class="text-gray-700 leading-relaxed">Some forward-thinking companies are using VR to conduct immersive interviews and assess how candidates perform in realistic work scenarios.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">The Human Touch Remains Essential</h3>
                    <p class="text-gray-700 leading-relaxed">While technology is transforming hiring, the human element remains crucial. The best recruitment strategies balance automation with personal connection, ensuring candidates feel valued throughout the process.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">Technology is a tool to enhance recruitment, not replace human judgment and connection.</p>
                </div>
                </div>'
            ],
            'how-to-build-winning-resume' => [
                'title' => 'How to Build a Winning Resume That Stands Out',
                'author' => 'Resume Expert',
                'date' => 'November 28, 2024',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Crafting a Resume That Gets Results</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">Your resume is your marketing document. It has just a few seconds to capture a recruiter\'s attention and convince them to move you forward in the hiring process. Here\'s how to make it count.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Keep It Concise</h3>
                    <p class="text-gray-700 leading-relaxed">Most recruiters spend less than 10 seconds on initial resume reviews. Keep your resume to one or two pages, using clear formatting and bullet points for easy scanning.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Use a Strong Format</h3>
                    <p class="text-gray-700 leading-relaxed">Choose a clean, professional format that\'s easy to read. Use consistent fonts and spacing. Your resume should be visually appealing and well-organized.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Lead with Your Accomplishments</h3>
                    <p class="text-gray-700 leading-relaxed">Don\'t just list responsibilities. Highlight achievements and quantifiable results. Instead of "Responsible for sales," write "Increased quarterly sales by 25%, exceeding targets by $500K."</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Optimize for Keywords</h3>
                    <p class="text-gray-700 leading-relaxed">Many companies use applicant tracking systems (ATS) to screen resumes. Include relevant keywords from the job description naturally throughout your resume.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Tailor for Each Position</h3>
                    <p class="text-gray-700 leading-relaxed">Customize your resume for each application. Highlight the experiences and skills most relevant to the specific role.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Include a Professional Summary</h3>
                    <p class="text-gray-700 leading-relaxed">Start with a brief professional summary that highlights your key strengths and career objectives. This gives recruiters immediate context about your candidacy.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">A well-crafted resume is an investment in your career. Take time to make it polished, targeted, and impactful.</p>
                </div>
                </div>'
            ],
            'negotiating-salary-like-pro' => [
                'title' => 'Negotiating Your Salary Like a Pro: Complete Guide',
                'author' => 'Salary Coach',
                'date' => 'November 25, 2024',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Master the Art of Salary Negotiation</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">Negotiating your salary is one of the most important conversations of your career. Yet many professionals feel uncomfortable discussing compensation. Here\'s how to approach it strategically and confidently.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Do Your Research</h3>
                    <p class="text-gray-700 leading-relaxed">Before negotiating, research average salaries for your position, industry, and location using resources like Glassdoor, PayScale, and LinkedIn Salary. This gives you concrete data to support your negotiation.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Know Your Worth</h3>
                    <p class="text-gray-700 leading-relaxed">Calculate your market value based on your experience, skills, education, and track record. Be realistic but confident about what you bring to the table.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Negotiate the Whole Package</h3>
                    <p class="text-gray-700 leading-relaxed">Don\'t just focus on base salary. Consider benefits, bonuses, stock options, flexible work arrangements, professional development, and vacation time.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Practice Your Pitch</h3>
                    <p class="text-gray-700 leading-relaxed">Prepare talking points about your accomplishments, skills, and value. Practice delivering them confidently without sounding rehearsed.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Let Them Make the First Offer</h3>
                    <p class="text-gray-700 leading-relaxed">Whenever possible, let the employer make the first offer. If pressed, provide a salary range rather than a specific number.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Listen More Than You Talk</h3>
                    <p class="text-gray-700 leading-relaxed">Pay attention to their concerns and constraints. Understanding their perspective helps you find creative solutions that work for both parties.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Don\'t Accept Immediately</h3>
                    <p class="text-gray-700 leading-relaxed">Even if the offer is good, ask for time to consider it. This shows professionalism and gives you time to verify all details.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Get It in Writing</h3>
                    <p class="text-gray-700 leading-relaxed">Once you reach an agreement, ensure all details are documented in writing, including salary, benefits, start date, and any special arrangements.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">Effective salary negotiation is not about being demanding—it\'s about ensuring fair compensation for your value.</p>
                </div>
                </div>'
            ],
            'mastering-linkedin-career-success' => [
                'title' => 'Mastering LinkedIn for Career Success: Professional Guide',
                'author' => 'Social Media Strategist',
                'date' => 'November 22, 2024',
                'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Your Complete LinkedIn Strategy</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">LinkedIn is the world\'s largest professional network with over 900 million members. If you\'re serious about career growth, you need a strong LinkedIn presence. Here\'s your comprehensive guide.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Optimize Your Profile Picture</h3>
                    <p class="text-gray-700 leading-relaxed">Use a clear, professional headshot. Your profile picture is the first thing people see. Choose a photo with good lighting, neutral background, and a genuine smile.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Craft a Compelling Headline</h3>
                    <p class="text-gray-700 leading-relaxed">Your headline appears prominently and should clearly communicate your value. Instead of just \"Marketing Manager,\" try \"Marketing Manager | Digital Strategy & Growth | B2B SaaS Expert.\"</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Write a Standout Summary</h3>
                    <p class="text-gray-700 leading-relaxed">Use the About section to tell your professional story. Highlight your achievements, skills, and what you\'re passionate about. Include keywords for searchability.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Detail Your Experience</h3>
                    <p class="text-gray-700 leading-relaxed">Don\'t just list job titles. Describe accomplishments and impacts. Use bullet points and include metrics where possible.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Showcase Your Skills</h3>
                    <p class="text-gray-700 leading-relaxed">Add relevant skills to your profile and encourage colleagues to endorse them. This increases your visibility in searches.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Build Your Network Strategically</h3>
                    <p class="text-gray-700 leading-relaxed">Connect with colleagues, industry peers, and professionals in your target companies. Personalize connection requests with a brief message.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Engage With Content</h3>
                    <p class="text-gray-700 leading-relaxed">Comment thoughtfully on posts, share industry insights, and participate in relevant discussions. This increases your visibility and establishes expertise.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Share Your Knowledge</h3>
                    <p class="text-gray-700 leading-relaxed">Post original content, articles, and insights regularly. This positions you as a thought leader in your field and attracts recruiters and connections.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">LinkedIn success requires consistent effort and authentic engagement, not self-promotion alone.</p>
                </div>
                </div>'
            ],
            'remote-work-benefits-best-practices' => [
                'title' => 'Remote Work: Benefits and Best Practices for Success',
                'author' => 'Work Culture Expert',
                'date' => 'November 20, 2024',
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'content' => '<div class="space-y-8">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Thriving in a Remote Work Environment</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">Remote work has evolved from a temporary solution to a permanent fixture in many industries. Whether you\'re new to working from home or looking to optimize your remote work setup, this guide will help you succeed.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Create a Dedicated Workspace</h3>
                    <p class="text-gray-700 leading-relaxed">Establish a professional workspace at home. This helps you maintain productivity and creates a psychological boundary between work and personal life.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Establish a Routine</h3>
                    <p class="text-gray-700 leading-relaxed">Work from home doesn\'t mean working in pajamas all day. Get dressed, maintain regular work hours, and follow a structured routine to stay productive and focused.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Master Communication Tools</h3>
                    <p class="text-gray-700 leading-relaxed">Become proficient with your company\'s communication platforms. Clear communication is crucial in remote settings to prevent misunderstandings.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Take Regular Breaks</h3>
                    <p class="text-gray-700 leading-relaxed">When your home is your office, it\'s easy to work without breaks. Step away from your desk regularly to rest your eyes and recharge.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Maintain Work-Life Balance</h3>
                    <p class="text-gray-700 leading-relaxed">Set clear boundaries between work and personal time. When 5 PM comes, log off and enjoy your personal time. This prevents burnout.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Stay Connected with Colleagues</h3>
                    <p class="text-gray-700 leading-relaxed">Make an effort to build relationships with your remote team. Schedule virtual coffee chats, participate in team activities, and stay engaged with company culture.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Invest in the Right Equipment</h3>
                    <p class="text-gray-700 leading-relaxed">A good ergonomic chair, monitor, and keyboard are worth the investment. Proper equipment reduces fatigue and improves productivity.</p>
                </div>
                
                <div>
                    <h3 class="text-2xl font-bold text-indigo-600 mb-3">Manage Distractions</h3>
                    <p class="text-gray-700 leading-relaxed">Use website blockers, silence notifications during focus time, and communicate your working hours to family members to minimize interruptions.</p>
                </div>
                
                <div class="bg-indigo-50 border-l-4 border-indigo-600 p-6 rounded">
                    <p class="text-gray-800 font-semibold">Remote work success is about creating the right environment and discipline—both physical and mental.</p>
                </div>
                </div>'
            ]
        ];

        // Kiểm tra xem slug có tồn tại trong bài viết mẫu không
        if (isset($samplePosts[$slug])) {
            $post = $samplePosts[$slug];
            return view('blog.show', [
                'title' => $post['title'],
                'author' => $post['author'],
                'date' => $post['date'],
                'icon' => $post['icon'],
                'content' => $post['content']
            ]);
        }

        // Nếu không, cố gắng lấy từ database
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for creating a new blog post.
     * This would typically be for employers or admins.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('blog.create');
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'image' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
    // 2. Kiểm tra xem có tệp hình ảnh được tải lên không
        if ($request->hasFile('image')) {
        // Lưu hình ảnh vào thư mục 'storage/app/public/posts'
        // và lấy đường dẫn tương đối
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        $post = new Post($validated);
        $post->slug = Str::slug($validated['title']);
        $post->user_id = Auth::id();
        $post->save();
        $post->image = $imagePath;
        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('blog.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'image' =>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post->update($validated);
        $post->slug = Str::slug($validated['title']);
        $post->save();

        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('blog.index');
    }
}
