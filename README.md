# My Learning Post
このアプリは日々の学習をiPhoneの時計アプリにて時間を計っていた製作者が、グラフなどを用いてより学習成果の可視化を図りたいと思って作成しました。<br>
<br>
【URL】https://mylearningpost.net/ <br>
<br>
※ゲストログインボタンから簡単に動作確認を行えます<br>
<br>
![top1](https://user-images.githubusercontent.com/71583677/96410994-c0eede00-1222-11eb-97f8-5a87f5ac0026.png)<br>
![top2](https://user-images.githubusercontent.com/71583677/96411006-c3513800-1222-11eb-9a51-d9f5bda7935d.png)<br>
![top3](https://user-images.githubusercontent.com/71583677/96411012-c51afb80-1222-11eb-81c9-5ee3bc03b61b.png)<br>
<br>
<br>
# My Learning Postの特徴
このアプリはユーザー登録時に複数のスキルを選択し、その中から学習したスキルを選択して学習時間・コメントを入力することで投稿が出来ます。<br>
投稿された学習時間を元に、マイページにて日別の学習時間をグラフ出力し日々の学習成果を可視化します。<br>
各スキルの総学習時間が一定時間を超えるとスキルにアイコンが付き、より学習の成果を実感できるようになります。<br>
<br>
<br>
# インフラ構成図
ローカル環境はDockerを用いて環境構築を行ったのでAWSのECSを利用してデプロイしたかったのですがECRにDockerFileをプッシュすることが出来ず今回はEC2内にgit cloneしてデプロイを行いました。
<br><br>
デプロイの際に使用したAWSサービスは以下画像のようになります。<br><br><br>
![構成図](https://user-images.githubusercontent.com/71583677/96476423-21583c80-1270-11eb-8088-c0eabbb635f2.png)

# 実装済みの機能一覧
<ul>ユーザー
  <li>認証機能</li>
  <li>ゲストログイン機能</li>
  <li>マイページ機能</li>
  <li>プロフィール編集機能</li>
</ul>
<ul>投稿機能
  <li>投稿一覧</li>
  <li>投稿検索</li>
  <li>投稿編集</li>
  <li>投稿削除</li>
  <li>コメント機能</li>
  <li>いいね機能</li>
  <li>ページネーション</li>
</ul>
<ul>その他機能
  <li>グラフ描画機能</li>
</ul>

いいね機能とグラフ描画機能は非同期通信にて実装しており動的に変化します。<br>
また、全てのフォーム入力はJSとLaravel両方でバリデーションを行っております。<br>

# 使用技術一覧
<ul>
  <li>Sass</li>
  <li>PHP(Laravel)</li>
  <li>Javascript(jQuery)</li>
  <li>HTML/CSS</li>
</ul>
<ul>その他ライブラリ
  <li>Chart.js</li>
</ul>
<ul>開発環境
  <li>Docker</li>
  <li>PHP7.4</li>
  <li>Laravel6.8</li>
  <li>MySQL8.0</li>
</ul>
<ul>CI
  <li>CircleCI(導入予定)</li>
</ul>

※Dockerに関して<br>
DockerFileは自分が構築したい環境と同じ構成のものを検索して使用しました。<br>

# 追加・変更予定
レスポンシブ対応<br>
現在テストコードを書いているのでテスト機能を実装予定です。<br>
また、CircleCIも導入予定になります。<br>
Vue.jsの学習を進めているので今後JSファイルは全てVueで書き換えたいと思っています。
