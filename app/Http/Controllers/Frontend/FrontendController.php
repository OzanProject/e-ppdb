<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Post;
use App\Models\Faq;
use App\Models\PpdbTrack;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $school = School::first(); // Assuming single school instance
        $featuredPosts = Post::where('is_published', true)->latest()->take(3)->get();
        $faqs = Faq::where('is_active', true)->orderBy('order_index')->get();
        $tracks = PpdbTrack::where('is_active', true)->get();
        $schedules = \App\Models\PpdbSchedule::where('is_active', true)->orderBy('start_date')->get();
        
        return view('frontend.home', compact('school', 'featuredPosts', 'faqs', 'tracks', 'schedules'));
    }
    public function showPost($slug)
    {
        $school = School::first();
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        return view('frontend.news.show', compact('school', 'post'));
    }
}
