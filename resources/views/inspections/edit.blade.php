@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">検査実績管理&gt;明細</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('inspections.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>検査実績明細情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('inspections.update', [$inspection->id]) }}">
                        @method('PUT')
                        @csrf
                        @foreach ($parts as $part)
                            <label class="form-label" for="form">{{$part->name}}:</label>
                            <select class="form-input form-input--select" type="text" id="form" name="form">
                                <option value="">----</option>
                                @foreach ($part->mapping_items as $mappingItem)
                                    <option value="{{$mappingItem->id}}" >{{$mappingItem->code. ':'. $mappingItem->content}}</option>
                                @endforeach
                            </select>
                        @endforeach
                        <div class="form__buttons">
                            <button class="button" type="submit">変更</button>
                            <a class="button button--delete" href="#modal_id">削除</a>
                        </div>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
        <div class="modal-wrapper" id="modal_id">
            <a href="#!" class="modal-wrapper__overlay"></a>
            <div class="modal-wrapper__window">
                <a href="#!" class="modal-wrapper__window__close-mark">X</a>
                <div class="form-box">
                    <div class="form-box__header">
                        <h1>{{$part->code. ':' .$part->name}}</h1>
                    </div>
                    <div class="form-box__content">
                        <p>本当に削除しますか？</p>
                    </div>
                    <div class="form-box__footer">
                        <form method="POST" action="{{ route('parts.destroy', [$part->id])}}" >
                            @method('DELETE')
                            @csrf
                            <button class="button" type="submit">削除</button>
                            <a class="button button--cancel" href="#!">キャンセル</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
