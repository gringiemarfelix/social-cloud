function like(element, post) {
    const data = { post: post };
    const token = element.dataset.token;

    fetch("/api/posts/like", {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            var likes = document.getElementById("likes" + post);

            if (data.status == "liked") {
                element.classList.toggle("text-primary");
                element.childNodes[1].childNodes[1].setAttribute(
                    "d",
                    "M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"
                );
                likes.innerHTML = parseInt(likes.innerHTML) + 1;
            } else {
                element.classList.toggle("text-primary");
                element.childNodes[1].childNodes[1].setAttribute(
                    "d",
                    "M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z"
                );
                likes.innerHTML = parseInt(likes.innerHTML) - 1;
            }
        })
        .catch((error) => {
            // console.error("Error:", error);
        });
}

function comments(element, post, page = 1) {
    commentForm = document.getElementById("commentForm");
    commentForm.dataset.post = post;
    commentForm.addEventListener("submit", (e) => {
        e.preventDefault();
    });

    const data = { post: post };
    const token = element.dataset.token;

    fetch("/api/posts/comments?page=" + page, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            document.getElementById("commentsContainer").innerHTML =
                data.comments;

            deleteCommentForms =
                document.getElementsByClassName("deleteCommentForm");
            for (let index = 0; index < deleteCommentForms.length; index++) {
                deleteCommentForms[index].addEventListener("submit", (e) => {
                    e.preventDefault();
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function submitComment(element) {
    var comment = document.getElementById("comment");

    if (comment.value != "") {
        const data = {
            post_id: element.dataset.post,
            description: comment.value,
        };
        const token = element.dataset.token;

        fetch("/api/posts/comments/submit", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                // console.log("Success:", data);
                document.getElementById("commentsContainer").innerHTML =
                    data.comments;
                comment.value = null;

                deleteCommentForms =
                    document.getElementsByClassName("deleteCommentForm");
                for (
                    let index = 0;
                    index < deleteCommentForms.length;
                    index++
                ) {
                    deleteCommentForms[index].addEventListener(
                        "submit",
                        (e) => {
                            e.preventDefault();
                        }
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
}

function deleteComment(element) {
    const data = { comment_id: element.dataset.comment };
    const token = element.dataset.token;

    fetch("/api/posts/comments/delete", {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            document.getElementById("commentsContainer").innerHTML =
                data.comments;

            deleteCommentForms =
                document.getElementsByClassName("deleteCommentForm");
            for (let index = 0; index < deleteCommentForms.length; index++) {
                deleteCommentForms[index].addEventListener("submit", (e) => {
                    e.preventDefault();
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function share(element, post) {
    document.getElementById('sharePost').value = post;

    const data = {
        post_id: post,
        description: document.getElementById("shareCaption"),
    };
    const token = element.dataset.token;

    fetch("/api/posts/share", {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            document.getElementById('shareContainer').innerHTML = data.post;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function readNotification(element, notification){
    const data = { notification_id: notification };
    const token = element.dataset.token;

    fetch("/api/notifications/read", {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            element.classList.remove('bg-secondary');
            element.classList.remove('border');
            element.classList.remove('border-primary');

            document.getElementById('notification').innerHTML = parseInt(document.getElementById('notification').innerHTML) - 1;
        })
        .catch((error) => {
            // console.error("Error:", error);
        });
}

function searchFriends(element){
    const data = { search: element.value };
    const token = element.dataset.token;

    fetch("/api/friends/search", {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
    })
        .then((response) => response.json())
        .then((data) => {
            // console.log("Success:", data);
            document.getElementById('right-nav-friends').innerHTML = data.friends;
        })
        .catch((error) => {
            // console.error("Error:", error);
        });
}