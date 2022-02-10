@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">検査方式管理&gt;変更</label>
    <div class="contents__content">
        <div class="contents__content__actions">
            <a class="button button--cancel" href="{{ route('inspecting-forms.index') }}">戻る</a>
        </div>
        <div class="contents__content__form">
            <div class="form-box">
                <div class="form-box__header">
                    <h1>検査方式を変更</h1>
                </div>
                <div class="form-box__content">
                    <form class="form" method="POST" action="{{ route('inspecting-forms.update', [$inspectingForm->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form__group">
                            <label class="form-label" for="code">工程:</label>
                            <input class="form-input" type="text" id="code" name="process" value="{{$inspectingForm->process->code. ':'. $inspectingForm->process->name}}" disabled>
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="name">品目:</label>
                            <input class="form-input" type="text" id="name" name="process" value="{{$inspectingForm->product->code. ':'. $inspectingForm->product->name}}" disabled>
                        </div>
                        <div class="form__group">
                            <label class="form-label" for="form">検査方式:</label>
                            <select class="form-input form-input--select" type="text" id="form" name="form">
                                <option value="">----</option>
                                <option value="CHECKLIST" {{$inspectingForm->form == 'CHECKLIST'? 'selected':''}}>CHECKLIST</option>
                                <option value="MAPPING" {{$inspectingForm->form == 'MAPPING'? 'selected':''}}>MAPPING</option>
                            </select>
                            @error('form')
                                <p class="form-message form-message--error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form__buttons">
                            <button class="button" type="submit">変更</button>
                        </div>
                    </form>
                </div>
                <div class="form-box__footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
