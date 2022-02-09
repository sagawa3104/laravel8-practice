@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">工程管理&gt;変更</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('processes.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>工程情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('processes.update', [$process->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">工程コード:</label>
                            <input class="form-input form-input" type="text" id="code" name="process_code" value="{{$process->code}}" disabled>
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">工程名称:</label>
                            <input class="form-input" type="text" id="name" name="process_name" value="{{$process->name}}">
                            @error('process_name')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
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
                        <h1>{{$process->code. ':' .$process->name}}</h1>
                    </div>
                    <div class="form-box__content">
                        <p>本当に削除しますか？</p>
                    </div>
                    <div class="form-box__footer">
                        <form method="POST" action="{{ route('processes.destroy', [$process->id])}}" >
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
