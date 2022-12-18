<?php
  if(isset($_POST['download'])){//if download btn clicked
    $imgUrl = $_POST['imgurl'];  //getting img url from hidden input
    $ch = curl_init($imgUrl); //initializing curl
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); ; //it transfers data as the return value of curl_exec rather than outputting it directly
    $downloadImg = curl_exec($ch); //executing curl
    curl_close($ch); //closing curl session
    header('Content-type: image/jpg'); //setting content-type of header to imagzapg so we can get img in jpg not in base64 format
    header('Content-Disposition: attachment;filename="thumbnail.jpg"'); //setting Content-Disposition to attachment to indicating browser this file should download with give file name
    echo $downloadImg; //download img in jpg format
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <title>Thumbnail Downloader</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
  </head>
  <body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <header>Download Thumbnail</header>
      <div class="url-input">
        <span class="title">Paste video ur1:</span>
        <div class="field">
          <input
            type="text"
            placeholder="https://www.youtube.com/watch?v=1qwdD2ivIbM"
            required
          />
          <input class= "hidden-input" type="hidden" name="imgurl">
          <div class="bottom-line"></div>
        </div>
      </div>
      <div class="preview-area">
        <img class="thumbnail" src="" alt="thumbnail" />
        <i class="icon fas fa-cloud-download-alt"></i>
        <span>Paste video url to see preview</span>
      </div>
      <button class="download-btn" type="submit"name="download">Download Thumbnail</button>
    </form>

    <script>
  const urlField = document.querySelector(".field input"),
  previewArea  = document.querySelector(".preview-area"),
  imgTag = previewArea.querySelector(".thumbnail");
  hiddenInput = document.querySelector(".hidden-input");
  
  urlField. onkeyup = ()=>{
   let imgUrl = urlField. value; //getting user entered value
   previewArea.classList.toggle("active");


 //https://www.youtube.com/watch?v=1qwdD2ivIbM example of video url--- lqwdD2ivIbM this is a video id and it's unique

 if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){  //if entered value is yt video url
  let vidId = imgUrl.split('v=')[1].substring(0, 11); //splitting yt video url from V= so we can get only video
  let ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg` //passing entered url video id inside ty thumbnail url
  imgTag.src = ytThumbUrl; //passing yt thumb url inside img src

} else if(imgUrl.indexOf("https://youtu.be/") != -1){ //if video url is looke like this
    let vidId = imgUrl.split("be/")[1].substring(0, 11); //splitting yt video url from V= so we can get only video
    let  ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;//passing entered url video id inside ty thumbnail url
    imgTag.src = ytThumbUrl; //passing yt thumb url inside img src


}else if(imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)){ //if entered value is other image file url
    imgTag. src = imgUrl; //passing user entered url inside img src

}else{
   imgTag.src ="";
  previewArea.classList. remove("active");

}
hiddenInput.value = imgTag.src; //passing img src to hidden input value

}

    </script>
  </body>
</html>
