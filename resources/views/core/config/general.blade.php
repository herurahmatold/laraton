<form method="post" class="form-horizontal" action="{{route('core.config.general.update')}}">
@csrf
<input type="hidden" name="prefix" value="{{ $get_prefix }}"/>
@if ($get_prefix=='app')
    <div class="form-group ">
        <label class="control-label col-sm-2">Backend Template</label>
        <div class="col-md-10">
            <input type="text" name="item[backend_theme]" class="form-control" value="{{ option_get('backend_theme') }}" required>
        </div>
    </div>
@endif
@foreach ($data as $row)
    @php
    $label=str_replace($get_prefix,"",$row->option_key);
    $label=str_replace("_"," ",$label);
    $label=ucwords($label);
    @endphp
    <div class="form-group ">
        <label class="control-label col-sm-2">{{ $label }}</label>
        <div class="col-md-10">
            <input type="text" name="item[{{ $row->option_key }}]" class="form-control" value="{{ $row->option_value }}" required>
        </div>
    </div>

@endforeach

    <div class="form-group">
            <label class="control-label col-sm-2">&nbsp;</label>    
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

</form>