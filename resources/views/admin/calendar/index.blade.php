@extends('layouts.default')
@section('content')
    {{-- CAN event_create --}}
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.calendar.create") }}">
                {{ __('global.add') }} {{ __('cruds.event.title_singular') }}
            </a>
        </div>
    </div>
    {{-- END event_create --}}
    <div class="card">
        <div class="card-header">
            {{ __('cruds.event.title_singular') }} {{ __('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ __('cruds.event.fields.id') }}
                        </th>
                        <th>
                            {{ __('cruds.event.fields.name') }}
                        </th>
                        <th>
                            {{ __('cruds.event.fields.start_time') }}
                        </th>
                        <th>
                            {{ __('cruds.event.fields.end_time') }}
                        </th>
                        <th>
                            {{ __('cruds.event.fields.recurrence') }}
                        </th>
                        <th>
                            {{ __('cruds.event.fields.event') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $key => $event)
                        <tr data-entry-id="{{ $event->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $event->id ?? '' }}
                            </td>
                            <td>
                                {{ $event->name ?? '' }}
                            </td>
                            <td>
                                {{ $event->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $event->end_time ?? '' }}
                            </td>
                            <td>
                                {{ \App\Models\Calendar::RECURRENCE_RADIO[$event->recurrence] ?? '' }}
                            </td>
                            <td>
                                {{ $event->event->name ?? '' }}
                            </td>
                            <td>
                                <!-- event_show -->

                                <a class="btn btn-xs btn-primary" href="{{ route('admin.calendar.show', $event->id) }}">
                                    {{ __('global.view') }}
                                </a>

                                <!-- event_edit -->

                                <a class="btn btn-xs btn-info" href="{{ route('admin.calendar.edit', $event->id) }}">
                                    {{ __('global.edit') }}
                                </a>

                                <!-- event_delete -->

                                <form action="{{ route('admin.calendar.destroy', $event->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('{{ $event->events_count || $event->event ? 'Do you want to delete future recurring events, too?' : __('global.areYouSure') }}');"
                                      style="display: inline-block;"
                                >
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger"
                                           value="{{ __('global.delete') }}">
                                </form>


                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            {{-- CAN event_delete --}}

            let deleteButtonTrans = '{{ __('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.calendar.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ __('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ __('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            {{-- ENDCAN event_delete --}}

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'asc']],
                pageLength: 100,
            });
            $('.datatable-Event:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endpush
