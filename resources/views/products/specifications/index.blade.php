@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">品目別仕様管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('products.index') }}">戻る</a>
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
                    @foreach ($productSpecifications as $productSpecification)
                    <tr>
                        <td>{{ $productSpecification->productSpecification->product->name }}</td>
                        <td>{{ $productSpecification->content }}</td>
                        <td><a class="button" href="#">編集</a></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="list-table__foot">
                </tfoot>
            </table>
        </div>
        {{-- ペジネータを作る --}}
        {{$productSpecifications->links('pagination::bootstrap-4')}}
    </div>
</div>
@endsection
