function playVideo(videoLink, matchId) {
    const videoCards = document.querySelectorAll('.video-card');
    videoCards.forEach(card => card.style.display = 'none');

    const videoContainer = document.getElementById('video-container');
    const youtubeIframeContainer = document.getElementById('youtube-iframe-container');
    const youtubeIframe = document.getElementById('youtubeIframe');
    const videoElement = document.getElementById('video');
    const videoSource = document.getElementById('videoSource');

    youtubeIframeContainer.style.display = 'none';
    youtubeIframe.src = '';
    videoElement.style.display = 'none';
    videoSource.src = '';

    if (videoLink.includes("youtu")) {
        const videoId = videoLink.split("youtu.be/")[1]?.split("?")[0] || videoLink.split("v=")[1]?.split("&")[0];
        youtubeIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
        youtubeIframeContainer.style.display = 'block';
    } else {
        videoSource.src = videoLink;
        videoElement.style.display = 'block';
    }

    videoContainer.style.display = 'block';

    // Show the comment section and load comments
    const commentSection = document.getElementById('comment-section');
    commentSection.style.display = 'block';
    loadComments(matchId);

    // Handle comment form submission
    document.getElementById('comment-form').onsubmit = (e) => {
        e.preventDefault();
        const comment = document.getElementById('comment-input').value;
        postComment(matchId, comment);
    };
}

function closeVideo() {
    const videoContainer = document.getElementById('video-container');
    const youtubeIframe = document.getElementById('youtubeIframe');
    const videoElement = document.getElementById('video');

    youtubeIframe.src = '';
    videoElement.pause();
    videoContainer.style.display = 'none';

    // Hide comments
    const commentSection = document.getElementById('comment-section');
    commentSection.style.display = 'none';
}

async function loadComments(matchId) {
    const response = await fetch(`load_comments.php?match_id=${matchId}`);
    const comments = await response.json();
    const commentsDisplay = document.getElementById('comments-display');
    commentsDisplay.innerHTML = comments.map(comment => `<p>${comment}</p>`).join('');
}

async function postComment(matchId, comment) {
    const response = await fetch('post_comment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ match_id: matchId, comment }),
    });

    if (response.ok) {
        loadComments(matchId);
        document.getElementById('comment-input').value = '';
    } else {
        alert('Failed to post comment.');
    }
}
function navigateTo(page) {
    window.location.href = page;
}


function logout() {
    fetch('logout.php')
        .then(() => {
            alert("Logged out successfully.");
            window.location.href = 'index.php';
        })
        .catch(() => alert("Logout failed."));
}   
function contactUs() {
    alert("Contact us at: oneshoot@gmail.com");
}

function aboutUs() {
    alert("OneShoot brings you classic soccer matches from around the world.");
}