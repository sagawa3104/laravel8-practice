@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">仕様管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('specifications.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>仕様情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('specifications.store') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">仕様コード:</label>
                            <input class="form-input" type="text" id="code" name="specification_code">
                            @error('specification_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="content">仕様内容:</label>
                            <input class="form-input" type="text" id="content" name="specification_content">
                            @error('specification_content')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="button" type="submit">登録</button>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
