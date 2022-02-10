@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">検査方式管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            {{-- <a class="button" href="{{ route('products.create') }}">登録</a> --}}
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
                    @foreach ($inspectingForms as $inspectingForm)
                    <tr>
                        <td>{{ $inspectingForm->process->name }}</td>
                        <td>{{ $inspectingForm->product->name }}</td>
                        <td>{{ $inspectingForm->form }}</td>
                        <td><a class="button" href={{ route('inspecting-forms.edit', [$inspectingForm->id]) }}>編集</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{-- {{$inspectingForms->links('pagination::bootstrap-4')}} --}}
    </div>
</div>
@endsection
