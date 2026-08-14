<div style="max-width:620px;margin:auto;padding:35px;font-family:Arial,sans-serif;color:#172033">
<div style="font-weight:900;letter-spacing:.2em">STARMAX<span style="color:#c58b25">.</span></div>
<h1 style="font-family:Georgia,serif;font-weight:400;margin-top:35px">Congratulations, {{ $registration->name }}!</h1>
<p style="color:#5d6878;line-height:1.7">Your certificate of completion for <strong>{{ $registration->event->title }}</strong> has been issued.</p>
<p style="margin:28px 0"><a href="{{ route('certificates.download',$registration->certificate_code) }}" style="display:inline-block;padding:13px 20px;border-radius:7px;color:#fff;background:#172033;text-decoration:none;font-weight:bold">Download certificate PDF</a></p>
<p><a href="{{ route('certificates.show',$registration->certificate_code) }}" style="color:#9a6819">View certificate online</a> · <a href="{{ route('certificates.verify',['code'=>$registration->certificate_code]) }}" style="color:#9a6819">Verify authenticity</a></p>
<p style="color:#7b8492;font-size:12px">Certificate ID: {{ $registration->certificate_code }}<br>This certificate can be independently verified online.</p>
</div>
