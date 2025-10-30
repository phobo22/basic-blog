<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>PTB Blog</title>
</head>
<body>
    <?php require_once "./sidebar.php";?>
    <main class="content">
        <h1 id="main-title">Welcome</h1>
        <div class="main-blog">
            <div class="article-wrapper">
                <div class="article-form">
                    <form id="add-post" method="POST" enctype="multipart/form-data">
                        <textarea id="text" name="text" placeholder="Tell something to the world...,"></textarea>
                        <div class="btn-controller">
                            <div class="form-content">
                                <label for="image"><img id="image-img" src="../../assets/img/image.png"></label>
                                <input id="image" name="image" type="file" accept="image/*">
                                <div class="imagename"></div>
                            </div>
                            <button type="submit" id="post-btn" name="post-btn" value="post"><img id="send-img" src="../../assets/img/send.png"></button>
                        </div>
                        <p class="add-article-form-error"></p>
                    </form>
                </div>

                <div class="article-error-msg"></div>
                <div class="article-container">
                    <!-- <div class="article">
                        <div class="info">
                            <h2 id="user-name">${article["username"]}</h2>
                            <h5 id="posted-time">${article["posted_at"]}</h5>
                        </div>
                        <p id="post-text">${article["text_content"]}</p>
                        <img id="post-img" src="${(article["file_name"]) ? article["file_name"] : ""}">
                        <div class="controller-btn">
                            <button id="like-btn"><img class="like-img" id="${article["id"]}" src="../../assets/img/heart.png"></button>
                            <button id="cmt-btn"><img class="cmt-img" id="${article["id"]}" src="../../assets/img/chat.png"></button>
                        </div>
                    </div> -->
                </div>
            </div>

            <div class="article-cmt-container" style="display:none">
                <div class="header">
                    <h2>Comments about this Post</h2>
                    <a id="close-btn"><img id="close-cmt-btn" src="../../assets/img/close.png"></a>
                </div>

                <p class="cmt-error-container"></p>
                <div class="msg-container">
                    <!-- <div class="cmt-msg-container">
                        <span id="user">asd</span>
                        <p>ajkhdkasjhdakjshdjksakjhdkjsah</p>
                        <span id="cmt-time">1h</span>
                    </div> -->
                </div>

                <div class="cmt-container">
                    <!-- <form id="cmt-form" method="POST">
                        <input type="text" name="cmt-msg" id="cmt-msg" placeholder="What you want to say?">
                        <button type="submit"><img id="send-cmt-img" src="../../assets/img/send.png"></button>
                    </form> -->
                </div>
            </div>
        </div>
    </main>
    <script src="../js/dashboard.js"></script>
</body>
</html>