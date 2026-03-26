<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Attendee;
use App\Models\Order;
use App\Models\Speaker;
use App\Models\Schedule;
use App\Models\Sponsor;
use App\Models\Exhibitor;
use App\Models\Paper;
use App\Models\PaperReview;
use App\Models\Survey;
use App\Models\AccessCode;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Event 1: Tech Conference ──────────────────────────────────
        $event1 = Event::create([
            'name'        => 'TechSummit 2025',
            'slug'        => 'techsummit-2025',
            'description' => 'The premier technology conference bringing together developers, designers and innovators from around the world.',
            'start_date'  => '2025-09-15 09:00:00',
            'end_date'    => '2025-09-17 18:00:00',
            'venue'       => 'Silicon Valley Convention Center',
            'location'    => 'San Jose, California, USA',
            'timezone'    => 'America/Los_Angeles',
            'capacity'    => 2000,
            'category'    => 'Technology',
            'status'      => 'published',
            'is_virtual'  => false,
            'website_hero_title'    => 'TechSummit 2025',
            'website_hero_subtitle' => 'Where Innovation Meets Inspiration',
            'website_primary_color' => '#6366f1',
            'created_by'  => 'admin@eventpro.com',
        ]);

        // Event 1 Tickets
        $t1 = Ticket::create(['event_id'=>$event1->id,'name'=>'Early Bird General','price'=>199,'quantity'=>500,'ticket_type'=>'paid','is_visible'=>true]);
        $t2 = Ticket::create(['event_id'=>$event1->id,'name'=>'VIP All-Access','price'=>599,'quantity'=>100,'ticket_type'=>'paid','is_visible'=>true]);
        $t3 = Ticket::create(['event_id'=>$event1->id,'name'=>'Student Pass','price'=>49,'quantity'=>200,'ticket_type'=>'paid','is_visible'=>true]);
        $t4 = Ticket::create(['event_id'=>$event1->id,'name'=>'Speaker Pass','price'=>0,'quantity'=>50,'ticket_type'=>'free','is_visible'=>false]);

        // Event 1 Speakers
        $sp1 = Speaker::create(['event_id'=>$event1->id,'first_name'=>'Sarah','last_name'=>'Chen','email'=>'sarah@techco.com','bio'=>'CTO at TechCorp, 15 years building scalable systems.','organization'=>'TechCorp','job_title'=>'Chief Technology Officer','is_featured'=>true]);
        $sp2 = Speaker::create(['event_id'=>$event1->id,'first_name'=>'Marcus','last_name'=>'Williams','email'=>'marcus@ailab.io','bio'=>'AI researcher and author of three books on machine learning.','organization'=>'AI Lab','job_title'=>'Head of AI Research','is_featured'=>true]);
        $sp3 = Speaker::create(['event_id'=>$event1->id,'first_name'=>'Priya','last_name'=>'Patel','email'=>'priya@cloudco.com','bio'=>'Cloud infrastructure expert, Google Cloud Champion.','organization'=>'CloudCo','job_title'=>'Principal Cloud Architect','is_featured'=>true]);
        $sp4 = Speaker::create(['event_id'=>$event1->id,'first_name'=>'James','last_name'=>'Rodriguez','email'=>'james@startup.io','bio'=>'Serial entrepreneur, 3 successful exits.','organization'=>'StartupIO','job_title'=>'CEO & Founder','is_featured'=>false]);

        // Event 1 Schedules
        Schedule::create(['event_id'=>$event1->id,'title'=>'Opening Keynote: The Future of AI','description'=>'Exploring how AI will transform every industry in the next decade.','start_time'=>'2025-09-15 09:00:00','end_time'=>'2025-09-15 10:30:00','room'=>'Main Hall','track'=>'Keynote','session_type'=>'keynote','speaker_id'=>$sp2->id,'is_public'=>true]);
        Schedule::create(['event_id'=>$event1->id,'title'=>'Building Cloud-Native Applications','description'=>'Deep dive into microservices, containers and serverless architectures.','start_time'=>'2025-09-15 11:00:00','end_time'=>'2025-09-15 12:00:00','room'=>'Room A','track'=>'Cloud','session_type'=>'talk','speaker_id'=>$sp3->id,'is_public'=>true]);
        Schedule::create(['event_id'=>$event1->id,'title'=>'Lunch Break & Networking','start_time'=>'2025-09-15 12:00:00','end_time'=>'2025-09-15 13:30:00','room'=>'Atrium','session_type'=>'break','is_public'=>true]);
        Schedule::create(['event_id'=>$event1->id,'title'=>'Startup Pitch Workshop','description'=>'Interactive session on crafting and delivering winning pitches.','start_time'=>'2025-09-15 14:00:00','end_time'=>'2025-09-15 16:00:00','room'=>'Workshop Room B','track'=>'Entrepreneurship','session_type'=>'workshop','speaker_id'=>$sp4->id,'is_public'=>true,'capacity'=>50]);
        Schedule::create(['event_id'=>$event1->id,'title'=>'Scaling Systems to Millions','start_time'=>'2025-09-16 09:00:00','end_time'=>'2025-09-16 10:00:00','room'=>'Room A','track'=>'Engineering','session_type'=>'talk','speaker_id'=>$sp1->id,'is_public'=>true]);

        // Event 1 Sponsors
        Sponsor::create(['event_id'=>$event1->id,'name'=>'MegaCorp Technologies','tier'=>'platinum','website'=>'https://megacorp.example.com','description'=>'Global leader in enterprise software solutions.']);
        Sponsor::create(['event_id'=>$event1->id,'name'=>'CloudHost Pro','tier'=>'gold','website'=>'https://cloudhost.example.com']);
        Sponsor::create(['event_id'=>$event1->id,'name'=>'DevTools Inc','tier'=>'silver','website'=>'https://devtools.example.com']);
        Sponsor::create(['event_id'=>$event1->id,'name'=>'StartupFund VC','tier'=>'bronze']);

        // Event 1 Exhibitors
        Exhibitor::create(['event_id'=>$event1->id,'company_name'=>'AI Solutions Ltd','booth_number'=>'A01','description'=>'AI-powered business tools.','booth_size'=>'large']);
        Exhibitor::create(['event_id'=>$event1->id,'company_name'=>'SecureCloud','booth_number'=>'B04','description'=>'Enterprise security in the cloud.','booth_size'=>'medium']);

        // Event 1 Access Code
        AccessCode::create(['event_id'=>$event1->id,'code'=>'EARLY50','discount_type'=>'percentage','discount'=>50,'max_uses'=>100,'description'=>'Early bird 50% discount']);

        // Event 1 Survey
        Survey::create(['event_id'=>$event1->id,'title'=>'Post-Event Feedback','description'=>'Please share your experience at TechSummit 2025','questions'=>json_encode([['q'=>'How would you rate the event overall?','type'=>'rating'],['q'=>'Which session did you find most valuable?','type'=>'text'],['q'=>'Would you recommend this event to a colleague?','type'=>'radio','options'=>['Yes','No','Maybe']]]),'is_active'=>true]);

        // Event 1 Attendees
        $attendees = [
            ['first_name'=>'Alice','last_name'=>'Johnson','email'=>'alice@example.com','organization'=>'TechStartup','job_title'=>'Software Engineer'],
            ['first_name'=>'Bob','last_name'=>'Smith','email'=>'bob@example.com','organization'=>'FinTech Corp','job_title'=>'Product Manager'],
            ['first_name'=>'Carol','last_name'=>'Davis','email'=>'carol@example.com','organization'=>'DataSci Labs','job_title'=>'Data Scientist'],
            ['first_name'=>'David','last_name'=>'Wilson','email'=>'david@example.com','organization'=>'WebAgency','job_title'=>'Frontend Developer'],
            ['first_name'=>'Emma','last_name'=>'Taylor','email'=>'emma@example.com','organization'=>'AIStartup','job_title'=>'ML Engineer'],
            ['first_name'=>'Frank','last_name'=>'Anderson','email'=>'frank@example.com','organization'=>'CloudCo','job_title'=>'DevOps Engineer'],
            ['first_name'=>'Grace','last_name'=>'Thomas','email'=>'grace@example.com','organization'=>'University','job_title'=>'PhD Student'],
            ['first_name'=>'Henry','last_name'=>'Jackson','email'=>'henry@example.com','organization'=>'Consulting Co','job_title'=>'CTO'],
            ['first_name'=>'Iris','last_name'=>'White','email'=>'iris@example.com','organization'=>'MobileFirst','job_title'=>'iOS Developer'],
            ['first_name'=>'Jack','last_name'=>'Harris','email'=>'jack@example.com','organization'=>'OpenSource.io','job_title'=>'Open Source Maintainer'],
        ];
        $tickets = [$t1,$t2,$t3];
        $statuses = ['paid','paid','paid','pending','paid','paid','pending','paid','paid','paid'];
        foreach ($attendees as $i => $aData) {
            $attendee = Attendee::create(array_merge($aData, ['event_id'=>$event1->id,'portal_password'=>Str::random(8),'checked_in'=>($i < 6),'checked_in_at'=>($i < 6 ? now()->subHours(rand(1,5)) : null)]));
            $ticket = $tickets[$i % 3];
            Order::create(['event_id'=>$event1->id,'attendee_id'=>$attendee->id,'ticket_id'=>$ticket->id,'order_number'=>strtoupper(Str::random(10)),'total_amount'=>$ticket->price,'status'=>$statuses[$i],'paid_at'=>($statuses[$i]==='paid' ? now()->subDays(rand(5,30)) : null)]);
        }

        // Event 1 Papers
        $authors = Attendee::where('event_id', $event1->id)->take(5)->get();
        $paperData = [
            ['title'=>'Large Language Models in Production: Lessons Learned','abstract'=>'This paper explores practical challenges and solutions encountered when deploying LLMs at scale in enterprise production environments. We cover latency optimization, cost management, and safety guardrails based on 18 months of experience.','keywords'=>'LLM, production, deployment, optimization','status'=>'accepted'],
            ['title'=>'Zero-Trust Architecture: A Practical Implementation Guide','abstract'=>'We present a comprehensive framework for implementing zero-trust security models in existing enterprise infrastructure. The paper covers identity verification, network segmentation, and continuous validation strategies.','keywords'=>'security, zero-trust, enterprise, architecture','status'=>'under_review'],
            ['title'=>'Optimizing React Performance at Scale','abstract'=>'An in-depth analysis of React performance bottlenecks in applications serving millions of users, with profiling techniques and optimization patterns derived from real-world production systems.','keywords'=>'React, performance, frontend, optimization','status'=>'submitted'],
            ['title'=>'Sustainable Software: Measuring and Reducing Carbon Footprint','abstract'=>'This paper proposes metrics and tooling for measuring software carbon footprint and presents case studies of organizations that reduced emissions by 40% through code optimization.','keywords'=>'sustainability, green software, carbon footprint','status'=>'revision_requested'],
            ['title'=>'Kubernetes Cost Optimization Strategies','abstract'=>'A systematic approach to reducing Kubernetes infrastructure costs by 60% through right-sizing, spot instances, and intelligent autoscaling without sacrificing reliability.','keywords'=>'Kubernetes, cost, cloud, infrastructure','status'=>'accepted'],
        ];
        foreach ($paperData as $i => $pd) {
            if (isset($authors[$i])) {
                $paper = Paper::create(array_merge($pd, ['event_id'=>$event1->id,'author_id'=>$authors[$i]->id]));
                if (in_array($pd['status'],['accepted','rejected','revision_requested','under_review'])) {
                    PaperReview::create(['paper_id'=>$paper->id,'reviewer_id'=>$authors[($i+1)%count($authors)]->id,'score'=>rand(6,9),'comments'=>'Well-structured paper with clear methodology. The experimental results support the claims, though more baseline comparisons would strengthen the work.','recommendation'=>'accept','status'=>'completed']);
                }
            }
        }

        // ── Event 2: Marketing Summit ─────────────────────────────────
        $event2 = Event::create([
            'name'        => 'Digital Marketing Summit 2025',
            'slug'        => 'digital-marketing-summit-2025',
            'description' => 'Empowering marketers with cutting-edge strategies, data-driven insights, and actionable tactics for the digital age.',
            'start_date'  => '2025-10-20 08:30:00',
            'end_date'    => '2025-10-21 17:00:00',
            'venue'       => 'Grand Convention Hotel',
            'location'    => 'New York City, NY, USA',
            'category'    => 'Marketing',
            'status'      => 'published',
            'website_hero_title'    => 'Digital Marketing Summit 2025',
            'website_hero_subtitle' => 'Master the Art of Digital Growth',
            'website_primary_color' => '#f59e0b',
            'created_by'  => 'admin@eventpro.com',
        ]);
        Ticket::create(['event_id'=>$event2->id,'name'=>'General Admission','price'=>149,'quantity'=>300,'ticket_type'=>'paid','is_visible'=>true]);
        Ticket::create(['event_id'=>$event2->id,'name'=>'Premium Workshop Pass','price'=>349,'quantity'=>80,'ticket_type'=>'paid','is_visible'=>true]);
        $mkt_sp1 = Speaker::create(['event_id'=>$event2->id,'first_name'=>'Lisa','last_name'=>'Chang','bio'=>'Digital marketing expert with 12 years at Fortune 500 brands.','organization'=>'BrandGrowth','job_title'=>'CMO','is_featured'=>true]);
        Schedule::create(['event_id'=>$event2->id,'title'=>'SEO in the Age of AI','start_time'=>'2025-10-20 09:00:00','end_time'=>'2025-10-20 10:30:00','room'=>'Main Ballroom','session_type'=>'keynote','speaker_id'=>$mkt_sp1->id,'is_public'=>true]);
        Sponsor::create(['event_id'=>$event2->id,'name'=>'AdPlatform Pro','tier'=>'gold']);

        // ── Event 3: Healthcare Conference ────────────────────────────
        $event3 = Event::create([
            'name'        => 'HealthTech Innovation Forum',
            'slug'        => 'healthtech-innovation-forum-2025',
            'description' => 'Connecting healthcare professionals, technologists, and innovators to shape the future of medicine and patient care.',
            'start_date'  => '2025-11-08 08:00:00',
            'end_date'    => '2025-11-09 17:00:00',
            'venue'       => 'Medical Research Center',
            'location'    => 'Boston, MA, USA',
            'category'    => 'Healthcare',
            'status'      => 'draft',
            'created_by'  => 'manager@eventpro.com',
        ]);
        Ticket::create(['event_id'=>$event3->id,'name'=>'Clinical Pass','price'=>299,'quantity'=>200,'ticket_type'=>'paid','is_visible'=>true]);
    }
}