@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
    {{ session('success') }}
</div>
@endif