<!DOCTYPE html>
<html>
<head>
    <title>test</title>
</head>
<body>
<ol>
    <?php
    $feedbacks = $request->getFeedback();
    foreach($feedbacks as $ele){
        print  "<li>$ele</li>";
    }; ?>
</ol>
</body>
</html>
