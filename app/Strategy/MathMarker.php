<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Strategy;


class MathMarker extends Marker
{
    public function mark($response)
    {
        return ($this->test === $response);
    }
} 