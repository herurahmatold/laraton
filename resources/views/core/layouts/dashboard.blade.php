@php
$path=resource_path().'/views/dashboard/'.user_group_name().'.blade.php';
@endphp
@if (file_exists($path))
@include('dashboard.'.user_group_name())
@endif