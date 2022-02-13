@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">部位別工程管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('parts.index') }}">戻る</a>
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                        <th>カラム4</th>
                        <th>カラム5</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($part->processes as $process)
                    <tr>
                        <td>{{ $process->code }}</td>
                        <td>{{ $process->name }}</td>
                        <td>{{ $process->processPart->mappingItems->count() }}</td>
                        <td><a class="button" href={{ route('parts.processes.edit', [$part->id, $process->id]) }}>編集</a></td>
                        <td><a class="button" href={{ route('mapping-items.index', [$process->processPart->id]) }}>マッピング項目</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{-- {{$partProcesses->links('pagination::bootstrap-4')}} --}}
    </div>
</div>
@endsection
