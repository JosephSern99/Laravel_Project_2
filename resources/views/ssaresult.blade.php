<div id="table_SSA" class="table-responsive p-1 border border-secondary rounded position-absolute bg-white" style="z-index: 100;max-height: 225px;">
@if(isset($fail))
<div>{!! $fail !!}</div>
@elseif(isset($records))
@if (!empty($records) && count($records) > 0)
<table id="table_SSA_table" class="table table-bordered table-striped table-sm m-0">
<thead>
    <tr>
        @foreach ($columns as $col)
        @if (in_array($col, $columns_def))
            <th class='align-top'>{!! !empty(__("columns")[$col]) ? __("columns.$col") : $col !!}</th>
        @endif
        @endforeach
    </tr>
</thead>
<tbody>
    @foreach ($records as $record)
    <tr class="tableSSA_table_row">
        @foreach ($columns as $cols)
        @if ($cols == $caption)
        <input type="hidden" class="ssa_display_value" value="{!! $record->$cols !!}" />
        @endif
        @if ($cols == $primary)
        <input type="hidden" class="ssa_select_value" value="{!! $record->$cols !!}" />
        @endif
        @if (in_array($cols, $columns_def))
            <td>{!! nl2br($record->$cols) !!}</td>
        @endif
        @endforeach
    </tr>
    @endforeach
</tbody>
</table>
@if ($count > 25)
<div><i>{!! "Showing 25 of ".$count." records." !!}</i></div>
@endif
@else
<div>No Record found</div>
@endif
@endif
</div>
