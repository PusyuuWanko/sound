/*****************************************
  *----------------------------------
  |  ThisStyleVersion: 1.1.1      |
  |  © 2021-2024 By PusyuuWanko/  |
  |  LastUpdate: 2024-11-23       |
  |  License: MIT License         |
  |  (^U^)PusyuuKoukaon           |
----------------------------------*
******************************************/

document.addEventListener("DOMContentLoaded", function () {
/*  const container = document.getElementById("boxContainer");
  fetch("../soundProducts/data.json")
    .then(response => response.json())
    .then(data => {
      const boxesData = data;
      initializePage(boxesData);
    })
    .catch(error => {
      alert("内部エラー：" + error + " このエラーの対処について：あなたにできることはありません、開発者にこのことをいち早く伝えてください。");
      container.innerHTML = "内部エラー：" + error;
    });

  function initializePage(boxesData) {
    container.innerHTML = "";
    boxesData.forEach(function (boxData) {
      const box = document.createElement("div");
      box.className = "box";
      const video = document.createElement("video");
      video.src = boxData.videoSrc;
      video.controls = true;
      video.innerHTML = "<p>HTML5 VIDEO非対応です。</p>";
      const audioLink = document.createElement("a");
      audioLink.href = boxData.audioHref;
      audioLink.download = "audio_file.m4a";
      audioLink.textContent = "ダウンロード";
      // Add click event listener to initiate download
      audioLink.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default link behavior
        downloadAudio(boxData.audioHref);
      });
      const descriptionDiv = document.createElement("div");
      const descriptionHeading = document.createElement("h2");
      descriptionHeading.textContent = boxData.headerName;
      const descriptionParagraph = document.createElement("p");
      descriptionParagraph.textContent = boxData.description;
      descriptionDiv.appendChild(descriptionHeading);
      descriptionDiv.appendChild(descriptionParagraph);
      box.appendChild(video);
      box.appendChild(audioLink);
      box.appendChild(descriptionDiv);
      container.appendChild(box);
    });
  }

  function downloadAudio(audioSrc) {
    fetch(audioSrc)
      .then(response => response.blob())
      .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "audio_file.m4a";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
      });
  }*/
  
  var soundvideo = Array.prototype.slice.call(document.querySelectorAll("sounds > box > video"));
  if (soundvideo) {
    soundvideo.forEach(function() {
      soundvideo.addEventListener("click", function() {
        soundvideo.play();
      });
    });
  }

  const info =
    "注意：基本利用は自由ですが、商標利用の際はプシューサービスのリンク'https://pusyuuwanko.com'の記述をしてください。詳しくは下部にあるヘッダー内の利用規約プライバシーポリシーをご覧ください。";
  let visitedBefore = sessionStorage.getItem("koukaonVisited");
  if (visitedBefore === null) {
    alert(info);
    sessionStorage.setItem("koukaonVisited", "true");
  } else {
    ;
  }
});
