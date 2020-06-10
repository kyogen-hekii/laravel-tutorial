# 入門Laravelチュートリアル
[参考](https://www.hypertextcandy.com/laravel-tutorial-todo-app-list-folders/)

## 手順
1. ルーティング
routes/web.php
	```php
  Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');
	```
	というわけでcontrollerが必要

2. コントローラ(仮)
`make appme`
`php artisan make:controller TaskController`
app/Http/Controllers/TaskController
  ```php
  return 'hello';
  ```

3. マイグレーション
`make appme`
`php artisan make:migration create_folders_table --create=folders`
database/migrationに yyyy_mm_dd_hhmmss_create_folders_table.php作成
  ```php
  $table->increments('id');
  $table->string('title', 20);
  ```
  こんな感じで記述するだけ
`make migrate`
  migrate自体は、管理者権限が必要...
  create_folders_tableとしたのでfoldersという名前でtableが作成される

4. モデル(=ORMでデータクラスとテーブルを紐づけて定義しておく)
`make appme`
`php artisan make:model Folder`
app/Folder
  ```php
  // 中身なし
  ```
	このモデルクラスがどのテーブルに対応しているかはクラス名から自動的に推定
	だから、特別記述が不要

5. seed
`php artisan make:seeder FoldersTableSeeder`
database/seeds/FoldersTableSeeder
  ```php
  DB::table('folders')->insert(['title' => $title,]);
  ```
  珍しく、useの記述も追加が必要
`make app`
`composer dump-autoload`
`php artisan db:seed --class=FoldersTableSeeder`
  最初の composer コマンドは、作成したシーダークラスをアプリケーションに認識させるためのもの

6. コントローラ
app/Http/Controllers/TaskController
  ```php
  $folders = Folder::all();
  return view('tasks/index', ['folders' => $folders,])
  ```

7. テンプレート
`code resources/views/tasks/index.blade.php`
  ```php
  @foreach($folders as $folder)
    <a href="{{ route('tasks.index', ['id' => $folder->id]) }}" class="list-group-item">
      {{ $folder->title }}
    </a>
  @endforeach
  ```
cssを変更
public/css/styles.css

8. パラメータに合わせて、viewに色を付ける
  コントローラ
  ```php
  public function index(int $id){}
  'current_folder_id' => $id,
  ```
  $idを引数で受け取るように書くとurlパラメータが受け取れる
  それをkey:valueで充てるだけ
  テンプレート
  ```php
  class="list-group-item {{ $current_folder_id === $folder->id ? 'active' : '' }}"
  ```
  ただのclass追加

## QA
1. `php artisan` で作成すると権限の問題が生じる
Makefileでこうやって対処した
```
appme:
  docker-compose exec --user $(shell id -u) app bash
```

## Tips
1. a5m2で接続できない
wsl2のubuntuのipを調べる(eth0)
`ip a`
他は同じ設定でよい

2. 矢印について
* =>
  key:valueの意味
* ->
  メソッドチェーン.の意味
    `$folder->id` こうやってつなげて書いてる笑

3. ログは?
`code storage/logs/laravel.log`

4. make create-objectについて
`docker-compose exec app composer create-project --prefer-dist laravel/laravel .`
これは
```sh
$ git clone https://github.com/laravel/laravel
$ cd laravel
$ composer install
```
※--prefer-distしているから実際はzipとってきて解凍している
