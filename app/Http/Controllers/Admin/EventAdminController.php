<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventAdminController extends Controller
{
    public function index()
    {
        $events = SiteEvent::orderBy('starts_at')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'format'      => 'nullable|string|max:100',
            'location'    => 'required|string|max:255',
            'starts_at'   => 'required|date',
            'ends_at'     => 'nullable|date|after:starts_at',
            'excerpt'     => 'required|string|max:500',
            'description' => 'required|string',
            'cta_label'   => 'required|string|max:100',
            'cta_url'     => 'required|string|max:500',
            'is_featured' => 'boolean',
            'status'      => 'required|in:upcoming,past,cancelled',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['slug']       = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        SiteEvent::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(SiteEvent $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, SiteEvent $event)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'format'      => 'nullable|string|max:100',
            'location'    => 'required|string|max:255',
            'starts_at'   => 'required|date',
            'ends_at'     => 'nullable|date|after:starts_at',
            'excerpt'     => 'required|string|max:500',
            'description' => 'required|string',
            'cta_label'   => 'required|string|max:100',
            'cta_url'     => 'required|string|max:500',
            'is_featured' => 'boolean',
            'status'      => 'required|in:upcoming,past,cancelled',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order']  = $data['sort_order'] ?? 0;

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(SiteEvent $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}
