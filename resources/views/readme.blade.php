@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card w-75 m-auto">
        <div class="card-header">
            当Webアプリについて
        </div>
        <div class="card-body">
            <h3>実装済み機能一覧</h3>
            <p>・小説投稿</p>
            <p>・イラスト投稿</p>
            <p>・投稿した作品の個別ページでの閲覧</p>
            <p>・投稿作品の編集</p>
            <p>・登録済みユーザーのプロフィールページ</p>

            <p>※今後実装予定の機能例<br>
            作品の削除機能、作品の検索機能、プロフィール編集機能、作品のサムネイル設定、ユーザーのフォロー機能、ブックマーク・いいね機能　等
            </p>

            <h3>制作期間・工数（2021年5月17日現在）</h3>
            <p>2021年3月21日～4月4日（約7時間）<br>
            要件定義、DB設計</p>
            <p>2021年4月5日～現在（約100時間）<br>
            マークアップ、プログラミング、テスト、修正等</p>

            <h3>開発環境</h3>
            <p>PC：Windows 10<br>
            仮想マシン：Vagrant + VirtualBox<br>
            Laravel 5.8<br>
            PHP 7.2<br>
            テンプレートエンジン：blade</p>
        </div>
    </div>
</div>
@endsection
