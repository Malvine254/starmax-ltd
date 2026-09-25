@extends('admin.layout')
@section('page-title', 'Preview invitations')
@section('content')
<section class="card">
    <h1>Review invitations for {{ $event->title }}</h1>
    <p>{{ count($draft['recipients']) }} recipients ready. {{ $draft['duplicates'] }} duplicate addresses removed. {{ count($draft['issues']) }} row issues.</p>
    @if($draft['issues'])
        <div class="alert-error"><ul>@foreach($draft['issues'] as $issue)<li>{{ $issue }}</li>@endforeach</ul></div>
    @endif
    @php($sample = (array) new \App\Mail\EventInvitation($event, $draft['recipients'][0], $draft['subject'], $draft['message']))
    <h2>Sample email</h2>
    <p><strong>{{ $sample['invitationSubject'] }}</strong></p>
    <p style="white-space:pre-line">{{ $sample['invitationMessage'] }}</p>
    <p><a href="{{ $sample['eventUrl'] }}">View event details</a></p>
    <div style="overflow:auto;max-height:400px;margin:20px 0"><table>
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Company</th></tr></thead>
        <tbody>@foreach($draft['recipients'] as $recipient)<tr>@foreach($recipient as $value)<td>{{ $value }}</td>@endforeach</tr>@endforeach</tbody>
    </table></div>
    <p>Sending saves these attendees to the event and queues a separate email for each person. Existing attendee records are kept without duplicates.</p>
    <form method="POST" action="{{ route('admin.event-invitations.send') }}">
        @csrf <input type="hidden" name="token" value="{{ $draft['token'] }}">
        <button type="submit" class="btn btn-primary">Send {{ count($draft['recipients']) }} invitations</button>
        <a class="btn btn-secondary" href="{{ route('admin.event-registrations.index', ['event' => $event->id]) }}">Back to upload</a>
    </form>
</section>
@endsection
