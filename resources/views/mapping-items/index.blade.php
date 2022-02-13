@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">マッピング項目管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('parts.processes.index', [$processPart->part_id]) }}">戻る</a>
            <a class="button" href="{{ route('mapping-items.create', [$processPart->id]) }}">登録</a>
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($mappingItems as $mappingItem)
                    <tr>
                        <td>{{ $mappingItem->code }}</td>
                        <td>{{ $mappingItem->content }}</td>
                        <td><a class="button" href={{ route('mapping-items.edit', [$processPart->id, $mappingItem->id]) }}>編集</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$mappingItems->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
