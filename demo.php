<?php
// comments.php

// File to store comments (JSON format)
$commentsFile = 'comments.json';

// Handle AJAX POST request to save a comment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read existing comments
    $comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

    // Get and sanitize input
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $message) {
        // Add new comment with timestamp and unique id
        $comments[] = [
            'id' => time() . rand(1000,9999),
            'name' => htmlspecialchars($name),
            'message' => htmlspecialchars($message),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Save back to file
        file_put_contents($commentsFile, json_encode($comments, JSON_PRETTY_PRINT));
    }

    // Return updated comments HTML
    foreach (array_reverse($comments) as $c) {
        echo "<div class='comment'><strong>{$c['name']}</strong> <small>({$c['created_at']})</small><p>{$c['message']}</p></div>";
    }
    exit;
}

// If GET or normal page load, just display the page

// Load existing comments to display
$comments = file_exists($commentsFile) ? json_decode(file_get_contents($commentsFile), true) : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>AJAX Comments Demo</title>
<style>
  body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
  #comments { max-width: 600px; margin: 20px auto; background: white; padding: 10px; border-radius: 6px; }
  .comment { border-bottom: 1px solid #ddd; padding: 10px 0; }
  .comment:last-child { border-bottom: none; }
  form { max-width: 600px; margin: 20px auto; }
  input, textarea { width: 100%; padding: 8px; margin: 8px 0; border-radius: 4px; border: 1px solid #ccc; }
  button { padding: 10px 20px; background: #0077b6; color: white; border: none; border-radius: 5px; cursor: pointer; }
  button:disabled { background: #aaa; }
</style>
</head>
<body>

<h2>Leave a Comment</h2>

<form id="commentForm">
  <input type="text" name="name" placeholder="Your name" required />
  <textarea name="message" placeholder="Your comment" required></textarea>
  <button type="submit">Submit Comment</button>
</form>

<div id="comments">
  <?php
  // Show comments initially
  foreach (array_reverse($comments) as $c) {
      echo "<div class='comment'><strong>{$c['name']}</strong> <small>({$c['created_at']})</small><p>{$c['message']}</p></div>";
  }
  ?>
</div>

<script>
  const form = document.getElementById('commentForm');
  const commentsDiv = document.getElementById('comments');
  const submitBtn = form.querySelector('button');

  form.addEventListener('submit', e => {
    e.preventDefault();

    submitBtn.disabled = true; // disable button while sending

    const formData = new FormData(form);

    fetch('comments.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(html => {
      commentsDiv.innerHTML = html; // update comments instantly
      form.reset(); // clear form
      submitBtn.disabled = false; // enable button
    })
    .catch(() => {
      alert('Error submitting comment');
      submitBtn.disabled = false;
    });
  });
</script>

</body>
</html>
