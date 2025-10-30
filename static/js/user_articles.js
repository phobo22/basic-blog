// add article form
const addPostForm = document.getElementById("add-post");
const addPostError = document.querySelector(".add-article-form-error");
const imageEle = document.getElementById("image");
const imagenameEle = document.querySelector(".imagename");

// article dislay controller
const articleErrorDisplay = document.querySelector(".article-error-msg");
let articlesDisplay = document.querySelector(".article-container");

// comment controller
const commentDisplay = document.querySelector(".article-cmt-container");
const closeBtn = document.getElementById("close-btn");
const cmtErrorDisplay = document.querySelector(".cmt-error-container");
let cmtDisplay = document.querySelector(".msg-container");
let addCmtForm = document.querySelector(".cmt-container");

// get likes data from database
async function getLikesInfo(articleId) {
    const response = await fetch(`../../src/articles/user_liked.php?articleId=${articleId}`, {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when calling get user liked API");
    }

    return response.json();
}

// get articles from database
async function getArticles() {
    const response = await fetch("../../src/articles/get_user_article.php", {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when calling get articles API");
    }
    return response.json();
}

// display article from database
async function displayArticle(article) {
    // get likes data of this article
    const likeResponse = await getLikesInfo(article["id"]);
    if (likeResponse["success"] === false) {
        throw new Error(likeResponse["msg"]);
    }
    
    // check if this user like this article
    const data = likeResponse["data"];
    const imgPath = (data["liked"] == 1) ? "../../assets/img/red_heart.png" : "../../assets/img/heart.png";

    // get number of comments
    const commentResponse = await getNumberOfComment(article["id"]);
    const numberOfComments = commentResponse["cmt_count"];

    articlesDisplay.innerHTML += `
        <div class="article">
            <div class="header">
                <div class="info">
                    <h2 id="user-name">${article["username"]}</h2>
                    <h5 id="posted-time">${article["posted_at"]}</h5>
                </div>
                <button id="delete-post-btn"><img class="delete-img" id="delete-${article["id"]}" src="../../assets/img/close.png"></button>
            </div>
            <p id="post-text">${article["text_content"]}</p>
            <img id="post-img" src="${(article["file_name"]) ? article["file_name"] : ""}">
            <div class="controller-btn">
                <button id="like-btn"><img class="like-img" id="like-${article["id"]}" src="${imgPath}"></button>
                <span class="like-count" id="like-${article["id"]}-display">${data["like_count"]}</span>
                <button id="cmt-btn"><img class="cmt-img" id="cmt-${article["id"]}" src="../../assets/img/chat.png"></button>
                <span class="cmt-count" id="cmt-${article["id"]}-display">${numberOfComments}</span>
            </div>
        </div>
    `;
}

// display add article
async function displayAddArticle(article) {
    // get likes data of this article
    const likeResponse = await getLikesInfo(article["id"]);
    if (likeResponse["success"] === false) {
        throw new Error(likeResponse["msg"]);
    }
    
    // check if this user like this article
    const data = likeResponse["data"];
    const imgPath = (data["liked"] == 1) ? "../../assets/img/red_heart.png" : "../../assets/img/heart.png";

    // get number of comments
    const commentResponse = await getNumberOfComment(article["id"]);
    const numberOfComments = commentResponse["cmt_count"];

    articlesDisplay.innerHTML += `
        <div class="article">
            <div class="header">
                <div class="info">
                    <h2 id="user-name">${article["username"]}</h2>
                    <h5 id="posted-time">${article["posted_at"]}</h5>
                </div>
                <button id="delete-post-btn"><img class="delete-img" id="${article["id"]}" src="../../assets/img/close.png"></button>
            </div>
            <p id="post-text">${article["text_content"]}</p>
            <img id="post-img" src="${(article["file_name"]) ? article["file_name"] : ""}">
            <div class="controller-btn">
                <button id="like-btn"><img class="like-img" id="${article["id"]}" src="${imgPath}"></button>
                <span class="like-count" id="like-${article["id"]}-display">${data["like_count"]}</span>
                <button id="cmt-btn"><img class="cmt-img" id="${article["id"]}" src="../../assets/img/chat.png"></button>
                <span class="cmt-count" id="cmt-${article["id"]}-display">${numberOfComments}</span>
            </div>
        </div>
    `;
}

// display articles on page
async function displayAllArticles() {
    try {
        const response = await getArticles();
        if (response["success"] === false) {
            articleErrorDisplay.innerText = response["msg"];
        } else {
            let articles = response["data"];
            if (articles.length === 0) {
                articleErrorDisplay.innerText = "You have not have any articles yet";
            } else {
                articles.sort((a, b) => new Date(b.posted_at) - new Date(a.posted_at));
                for (const article of articles) {
                    await displayArticle(article);
                }
            }
        }
    } catch (error) {
        articleErrorDisplay.innerText = error;
    }
}

// get all comments of an article
async function getComments(articleId) {
    const response = await fetch(`../../src/articles/get_comment.php?id=${articleId}`, {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when calling get comment API");
    }
    return response.json();
}

// display a comment
function displayComment(cmt) {
    cmtDisplay.innerHTML += `
        <div class="cmt-msg-container">
            <span id="user">${cmt["username"]}</span>
            <p id="cmt-content">${cmt["content"]}</p>
            <span id="cmt-time">${cmt["commented_at"]}</span>
        </div>
    `;
}

// display all comments on page
async function displayAllComments(articleId) {
    try {
        const response = await getComments(articleId);
        if (response["success"] === false) {
            cmtErrorDisplay.innerText = response["msg"];
        } else {
            let comments = response["data"];
            if (comments.length === 0) {
                cmtErrorDisplay.innerText = "No one has commented about this article";
            } else {
                comments.sort((a, b) => new Date(b.commented_at) - new Date(a.commented_at));
                for (const comment of comments) {
                    displayComment(comment);
                }
            }
        }
    } catch (error) {
        cmtErrorDisplay.innerText = error;
    }
}

// add article event
addPostForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(addPostForm);
        const response = await fetch("../../src/articles/post_article.php", {
            method: "POST",
            body: formData,
        })

        if (!response.ok) {
            throw new Error("Error when calling add article API");
        }

        const data = await response.json();
        addPostError.innerText = data["msg"];
        articlesDisplay.innerHTML = "";
        await displayAllArticles();
    } catch (error) {
        addPostError.innerText = error;
    }
})

// change chosen image file name
imageEle.addEventListener("change", () => {
    if (imageEle.files.length > 0) {
        imagenameEle.innerHTML = `<p>${imageEle.files[0].name}</p>`;
        imagenameEle.style.display = "block";
    }
})

async function modifyLikeArticle(articleId, mode) {
    const response = await fetch(`../../src/articles/modify_like.php?article_id=${articleId}`, {
        method: mode,
    })
}

async function getNumberOfComment(articleId) {
    const response = await fetch(`../../src/articles/get_comment_count.php?id=${articleId}`, {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when calling get number of comments API");
    }

    return response.json();
}

async function deleteArticle(articleId) {
    const response = await fetch(`../../src/articles/delete_article.php?id=${articleId}`, {
        method: "DELETE",
    })

    if (!response.ok) {
        throw new Error("Error when calling delete article API");
    }

    return response.json();
}

// like and comment button
articlesDisplay.addEventListener("click", async (e) => {
    e.preventDefault();
    const elementId = e.target.id;
    
    
    // if user click like button
    if (e.target.classList.contains("like-img")) {
        // get article ID from id of element
        const articleId = Number(elementId.substr(5));

        // change numbers of like
        let likeCountEle = document.getElementById(`like-${articleId}-display`);

        // change image of like button
        const likeImgEle = document.getElementById(elementId);
        let imgPath = likeImgEle.src;
        const imgFilename = imgPath.substr(imgPath.lastIndexOf("/") + 1);

        // if user is liked
        if (imgFilename.includes("red")) {
            modifyLikeArticle(articleId, "DELETE");
            likeImgEle.src = "../../assets/img/heart.png";
            likeCountEle.innerText = Number(likeCountEle.innerText) - 1;
        }

        // if user still no like
        else {
            modifyLikeArticle(articleId, "POST");
            likeImgEle.src = "../../assets/img/red_heart.png";
            likeCountEle.innerText = Number(likeCountEle.innerText) + 1;
        }
    }
    
    // if user click comment button
    else if (e.target.classList.contains("cmt-img")) {
        // get article ID from id of element
        const articleId = Number(elementId.substr(4));

        // display comments
        cmtDisplay.innerHTML = "";
        addCmtForm.innerHTML = "";
        cmtErrorDisplay.innerHTML = "";
        commentDisplay.style.display = "flex";

        displayAllComments(articleId);
        addCmtForm.innerHTML += `
            <form id="cmt-form" method="POST">
                <input type="hidden" name="article_id" value="${articleId}">
                <input type="text" name="cmt-msg" id="cmt-msg" placeholder="What you want to say?">
                <button type="submit"><img id="send-cmt-img" src="../../assets/img/send.png"></button>
            </form>
        `;
    }

    // if user click delete article button
    else {
        // get article ID from id of element
        const articleId = Number(elementId.substr(7));
        
        const response = await deleteArticle(articleId);
        //console.log(response);
        if (response["success"] === true) {
            articlesDisplay.innerHTML = "";
            await displayAllArticles();
        }
    }
})

// close comment event
closeBtn.addEventListener("click", () => {
    cmtDisplay.innerHTML = "";
    addCmtForm.innerHTML = "";
    cmtErrorDisplay.innerHTML = "";
    commentDisplay.style.display = "none";
})

// add comment form
addCmtForm.addEventListener("click", async (e) => {
    e.preventDefault();
    if (e.target.id === "send-cmt-img") {
        const formEle = document.getElementById("cmt-form");
        const formData = new FormData(formEle);
        const params = new URLSearchParams(formData);

        const response = await fetch("../../src/articles/add_comment.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: params.toString(),
        })

        if (!response.ok) {
            throw new Error("Error when calling add cmt API");
        }

        const data = await response.json();
        const articleId = formData.get("article_id");

        if (data["success"] === false) {
            cmtErrorDisplay.innerText = data["msg"];
        } else {
            cmtErrorDisplay.innerText = "";
            cmtDisplay.innerHTML = "";
            await displayAllComments(articleId);

            // get the number of comments
            document.getElementById(`cmt-${articleId}-display`).innerText = Number(document.getElementById(`cmt-${articleId}-display`).innerText) + 1;
        }
    } 
})

// display all article at rendering
displayAllArticles();