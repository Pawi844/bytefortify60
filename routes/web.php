<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AttendeeController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\ExhibitorController;
use App\Http\Controllers\Admin\PaperController;
use App\Http\Controllers\Admin\PaperFieldController;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\Admin\AccessCodeController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\Admin\MailCommunicationController;
use App\Http\Controllers\Admin\BadgeController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Attendee\AttendeePortalController;
use App\Http\Controllers\Attendee\AttendeeAuthController;
use App\Http\Controllers\EventFrontController;

// ─── Public Landing ───────────────────────────────────────────────────────────
Route::get('/', function () { return view('welcome'); })->name('home');

// ─── Event Public Site ────────────────────────────────────────────────────────
Route::get('/events/{event:slug}', [EventFrontController::class, 'show'])->name('event.show');
Route::get('/events/{event:slug}/register', [EventFrontController::class, 'register'])->name('event.register');
Route::post('/events/{event:slug}/register', [EventFrontController::class, 'storeRegistration'])->name('event.register.store');
Route::get('/events/{event:slug}/schedule', [EventFrontController::class, 'schedule'])->name('event.schedule');
Route::get('/events/{event:slug}/speakers', [EventFrontController::class, 'speakers'])->name('event.speakers');
Route::get('/events/{event:slug}/sponsors', [EventFrontController::class, 'sponsors'])->name('event.sponsors');
Route::get('/events/{event:slug}/cfp', [EventFrontController::class, 'cfp'])->name('event.cfp');
Route::post('/events/{event:slug}/cfp', [EventFrontController::class, 'submitPaper'])->name('event.cfp.submit');
Route::get('/events/{event:slug}/pay/{order}', [EventFrontController::class, 'showPayment'])->name('event.payment');
Route::post('/events/{event:slug}/pay/{order}', [EventFrontController::class, 'processPayment'])->name('event.payment.process');
Route::get('/events/{event:slug}/pay/{order}/callback', [EventFrontController::class, 'paymentCallback'])->name('event.payment.callback');
Route::get('/events/{event:slug}/pay/{order}/success', [EventFrontController::class, 'paymentSuccess'])->name('event.payment.success');

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Admin Dashboard ──────────────────────────────────────────────────────────
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

// ─── Events ───────────────────────────────────────────────────────────────────
Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events.index');
Route::get('/admin/events/create', [EventController::class, 'create'])->name('admin.events.create');
Route::post('/admin/events', [EventController::class, 'store'])->name('admin.events.store');
Route::get('/admin/events/{id}', [EventController::class, 'show'])->name('admin.events.show');
Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
Route::put('/admin/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('admin.events.destroy');
Route::post('/admin/events/{id}/publish', [EventController::class, 'publish'])->name('admin.events.publish');
Route::post('/admin/events/{id}/unpublish', [EventController::class, 'unpublish'])->name('admin.events.unpublish');

// ─── Tickets ──────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
Route::get('/admin/events/{eventId}/tickets/create', [TicketController::class, 'create'])->name('admin.tickets.create');
Route::post('/admin/events/{eventId}/tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
Route::get('/admin/events/{eventId}/tickets/{id}/edit', [TicketController::class, 'edit'])->name('admin.tickets.edit');
Route::put('/admin/events/{eventId}/tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
Route::delete('/admin/events/{eventId}/tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

// ─── Orders ───────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/events/{eventId}/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::post('/admin/events/{eventId}/orders/{id}/approve', [OrderController::class, 'approve'])->name('admin.orders.approve');
Route::post('/admin/events/{eventId}/orders/{id}/refund', [OrderController::class, 'refund'])->name('admin.orders.refund');
Route::get('/admin/events/{eventId}/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');
Route::get('/admin/events/{eventId}/orders/{id}/receipt', [OrderController::class, 'receipt'])->name('admin.orders.receipt');

// ─── Attendees ────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/attendees', [AttendeeController::class, 'index'])->name('admin.attendees.index');
Route::get('/admin/events/{eventId}/attendees/export', [AttendeeController::class, 'export'])->name('admin.attendees.export');
Route::post('/admin/events/{eventId}/attendees/import', [AttendeeController::class, 'import'])->name('admin.attendees.import');
Route::get('/admin/events/{eventId}/attendees/{id}', [AttendeeController::class, 'show'])->name('admin.attendees.show');
Route::get('/admin/events/{eventId}/attendees/{id}/edit', [AttendeeController::class, 'edit'])->name('admin.attendees.edit');
Route::put('/admin/events/{eventId}/attendees/{id}', [AttendeeController::class, 'update'])->name('admin.attendees.update');
Route::delete('/admin/events/{eventId}/attendees/{id}', [AttendeeController::class, 'destroy'])->name('admin.attendees.destroy');
Route::get('/admin/events/{eventId}/attendees/{id}/badge', [AttendeeController::class, 'badge'])->name('admin.attendees.badge');

// ─── Speakers ─────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/speakers', [SpeakerController::class, 'index'])->name('admin.speakers.index');
Route::get('/admin/events/{eventId}/speakers/create', [SpeakerController::class, 'create'])->name('admin.speakers.create');
Route::post('/admin/events/{eventId}/speakers', [SpeakerController::class, 'store'])->name('admin.speakers.store');
Route::get('/admin/events/{eventId}/speakers/{id}/edit', [SpeakerController::class, 'edit'])->name('admin.speakers.edit');
Route::put('/admin/events/{eventId}/speakers/{id}', [SpeakerController::class, 'update'])->name('admin.speakers.update');
Route::delete('/admin/events/{eventId}/speakers/{id}', [SpeakerController::class, 'destroy'])->name('admin.speakers.destroy');

// ─── Schedule ─────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/schedule', [ScheduleController::class, 'index'])->name('admin.schedule.index');
Route::get('/admin/events/{eventId}/schedule/create', [ScheduleController::class, 'create'])->name('admin.schedule.create');
Route::post('/admin/events/{eventId}/schedule', [ScheduleController::class, 'store'])->name('admin.schedule.store');
Route::get('/admin/events/{eventId}/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit');
Route::put('/admin/events/{eventId}/schedule/{id}', [ScheduleController::class, 'update'])->name('admin.schedule.update');
Route::delete('/admin/events/{eventId}/schedule/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy');

// ─── Sponsors ─────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/sponsors', [SponsorController::class, 'index'])->name('admin.sponsors.index');
Route::get('/admin/events/{eventId}/sponsors/create', [SponsorController::class, 'create'])->name('admin.sponsors.create');
Route::post('/admin/events/{eventId}/sponsors', [SponsorController::class, 'store'])->name('admin.sponsors.store');
Route::get('/admin/events/{eventId}/sponsors/{id}/edit', [SponsorController::class, 'edit'])->name('admin.sponsors.edit');
Route::put('/admin/events/{eventId}/sponsors/{id}', [SponsorController::class, 'update'])->name('admin.sponsors.update');
Route::delete('/admin/events/{eventId}/sponsors/{id}', [SponsorController::class, 'destroy'])->name('admin.sponsors.destroy');

// ─── Exhibitors ───────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/exhibitors', [ExhibitorController::class, 'index'])->name('admin.exhibitors.index');
Route::get('/admin/events/{eventId}/exhibitors/create', [ExhibitorController::class, 'create'])->name('admin.exhibitors.create');
Route::post('/admin/events/{eventId}/exhibitors', [ExhibitorController::class, 'store'])->name('admin.exhibitors.store');
Route::get('/admin/events/{eventId}/exhibitors/{id}/edit', [ExhibitorController::class, 'edit'])->name('admin.exhibitors.edit');
Route::put('/admin/events/{eventId}/exhibitors/{id}', [ExhibitorController::class, 'update'])->name('admin.exhibitors.update');
Route::delete('/admin/events/{eventId}/exhibitors/{id}', [ExhibitorController::class, 'destroy'])->name('admin.exhibitors.destroy');

// ─── Papers / CFP ─────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/papers', [PaperController::class, 'index'])->name('admin.papers.index');
Route::get('/admin/events/{eventId}/papers/{id}', [PaperController::class, 'show'])->name('admin.papers.show');
Route::post('/admin/events/{eventId}/papers/{id}/assign-reviewer', [PaperController::class, 'assignReviewer'])->name('admin.papers.assign-reviewer');
Route::post('/admin/events/{eventId}/papers/{id}/decision', [PaperController::class, 'decision'])->name('admin.papers.decision');
Route::delete('/admin/events/{eventId}/papers/{id}', [PaperController::class, 'destroy'])->name('admin.papers.destroy');

Route::get('/admin/events/{eventId}/papers/{paperId}/reviews/create', [PaperController::class, 'createReview'])->name('admin.papers.reviews.create');
Route::post('/admin/events/{eventId}/papers/{paperId}/reviews', [PaperController::class, 'storeReview'])->name('admin.papers.reviews.store');

// ─── Paper Fields ─────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/paper-fields', [PaperFieldController::class, 'index'])->name('admin.paper-fields.index');
Route::get('/admin/events/{eventId}/paper-fields/create', [PaperFieldController::class, 'create'])->name('admin.paper-fields.create');
Route::post('/admin/events/{eventId}/paper-fields', [PaperFieldController::class, 'store'])->name('admin.paper-fields.store');
Route::get('/admin/events/{eventId}/paper-fields/{id}/edit', [PaperFieldController::class, 'edit'])->name('admin.paper-fields.edit');
Route::put('/admin/events/{eventId}/paper-fields/{id}', [PaperFieldController::class, 'update'])->name('admin.paper-fields.update');
Route::delete('/admin/events/{eventId}/paper-fields/{id}', [PaperFieldController::class, 'destroy'])->name('admin.paper-fields.destroy');

// ─── Surveys ──────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/surveys', [SurveyController::class, 'index'])->name('admin.surveys.index');
Route::get('/admin/events/{eventId}/surveys/create', [SurveyController::class, 'create'])->name('admin.surveys.create');
Route::post('/admin/events/{eventId}/surveys', [SurveyController::class, 'store'])->name('admin.surveys.store');
Route::get('/admin/events/{eventId}/surveys/{id}', [SurveyController::class, 'show'])->name('admin.surveys.show');
Route::get('/admin/events/{eventId}/surveys/{id}/edit', [SurveyController::class, 'edit'])->name('admin.surveys.edit');
Route::put('/admin/events/{eventId}/surveys/{id}', [SurveyController::class, 'update'])->name('admin.surveys.update');
Route::delete('/admin/events/{eventId}/surveys/{id}', [SurveyController::class, 'destroy'])->name('admin.surveys.destroy');

// ─── Access Codes ─────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/access-codes', [AccessCodeController::class, 'index'])->name('admin.access-codes.index');
Route::get('/admin/events/{eventId}/access-codes/create', [AccessCodeController::class, 'create'])->name('admin.access-codes.create');
Route::post('/admin/events/{eventId}/access-codes', [AccessCodeController::class, 'store'])->name('admin.access-codes.store');
Route::delete('/admin/events/{eventId}/access-codes/{id}', [AccessCodeController::class, 'destroy'])->name('admin.access-codes.destroy');

// ─── Check-In ─────────────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/check-in', [CheckInController::class, 'index'])->name('admin.check-in.index');
Route::post('/admin/events/{eventId}/check-in', [CheckInController::class, 'checkIn'])->name('admin.check-in.store');
Route::post('/admin/events/{eventId}/check-in/{attendeeId}/undo', [CheckInController::class, 'undo'])->name('admin.check-in.undo');

// ─── Mail Communications ──────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/communications', [MailCommunicationController::class, 'index'])->name('admin.communications.index');
Route::get('/admin/events/{eventId}/communications/create', [MailCommunicationController::class, 'create'])->name('admin.communications.create');
Route::post('/admin/events/{eventId}/communications', [MailCommunicationController::class, 'store'])->name('admin.communications.store');
Route::get('/admin/events/{eventId}/communications/{id}', [MailCommunicationController::class, 'show'])->name('admin.communications.show');
Route::post('/admin/events/{eventId}/communications/{id}/send', [MailCommunicationController::class, 'send'])->name('admin.communications.send');
Route::delete('/admin/events/{eventId}/communications/{id}', [MailCommunicationController::class, 'destroy'])->name('admin.communications.destroy');

// ─── Website Builder ──────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/website', [WebsiteController::class, 'index'])->name('admin.website.index');
Route::put('/admin/events/{eventId}/website', [WebsiteController::class, 'update'])->name('admin.website.update');

// ─── Badge Designer ───────────────────────────────────────────────────────────
Route::get('/admin/events/{eventId}/badges', [BadgeController::class, 'index'])->name('admin.badges.index');
Route::put('/admin/events/{eventId}/badges', [BadgeController::class, 'update'])->name('admin.badges.update');
Route::get('/admin/events/{eventId}/badges/print-all', [BadgeController::class, 'printAll'])->name('admin.badges.print-all');

// ─── Attendee Portal Auth ─────────────────────────────────────────────────────
Route::get('/portal/login', [AttendeeAuthController::class, 'showLogin'])->name('portal.login');
Route::post('/portal/login', [AttendeeAuthController::class, 'login'])->name('portal.login.post');
Route::post('/portal/logout', [AttendeeAuthController::class, 'logout'])->name('portal.logout');

// ─── Attendee Portal ──────────────────────────────────────────────────────────
Route::get('/portal', [AttendeePortalController::class, 'dashboard'])->name('portal.dashboard');
Route::get('/portal/profile', [AttendeePortalController::class, 'profile'])->name('portal.profile');
Route::put('/portal/profile', [AttendeePortalController::class, 'updateProfile'])->name('portal.profile.update');
Route::get('/portal/tickets', [AttendeePortalController::class, 'tickets'])->name('portal.tickets');
Route::get('/portal/tickets/{orderId}/invoice', [AttendeePortalController::class, 'invoice'])->name('portal.invoice');
Route::get('/portal/tickets/{orderId}/receipt', [AttendeePortalController::class, 'receipt'])->name('portal.receipt');
Route::get('/portal/tickets/{orderId}/badge', [AttendeePortalController::class, 'badge'])->name('portal.badge');
Route::get('/portal/schedule', [AttendeePortalController::class, 'schedule'])->name('portal.schedule');
Route::post('/portal/schedule/{sessionId}/toggle', [AttendeePortalController::class, 'toggleSession'])->name('portal.schedule.toggle');
Route::get('/portal/surveys', [AttendeePortalController::class, 'surveys'])->name('portal.surveys');
Route::get('/portal/surveys/{surveyId}', [AttendeePortalController::class, 'takeSurvey'])->name('portal.surveys.take');
Route::post('/portal/surveys/{surveyId}', [AttendeePortalController::class, 'submitSurvey'])->name('portal.surveys.submit');
Route::get('/portal/papers', [AttendeePortalController::class, 'papers'])->name('portal.papers');
Route::get('/portal/papers/{paperId}', [AttendeePortalController::class, 'viewPaper'])->name('portal.papers.view');