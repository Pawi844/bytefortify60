<?php

namespace App\Http\Controllers\Attendee;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Paper;
use Illuminate\Http\Request;

class AttendeePortalController extends Controller
{
    private function attendee()
    {
        $id = session('attendee_id');
        if (!$id) return null;
        return Attendee::with(['event','orders.ticket'])->find($id);
    }

    private function guard()
    {
        if (!session('attendee_id')) return redirect()->route('portal.login');
        return null;
    }

    public function dashboard()
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $event    = $attendee->event;
        $schedule = Schedule::where('event_id', $event->id)->orderBy('start_time')->take(5)->get();
        return view('portal.dashboard', compact('attendee','event','schedule'));
    }

    public function profile()
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        return view('portal.profile', compact('attendee'));
    }

    public function updateProfile(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $attendee  = $this->attendee();
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'phone'        => 'nullable|string|max:30',
            'organization' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'bio'          => 'nullable|string|max:1000',
            'dietary'      => 'nullable|string|max:255',
            'linkedin'     => 'nullable|url',
            'twitter'      => 'nullable|url',
        ]);
        $attendee->update($validated);
        return back()->with('success', 'Profile updated!');
    }

    public function tickets()
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $orders   = Order::with(['ticket','event'])->where('attendee_id', $attendee->id)->get();
        return view('portal.tickets', compact('attendee','orders'));
    }

    public function invoice($orderId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $order    = Order::with(['ticket','event'])->where('attendee_id', $attendee->id)->findOrFail($orderId);
        return view('portal.invoice', compact('attendee','order'));
    }

    public function receipt($orderId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $order    = Order::with(['ticket','event'])->where('attendee_id', $attendee->id)->findOrFail($orderId);
        return view('portal.receipt', compact('attendee','order'));
    }

    public function badge($orderId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $order    = Order::with(['ticket','event'])->where('attendee_id', $attendee->id)->findOrFail($orderId);
        return view('portal.badge', compact('attendee','order'));
    }

    public function schedule()
    {
        if ($r = $this->guard()) return $r;
        $attendee      = $this->attendee();
        $event         = $attendee->event;
        $allSessions   = Schedule::where('event_id', $event->id)->with('speaker')->orderBy('start_time')->get()->groupBy(fn($s) => $s->start_time->format('Y-m-d'));
        $mySessions    = $attendee->sessions()->pluck('schedule_id')->toArray();
        return view('portal.schedule', compact('attendee','event','allSessions','mySessions'));
    }

    public function toggleSession($sessionId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        if ($attendee->sessions()->where('schedule_id', $sessionId)->exists()) {
            $attendee->sessions()->detach($sessionId);
            $msg = 'Session removed from your schedule.';
        } else {
            $attendee->sessions()->attach($sessionId);
            $msg = 'Session added to your schedule!';
        }
        return back()->with('success', $msg);
    }

    public function surveys()
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $surveys  = Survey::where('event_id', $attendee->event_id)->where('is_active', true)->get();
        $responded = SurveyResponse::where('attendee_id', $attendee->id)->pluck('survey_id')->toArray();
        return view('portal.surveys', compact('attendee','surveys','responded'));
    }

    public function takeSurvey($surveyId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $survey   = Survey::findOrFail($surveyId);
        return view('portal.survey-take', compact('attendee','survey'));
    }

    public function submitSurvey(Request $request, $surveyId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        SurveyResponse::create([
            'survey_id'   => $surveyId,
            'attendee_id' => $attendee->id,
            'answers'     => json_encode($request->except('_token')),
        ]);
        return redirect()->route('portal.surveys')->with('success', 'Survey submitted! Thank you.');
    }

    public function papers()
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $papers   = Paper::where('author_id', $attendee->id)->with('reviews')->get();
        return view('portal.papers', compact('attendee','papers'));
    }

    public function viewPaper($paperId)
    {
        if ($r = $this->guard()) return $r;
        $attendee = $this->attendee();
        $paper    = Paper::where('author_id', $attendee->id)->with('reviews')->findOrFail($paperId);
        return view('portal.paper-detail', compact('attendee','paper'));
    }
}