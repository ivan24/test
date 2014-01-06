<?php
$markers = [
    new \Strategy\RegexpMarker('/t.n/'),
    new \Strategy\MathMarker('ten')
];

$answers = [
    'two',
    'ten',
    'ton'
];

foreach ($markers as $marker) {
    print get_class($marker) . "\r\n";
    $question = new \Strategy\TextQuestion('How old are you?', $marker);
    foreach ($answers as $ans) {
        print "$ans : ";
        $result = ($question->mark($ans)) ? "Right" : "Wrong";
        echo $result . "<br>";
    }
    echo "\r\n";
}

