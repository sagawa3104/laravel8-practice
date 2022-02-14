@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">検査実績管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('inspections.create') }}">登録</a>
        </div>
        <div class="contents__content__table">
            <table class="list-table">
                <thead class="list-table__head">
                    <tr>
                        <th>カラム1</th>
                        <th>カラム2</th>
                        <th>カラム3</th>
                        <th>カラム4</th>
                    </tr>
                </thead>
                <tbody class="list-table__body">
                    @foreach ($inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->process->name }}</td>
                        <td>{{ $inspection->recordedProduct->recorded_number }}</td>
                        <td>{{ $inspection->recordedProduct->product->name }}</td>
                        <td><a class="button" href={{ route('inspections.edit', [$inspection->id]) }}>{{$inspection->inspectingForm()}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$inspections->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
