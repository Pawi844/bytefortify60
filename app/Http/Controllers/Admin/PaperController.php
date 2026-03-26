<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Paper;
use App\Models\PaperReview;
use App\Models\Attendee;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event   = Event::findOrFail($eventId);
        $status  = request('status');
        $papers  = Paper::where('event_id', $eventId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->with(['author','reviews'])
            ->latest()->paginate(20);
        return view('admin.papers.index', compact('event','papers','status'));
    }

    public function show($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $paper  = Paper::with(['author','reviews.reviewer','fields'])->findOrFail($id);
        $reviewers = Attendee::where('event_id', $eventId)->get();
        return view('admin.papers.show', compact('event','paper','reviewers'));
    }

    public function assignReviewer(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $paper = Paper::findOrFail($id);
        $request->validate(['reviewer_id' => 'required|exists:attendees,id']);
        PaperReview::firstOrCreate([
            'paper_id'    => $paper->id,
            'reviewer_id' => $request->reviewer_id,
        ], ['status' => 'pending']);
        return back()->with('success', 'Reviewer assigned!');
    }

    public function decision(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $request->validate(['status' => 'required|in:accepted,rejected,revision_requested']);
        $paper = Paper::findOrFail($id);
        $paper->update([
            'status'            => $request->status,
            'decision_comment'  => $request->decision_comment,
            'decided_at'        => now(),
        ]);
        return back()->with('success', 'Decision recorded and author will be notified.');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Paper::findOrFail($id)->delete();
        return redirect()->route('admin.papers.index', $eventId)->with('success', 'Paper deleted.');
    }

    public function createReview($eventId, $paperId)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $paper  = Paper::with('author')->findOrFail($paperId);
        return view('admin.papers.review', compact('event','paper'));
    }

    public function storeReview(Request $request, $eventId, $paperId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'score'    => 'required|integer|min:1|max:10',
            'comments' => 'required|string',
            'recommendation' => 'required|in:accept,reject,major_revision,minor_revision',
        ]);
        $validated['paper_id']    = $paperId;
        $validated['reviewer_id'] = null;
        $validated['status']      = 'completed';
        PaperReview::create($validated);
        return redirect()->route('admin.papers.show', [$eventId, $paperId])->with('success', 'Review submitted!');
    }
}