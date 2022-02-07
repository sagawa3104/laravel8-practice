@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">品目管理</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button" href="{{ route('products.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>品目情報を入力</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('products.update') }}">
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">品目コード:</label>
                            <input class="form-input" type="text" id="code" name="product_code">
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">品目名称:</label>
                            <input class="form-input" type="text" id="name" name="product_name">
                        </div>
                        <button class="button" type="submit">更新</button>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
