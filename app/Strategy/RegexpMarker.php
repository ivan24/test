<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Strategy;


class RegexpMarker extends Marker
{
    public function mark($response)
    {
        return preg_match($this->test, $response);
    }
} 