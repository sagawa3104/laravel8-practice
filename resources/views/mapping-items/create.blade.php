@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">マッピング項目管理&gt;登録</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('mapping-items.index', [$processPart->id]) }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>マッピング項目情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('mapping-items.store', [$processPart->id]) }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">マッピング項目コード:</label>
                            <input class="form-input" type="text" id="code" name="mapping_item_code">
                            @error('mapping_item_code')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="content">マッピング項目内容:</label>
                            <input class="form-input" type="text" id="content" name="mapping_item_content">
                            @error('mapping_item_content')
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
