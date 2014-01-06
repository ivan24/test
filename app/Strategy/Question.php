<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Strategy;


abstract class Question
{
    protected $marker;
    protected $question;

    public function __construct($question, Marker $marker)
    {
        $this->question = $question;
        $this->marker = $marker;
    }

    public function mark($response)
    {
       return $this->marker->mark($response);
    }
}