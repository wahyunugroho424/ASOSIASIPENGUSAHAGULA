<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\Event;
use App\Models\SocialContent;
use App\Models\News;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Models\OrganizationalStructure;
use Artesaos\SEOTools\Facades\JsonLd;
use App\Models\Member; 

class HomeController extends Controller
{
    public function index()
    {
        // Get dynamic content from database
        $galleries = Gallery::active()->ordered()->take(100)->get();

        $galleriesByCategory = [
            'rapat'      => Gallery::active()->byCategory('rapat')->ordered()->take(100)->get(),
            'seminar'    => Gallery::active()->byCategory('seminar')->ordered()->take(100)->get(),
            'pelatihan'  => Gallery::active()->byCategory('pelatihan')->ordered()->take(100)->get(),
        ];

        $events         = Event::active()->upcoming()->take(100)->get();
        $socialContents = SocialContent::active()->published()->latest()->take(100)->get();

        $members = Member::where('is_active', 1)
            ->whereNotNull('logo')
            ->where('logo', '!=', '')
            ->ordered()
            ->get();

        $allMembers = Member::where('is_active', 1)
            ->ordered()
            ->get();

        $allMembersData = $allMembers->map(function ($m) {
            return [
                'name'     => $m->name,
                'logo'     => $m->logo,
                'logo_url' => $m->logo_url,
            ];
        })->values()->toArray();

        /*
        |--------------------------------------------------------------------------
        | Statistik Member
        |--------------------------------------------------------------------------
        */
        $totalMembers    = Member::count();
        $activeMembers   = Member::where('is_active', 1)->count();
        $inactiveMembers = Member::where('is_active', 0)->count();

        // NEWS
        try {
            $news = News::active()->published()->latest()->take(100)->get();

            if ($news->isEmpty()) {
                $news = News::where('is_active', 1)
                    ->whereNotNull('published_at')
                    ->latest('published_at')
                    ->take(6)
                    ->get();
            }

            if ($news->isEmpty()) {
                $news = News::where('is_active', 1)
                    ->latest()
                    ->take(6)
                    ->get();
            }

        } catch (\Exception $e) {
            $news = collect();
            \Log::error('News query failed: ' . $e->getMessage());
        }

        $orgStructures = OrganizationalStructure::active()
            ->ordered()
            ->get()
            ->groupBy('section');

        return view('home', compact(
            'galleries',
            'galleriesByCategory',
            'events',
            'socialContents',
            'news',
            'members',
            'allMembers',
            'allMembersData',

            // statistik
            'totalMembers',
            'activeMembers',
            'inactiveMembers',
            'orgStructures'
        ));
    }
        
    public function about()
    {
        SEOMeta::setTitle('Tentang Kami - Profil Perusahaan');
        SEOMeta::setDescription('Mengenal lebih dekat tentang perusahaan kami, visi misi, sejarah, dan komitmen terhadap kualitas layanan');
        SEOMeta::setKeywords(['tentang kami', 'profil perusahaan', 'visi misi', 'sejarah perusahaan']);
        SEOMeta::setCanonical(url('/tentang'));
        
        OpenGraph::setTitle('Tentang Kami - Profil Perusahaan');
        OpenGraph::setDescription('Mengenal lebih dekat tentang perusahaan kami dan komitmen terhadap kualitas');
        OpenGraph::setUrl(url('/tentang'));
        
        return view('about');
    }
    
    public function services()
    {
        // Set SEO Meta Tags
        SEOMeta::setTitle('Layanan Kami - ' . config('app.name'));
        SEOMeta::setDescription('Temukan berbagai layanan berkualitas tinggi yang kami tawarkan untuk memenuhi kebutuhan bisnis Anda.');
        SEOMeta::setKeywords(array_merge(config('company.keywords'), ['layanan', 'solusi bisnis', 'konsultasi']));
        SEOMeta::setCanonical(url('/layanan'));
        
        // Set Open Graph
        OpenGraph::setTitle('Layanan Kami - ' . config('app.name'));
        OpenGraph::setDescription('Temukan berbagai layanan berkualitas tinggi yang kami tawarkan untuk memenuhi kebutuhan bisnis Anda.');
        OpenGraph::setUrl(url('/layanan'));
        
        // Set Twitter Card
        TwitterCard::setTitle('Layanan Kami - ' . config('app.name'));
        TwitterCard::setDescription('Temukan berbagai layanan berkualitas tinggi yang kami tawarkan untuk memenuhi kebutuhan bisnis Anda.');
        
        // Set JSON-LD
        JsonLd::setTitle('Layanan Kami - ' . config('app.name'));
        JsonLd::setDescription('Temukan berbagai layanan berkualitas tinggi yang kami tawarkan untuk memenuhi kebutuhan bisnis Anda.');
        JsonLd::setType('Service');
        
        return view('services');
    }
    
    public function contact()
    {
        // Set SEO Meta Tags
        SEOMeta::setTitle('Kontak Kami - ' . config('app.name'));
        SEOMeta::setDescription('Hubungi ' . config('app.name') . ' untuk konsultasi dan informasi lebih lanjut. Tim kami siap membantu Anda.');
        SEOMeta::setKeywords(array_merge(config('company.keywords'), ['kontak', 'hubungi kami', 'konsultasi']));
        SEOMeta::setCanonical(url('/kontak'));
        
        // Set Open Graph
        OpenGraph::setTitle('Kontak Kami - ' . config('app.name'));
        OpenGraph::setDescription('Hubungi ' . config('app.name') . ' untuk konsultasi dan informasi lebih lanjut. Tim kami siap membantu Anda.');
        OpenGraph::setUrl(url('/kontak'));
        
        // Set Twitter Card
        TwitterCard::setTitle('Kontak Kami - ' . config('app.name'));
        TwitterCard::setDescription('Hubungi ' . config('app.name') . ' untuk konsultasi dan informasi lebih lanjut. Tim kami siap membantu Anda.');
        
        // Set JSON-LD
        JsonLd::setTitle('Kontak Kami - ' . config('app.name'));
        JsonLd::setDescription('Hubungi ' . config('app.name') . ' untuk konsultasi dan informasi lebih lanjut. Tim kami siap membantu Anda.');
        JsonLd::setType('ContactPage');
        
        return view('contact');
    }
}
