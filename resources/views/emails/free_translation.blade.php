<h3>New Free Translation Request</h3>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Mobile:</strong> {{ $data['mobile'] }}</p>

<p><strong>Source Language:</strong> {{ $data['source_language'] }}</p>
<p><strong>Target Language:</strong> {{ $data['target_language'] }}</p>

<p><strong>File:</strong></p>
@if(isset($data['file_url']))
  <a href="{{ $data['file_url'] }}" target="_blank">Download File</a>
@endif
