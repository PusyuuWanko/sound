# soundProducts/data.json の形式

サイトに並ぶ効果音の一覧データです。`index.php` が読み込み、1ページ6件ずつ表示します。

`data.json` 本体は音声をBase64で埋め込んでいて大きい(約3.8MB)ため、`.gitignore` でリポジトリから除外しています。
動かすときは、下の形式で `assets/soundProducts/data.json` を用意してください。
見本は [data.example.json](data.example.json) にあります。

## 全体

効果音1件を1オブジェクトとした **配列** です。配列の順番がそのまま表示順になります。

```json
[
  {
    "id": "ad28a7b968df",
    "headerName": "水",
    "description": "水の音です",
    "soundFile": "SUQzBAAAAAAA..."
  }
]
```

## 項目

| キー | 型 | 必須 | 内容 |
| --- | --- | --- | --- |
| `id` | 文字列 | ― | 12桁の16進数(例: `ad28a7b968df`)。各件で重複させない。今の `index.php` では使っていません |
| `headerName` | 文字列 | ○ | 効果音の名前。見出しと、ダウンロード時のファイル名になります |
| `description` | 文字列 | ○ | 効果音の説明文 |
| `soundFile` | 文字列 | ○ | MP3ファイルをBase64にした文字列。`data:` などの前置きは付けず、Base64部分だけを入れます |

## 注意

- 文字コードは **UTF-8** で保存してください。
- `soundFile` は `index.php` で `data:audio/mpeg;base64,` を前に付けて使うので、MP3以外の形式は想定していません。
- `headerName` と `description` はエスケープせずにHTMLへ出力されます。`<` や `>` などの記号は入れないでください。
- ファイルが無い・空・JSONとして壊れている場合は「まだ何もありません。」と表示されます。

## MP3からsoundFileを作る例

```sh
# Linux / macOS
base64 -w 0 sound.mp3 > sound.b64
```

```powershell
# Windows PowerShell
[Convert]::ToBase64String([IO.File]::ReadAllBytes("sound.mp3")) | Set-Content -NoNewline sound.b64
```
