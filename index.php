<?php 

// 他のプロダクトの住所は台帳(pusyuu_registry)から受け取ります。無い環境では、
// 共有スクリプトや他のプロダクトへのリンクが「このホストの / から」に倒れるだけです。
$directry = "./../main/pusyuusystem/scripts/php_scripts/pusyuu_registry_client.php";
if (file_exists($directry)) {
  require_once($directry);
}

// 他のプロダクト(main 等)の住所の頭。台帳(pusyuu_registry)から決まります。
// 【ドメインを書き戻さないこと】以前はテンプレートに https://pusyuuwanko.com 等を固定で
// 書いていたため、IPやLAN、別のドメインから入った人の画面でも公開ドメインへ取りに
// 行っていました。$public は OGP のように、よそ(SNS)が取りに来るものだけ true。
// 台帳の係が無い・読めないときは空文字(=このページのホストの / から)に倒れます。
function soundSiteBase(string $id, bool $public = false): string {
  return class_exists('PusyuuRegistryClient') ? PusyuuRegistryClient::baseHtml($id, $public) : '';
}
$dir = "./";
$directry = $dir . "../main/pusyuusystem/scripts/php_scripts/panic_handler.php";
if (file_exists($directry)) {
  require_once($directry);
}

$directry = $dir . "../main/pusyuusystem/scripts/php_scripts/usage_tracker.php";
if (file_exists($directry)) {
  require_once($directry);
}
if (function_exists('pusyuuRecordProductUsage')) {
  pusyuuRecordProductUsage('sound');
}

$title = "プシューサービス - 効果音";
$description = "このページでは効果音のダウンロードができます、様々な生活音から下品な音までありますので効果音がほしい方はどうぞですー";
// og:image はSNSのカードが取りに来るので、台帳の公開の顔から組み立てます(soundSiteBase は下の一括置き換えで足したもの)。
$imageSrc = soundSiteBase("sound", true) . "/assets/images/sound-icon.png";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
function soundDispLogic() {
  global $page;
  $disp = '<p style="text-align: center">まだ何もありません。</p>';
  $soundInfoFile = "./assets/soundProducts/data.json";
  $soundInfos = json_decode(@file_get_contents($soundInfoFile), true);
  if (!empty($soundInfos) && count($soundInfos) >= 0) {
    $perPage = 6;
    $totalItems = count($soundInfos);
    $totalPages = ceil($totalItems / $perPage);

    $page = max(1, min($totalPages, intval($page)));
    $offset = ($page - 1) * $perPage;

    $soundItems = array_slice($soundInfos, $offset, $perPage);
    $disp = '<div class="sounds">';
    foreach($soundItems as $soundInfo) {
      $soundData = $soundInfo["soundFile"];
      $soundMime = "audio/mpeg";
      $sound = "data:$soundMime;base64," .  $soundData;
      $disp .= '<div class="box">';
      $disp .= '<video controls>';
      $disp .= '<source src="' . $sound . '" type="' . $soundMime . '">';
      $disp .= '<p style="color: #ff0000;">HTML5ビデオ非対応</p>';
      $disp .= '</video>';
      $disp .= '<div>';
      $disp .= '<h3>' . $soundInfo["headerName"] . '</h3>';
      $disp .= '<p>' . $soundInfo["description"] . '</p>';
      $disp .= '</div>';
      $disp .= '<a href="' . $sound . '" download="' . $soundInfo["headerName"] . '">ダウンロード</a>';
      $disp .= '</div>';
    }
    $disp .= '</div>';

    $disp .= '<div class="pagenation">';
    for ($i = 1; $i <= $totalPages; $i++) {
      if ($i == $page) {
        $disp .= "<strong>$i</strong> ";
      } else {
        $disp .= '<a href="?page=' . $i . '">' . $i . '</a> ';
      }
    }
    $disp .= '</div>';
  }
  return $disp;
}

$directry = $dir . "../main/pusyuusystem/scripts/php_scripts/notation.php";
if (file_exists($directry)) {
  require_once($directry);
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=6.0, minimum-scale=1.0" />
    <meta name='description' content="<?php echo $description; ?>" />
    <meta name="keywords" content="PusyuuPortfolio,プシューポートフォリオ,プシューわんこ/,プシュー" />
    <meta name="copyright" content="© 2020-2024 created by PusyuuWanko/" />
    <meta property="og:title" content="<?php echo($title); ?>" />
    <meta property="og:site_name" content="<?php echo($title); ?>" />
    <meta property="og:description" content="<?php echo($description); ?>" />
    <meta property="og:image" content="<?php echo $imageSrc; ?>" />
    <meta property="og:type" content="application" />
    <title><?php echo $title; ?></title>
    <link rel="manifest" href="./assets/documents/manifest.json" />
    <link href="./assets/styles/style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?= soundSiteBase('main') ?>/pusyuusystem/images/favicon.ico" />
    <script src="./assets/scripts/script.js"></script>
    <!-- privacy_notice.js の script タグより前に置く -->
    <script>
      window.PusyuuPrivacyNoticeConfig = {
        // ---- 機能1(初回アクセス時の自動お知らせ)のカスタマイズ ----
        title: "プライバシーに関するお知らせ",
        // bodyHtml: "<p>...</p>", // 本文を丸ごと差し替えたい場合のみ指定(指定すると下のserviceNameは使われなくなる)
        serviceName: "プシューサービス", // 省略時は特定サービス名を出さず一般論の文章になる
        fundingNote:
          '広告についての方針は<a href="<?= soundSiteBase('main') ?>/rules" ' +
          'target="_blank">ルールズ</a>をご覧ください。',
        closeButtonText: "同意する",
        hostsIntroText: "このページ読み込み時に検出した外部の通信先：",
        hostsNoneText: "このページ読み込み時には、外部への通信は検出されませんでした。",
        checkDelay: 1500,   // load後、検出確定までの待ち時間(ms)。既定1500
        maxHostDisplay: 10, // 検出したホスト名を一覧表示する最大件数。既定10
        storageKey: "pusyuu_privacy_notice_dismissed", // 表示済みフラグの保存キー名

        // ---- "js-dependency"プリセット(機能2)のカスタマイズ ----
        jsDependency: {
          level: "low", // このページの実情に合わせて "none" | "low" | "medium" | "high"
          brokenFeatures: [
            "ハンバーガーメニューの閉じる機能",
            "ページ読み込み時の演出の閉じる機能",
            "ページ内の一部アニメーション"
          ],
          fallbackNote:
            '詳しい方針は<a href="<?= soundSiteBase('main') ?>/rules/javascript/" ' +
            'target="_blank">JavaScriptの取り扱いに関する方針</a>をご覧ください。'
        },

        triggerCloseButtonText: "閉じる" // 機能2のモーダルの閉じるボタン文言
      };
    </script>
    <script src="<?= soundSiteBase('main') ?>/pusyuusystem/scripts/privacy_notice.js"></script>
    <script src="<?= soundSiteBase('main') ?>/pusyuusystem/scripts/request-indicator.js" data-include-async="true"></script>
    <!--
        *----------------------------------
        |  ThisPageVersion: 1.0.2       |
        |  © 2021-2024 By PusyuuWanko/  |
        |  LastUpdate: 2024-01-23       |
        |  License: MIT License         |
        |  (^U^)PusyuuKoukaon           |
      ----------------------------------*
    -->
  </head>
  <body>
  <div style="padding: 10px; width: 100%; color: #FFF; background: #ff0000;">現在作成中なため、思いもよらぬエラーやバグがある可能性があります。</div>
    <header class="header">
      <h1>効果音</h1>
    </header>
    <main>
      <?php echo soundDispLogic(); ?>
    </main>
    <footer class="footer">
      <div>
        <?php echo function_exists('notationDisp') ? notationDisp() : ''; ?>
      </div>
      <div>
        <?php echo function_exists('notationDisp') ? notationDisp("copyright") : ''; ?>
      </div>
    </footer>
  </body>
 </html>
