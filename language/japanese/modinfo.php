<?php

define('_MI_USER_ADMENU_AVATAR_MANAGE', 'アバター管理');
define('_MI_USER_ADMENU_GROUP_LIST', 'ユーザーグループ管理');
define('_MI_USER_ADMENU_LIST', 'ユーザー管理');
define('_MI_USER_ADMENU_MAIL', '一斉メール送信');
define('_MI_USER_ADMENU_MAILJOB_MANAGE', 'メールジョブ管理');
define('_MI_USER_ADMENU_RANK_LIST', 'ユーザーランク管理');
define('_MI_USER_ADMENU_USER_SEARCH', 'ユーザー検索');
define('_MI_USER_BLOCK_LOGIN_DESC', 'ログインフォームを表示します');
define('_MI_USER_BLOCK_LOGIN_NAME', 'ログイン');
define('_MI_USER_BLOCK_NEWUSERS_DESC', '新しい登録ユーザの一覧を表示します');
define('_MI_USER_BLOCK_NEWUSERS_NAME', '新しい登録ユーザ');
define('_MI_USER_BLOCK_ONLINE_DESC', 'オンライン状況を表示します');
define('_MI_USER_BLOCK_ONLINE_NAME', 'オンライン状況');
define('_MI_USER_BLOCK_TOPUSERS_DESC', '投稿数のランキングを表示します');
define('_MI_USER_BLOCK_TOPUSERS_NAME', '投稿数ランキング');
define('_MI_USER_CONF_ACTV_ADMIN', '管理者が確認してアカウントを有効にする');
define('_MI_USER_CONF_ACTV_AUTO', '自動的にアカウントを有効にする');
define('_MI_USER_CONF_ACTV_GROUP', 'アカウント有効化依頼のメールの送信先グループ');
define('_MI_USER_CONF_ACTV_GROUP_DESC', '「管理者が確認してアカウントを有効にする」設定になっている場合のみ有効です');
define('_MI_USER_CONF_ACTV_TYPE', '新規登録ユーザアカウントの有効化の方法');
define('_MI_USER_CONF_ACTV_USER', 'ユーザ自身の確認が必要(推奨)');
define('_MI_USER_CONF_ALLOW_REGISTER', '新規ユーザの登録を許可する');
define('_MI_USER_CONF_ALW_RG_DESC', '「はい」を選択すると新規ユーザの登録を許可します。');
define('_MI_USER_CONF_AVATAR_HEIGHT', 'アバター画像の最大高さ(ピクセル)');
define('_MI_USER_CONF_AVATAR_MAXSIZE', 'アバター画像の最大ファイルサイズ(バイト)');
define('_MI_USER_CONF_AVATAR_MINPOSTS', 'アバターアップロード権を得るための発言数');
define('_MI_USER_CONF_AVT_MIN_DESC', 'ユーザが自分で作成したアバターをアップロードするために必要な最低投稿数を設定してください。');
define('_MI_USER_CONF_AVATAR_WIDTH', 'アバター画像の最大幅(ピクセル)');
define('_MI_USER_CONF_AVTR_ALLOW_UP', 'アバター画像のアップロードを許可する');
define('_MI_USER_CONF_BAD_EMAILS', 'ユーザのemailアドレスとして使用できない文字列');
define('_MI_USER_CONF_BAD_EMAILS_DESC', 'それぞれの文字列の間は|で区切ってください。大文字小文字は区別しません。正規表現が使用可能です。');
define('_MI_USER_CONF_BAD_UNAMES', 'ユーザ名として使用できない文字列');
define('_MI_USER_CONF_BAD_UNAMES_DESC', 'それぞれの文字列の間は|で区切ってください。大文字小文字は区別しません。正規表現が使用可能です。');
define('_MI_USER_CONF_CHGMAIL', 'ユーザ自身のEmailアドレス変更を許可する');
define('_MI_USER_CONF_DISCLAIMER', '利用許諾文');
define('_MI_USER_CONF_DISCLAIMER_DESC', 'ユーザの新規登録ページに表示する利用許諾文を入力してください。');
define(
    '_MI_USER_CONF_DISCLAIMER_DESC_DEFAULT',
    "本規約は、当サイトにより提供されるコンテンツの利用条件を定めるものです。以下の利用条件をよくお読みになり、これに同意される場合にのみご登録いただきますようお願いいたします。\n\n当サイトを利用するにあたり、以下に該当する又はその恐れのある行為を行ってはならないものとします。 \n\n・公序良俗に反する行為 \n・法令に違反する行為 \n・犯罪行為及び犯罪行為に結びつく行為 \n・他の利用者、第三者、当サイトの権利を侵害する行為 \n・他の利用者、第三者、当サイトを誹謗、中傷する行為及び名誉・信用を傷つける行為 \n・他の利用者、第三者、当サイトに不利益を与える行為 \n・当サイトの運営を妨害する行為 \n・事実でない情報を発信する行為 \n・プライバシー侵害の恐れのある個人情報の投稿 \n・その他、当サイトが不適当と判断する行為 \n\n【免責】\n\n利用者が当サイト及び当サイトに関連するコンテンツ、リンク先サイトにおける一切のサービス等をご利用されたことに起因または関連して生じた一切の損害（間接的であると直接的であるとを問わない）について、当サイトは責任を負いません。"
);
define('_MI_USER_CONF_DISPDSCLMR', '利用許諾文を表示する');
define('_MI_USER_CONF_DISPDSCLMR_DESC', '「はい」にするとユーザの新規登録ページに利用許諾の文章を表示します。');
define('_MI_USER_CONF_MAXUNAME', 'ユーザ名の最大文字数(byte)');
define('_MI_USER_CONF_MINPASS', 'パスワードの最低文字数');
define('_MI_USER_CONF_MINUNAME', 'ユーザ名の最低文字数(byte)');
define('_MI_USER_CONF_NEW_NTF_GROUP', '通知先グループ');
define('_MI_USER_CONF_NEW_USER_NOTIFY', '新規ユーザ登録の際にメールにて知らせを受け取る');
define('_MI_USER_CONF_SELF_DELETE', 'ユーザが自分自身のアカウントを削除できる');
define('_MI_USER_CONF_SELF_DELETE_CONF', 'アカウント削除前の確認メッセージ');
define('_MI_USER_CONF_SELF_DELETE_CONFIRM_DEFAULT', "ユーザアカウントを本当に削除しても良いですか？\nアカウントを削除した場合、全てのユーザ情報が失われます。");
define('_MI_USER_CONF_SSLLOGINLINK', 'SSLログインページへのURL');
define('_MI_USER_CONF_SSLPOST_NAME', 'SSLログイン時に使用するPOST変数の名称');
define('_MI_USER_CONF_UNAME_TEST_LEVEL', 'ユーザ名として使用可能な文字の設定を行います。文字制限の程度を選択してください。');
define('_MI_USER_CONF_UNAME_TEST_LEVEL_NORMAL', '中');
define('_MI_USER_CONF_UNAME_TEST_LEVEL_STRONG', '強（アルファベットおよび数字のみ）←推奨');
define('_MI_USER_CONF_UNAME_TEST_LEVEL_WEAK', '弱（漢字・平仮名も使用可）');
define('_MI_USER_CONF_USE_SSL', 'ログインにSSLを使用する');
define('_MI_USER_CONF_USERCOOKIE', 'ユーザ名の保存に使用するクッキーの名称');
define('_MI_USER_CONF_USERCOOKIE_DESC', 'このクッキーにはユーザ名のみが保存され、ユーザのPCのハードディスク中に1年間保管されます。このクッキーを使用するかしないかはユーザ自身が選択できます。');
define('_MI_USER_KEYWORD_AVATAR_MANAGE', 'アバター カスタムアバター システムアバター  一覧 リスト 編集 変更 削除');
define('_MI_USER_KEYWORD_CREATE_AVATAR', 'アバター カスタムアバター システムアバター 新規作成 アップロード');
define('_MI_USER_KEYWORD_CREATE_GROUP', '新規作成 ユーザーグループ');
define('_MI_USER_KEYWORD_CREATE_RANK', 'ランク ユーザーランク');
define('_MI_USER_KEYWORD_CREATE_USER', '新規登録');
define('_MI_USER_KEYWORD_GROUP_LIST', 'グループ 一覧 リスト 編集 変更  削除 ユーザー ユーザグループ 権限 パーミッション 追加 メンバー');
define('_MI_USER_KEYWORD_MAILJOB_LINK_LIST', 'Mailjob link list');
define('_MI_USER_KEYWORD_MAILJOB_MANAGE', 'Mailjob manage');
define('_MI_USER_KEYWORD_USER_LIST', '一覧 リスト 編集 変更 削除');
define('_MI_USER_KEYWORD_USER_SEARCH', 'ユーザー 検索');
define('_MI_USER_LANG_MAILJOB_LINK_LIST', 'Mailjob link list');
define('_MI_USER_MENU_CREATE_AVATAR', 'アバターの新規作成');
define('_MI_USER_MENU_CREATE_GROUP', 'グループの新規作成');
define('_MI_USER_MENU_CREATE_RANK', 'ランクの新規作成');
define('_MI_USER_MENU_CREATE_USER', 'ユーザーの新規作成');
define('_MI_USER_NAME', 'ユーザーモジュール');
define('_MI_USER_NAME_DESC', 'ユーザーアカウントに関する処理を行う基盤モジュール');
