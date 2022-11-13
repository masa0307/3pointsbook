# 読書での学びを行動に移すwebアプリケーション『3PointsBook』

読書時のインプットとアウトプットを効率化するアプリケーションです。  
上記の効率化を図るため、本アプリでは記録箇所を以下のようにそれぞれ『3つ』に分類しています。  
- 読書メモ
    - 読書前（目次から学びたい内容を３点選び、記載する箇所）
    - 読書中（自由なメモを記載する箇所）
    - 読書後（読書前に記載した３点について、学んだ内容を記載する箇所）
- アクションリスト
    - アクションリスト1(読書した結果、行動に移すことを記載する箇所)
    - アクションリスト2
    - アクションリスト3
- 振り返り
    - 振り返り1（行動した結果の振り返りを記載する箇所）
    - 振り返り2
    - 振り返り3  

# 開発経緯

実用書においては「今の自分が抱える問題」を解決するために読むことが想定されますが、読むこと自体に満足してしまい、問題解決に至っていないことが多いという課題が見つかりました。  
上記課題の原因としては、インプットした情報をアウトプット（行動）に移せていないことであると考えました。  
この原因を解消し、課題を解決するために本アプリを開発しました。  
URL：https://3pointsbook.com/  
※サンプルメールアドレス：testusersan123@gmail.com  
※パスワード：test1234  

# 基本操作説明  
### ■本の登録  
1. 本のタイトルを入力し、検索
2. 表示結果から該当の本をクリックし、表示された情報に誤りがないか確認後、情報を保存
3. top画面に登録した情報が表示
  
![add-book](https://raw.github.com/wiki/masa0307/3pointsbook/images/add-book.gif)

### ■メモの登録  
1. 読書メモ欄にメモする  
※読書前欄からメモしないとエラーが発生する  
※読書メモ欄に関しては、読書前、読書中、読書後でメモのタイミングが異なることから、各欄ごとにメモすることが可能な仕様としている  
2. アクションリスト欄→振り返り欄の順にメモする
  
![book-memo](https://raw.github.com/wiki/masa0307/3pointsbook/images/book-memo.gif)
![actionlist-memo](https://raw.github.com/wiki/masa0307/3pointsbook/images/actionlist-memo.gif)
![feedback-memo](https://raw.github.com/wiki/masa0307/3pointsbook/images/feedback-memo.gif)

### ■メモを共有するグループの作成
1. グループを新たに作成
2. ユーザーを検索し、グループに招待  
※不必要な招待の発生を防止するため、完全一致検索とした  
3. 招待されたユーザーのTop画面では招待通知が表示
4. 招待を受けたユーザーが「参加する」をクリックするとグループへ追加され、グループ内で公開されたメモが閲覧可能

![create-group](https://raw.github.com/wiki/masa0307/3pointsbook/images/create-group.gif)

### ■メモの共有
1. 本の詳細ページから「メモの公開・非公開」ボタンをクリック
2. グループを選択し、メモを公開   
3. グループ内のユーザーは公開されたメモを閲覧可能  

![share-memo](https://raw.github.com/wiki/masa0307/3pointsbook/images/share-memo.gif)
 
# 使用技術
■バックエンド
- PHP 8.0.25  
- Laravel 8.83.23  

■フロントエンド
- HTML  
- CSS  
- JavaScript   
- Tailwind CSS 3.2.4

■インフラ
- mysql 8.0.30
- AWS(VPC, EC2, RDS, Route53, ALB, ACM)
- Docker 20.10.17 / Docker compose 2.12.0

■その他の使用技術
- Git(GitHub) 
- Visual Studio Code 
- Figma(画面遷移図)
- Lucidchart(ER図) 
- Draw.io(AWS構成図)

# インフラ構成図

![infra](https://raw.github.com/wiki/masa0307/3pointsbook/images/infra.png)

# DB設計
- ER図
![ER](https://raw.github.com/wiki/masa0307/3pointsbook/images/ER.png)

- テーブル定義
![table](https://raw.github.com/wiki/masa0307/3pointsbook/images/table.png)

# 画面遷移図
※ 一部のみ
![screen-transition](https://raw.github.com/wiki/masa0307/3pointsbook/images/screen-transition.png)

