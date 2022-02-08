@extends('layouts.app')

@section('content')

<div class="contents-wrapper">
    <label class="contents__title">Home</label>
    <div class="contents__content">
        <p>ログイン後ページ</p>
        <br>
        <p>メモ</p>
        <ul class="vertical-list">
            <li>品目
                <ul class="vertical-list">
                    <li>品目は複数の部位を持つ</li>
                    <li>品目は複数の仕様を持つ</li>
                </ul>
            </li>
            <li>部位
                <ul class="vertical-list">
                    <li>部位は複数の品目に適用される</li>
                    <li>部位は一枚の図面を持つ</li>
                </ul>
            </li>
            <li>仕様
                <ul class="vertical-list">
                    <li>仕様は複数の品目に適用される</li>
                    <li>部位は一枚の図面を持つ</li>
                </ul>
            </li>
            <li>検査方式
                <ul class="vertical-list">
                    <li>チェックリスト方式とマッピング方式がある</li>
                    <li>検査方式は工程によって決まる</li>
                </ul>
            </li>
            <li>検査項目
                <ul class="vertical-list">
                    <li>チェックリスト方式の場合、品目の仕様および製番ごとの専用仕様から構成される</li>
                    <li>マッピング方式の場合、工程・部位ごとの検査項目から構成される</li>
                </ul>
            </li>
            <li>検査
                <ul class="vertical-list">
                    <li>製造番号・工程ごとに実施される</li>
                    <li>検査結果として検査項目を複数持つ</li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@endsection
