<?php

class PhraseController extends BaseController
{

    /**
     * File url to detect phrase
     *
     * @var string
     */
    protected $fileUrl = "http://www.chakoteya.net/NextGen/153.htm";

    /**
     * Minimum frequence
     *
     * @var integer
     */
    protected $frequence = 5;

    /**
     * Minimum character
     *
     * @var integer
     */
    protected $chars = 4;

    /**
     * minimum phrase
     *
     * @var integer
     */
    protected $minimum = 1;

    /**
     * Maximum phrase
     *
     * @var integer
     */
    protected $maximum = 3;

    /**
     * Find and view the phrase
     *
     * @return View
     */
    public function getIndex()
    {
        $phrases = $this->getFileDetails();
        return View::make('phrase')->withPhrase($phrases);
    }

    /**
     * Get file details
     *
     * @return array
     */
    protected function getFileDetails()
    {
        $html = file_get_contents($this->fileUrl);

        return $this->calulateString(strip_tags($html));
    }

    /**
     * Calculate string from the file
     *
     * @param string $string
     * @return array
     */
    protected function calulateString($string)
    {
        $source = preg_split("(\b\W+\b)", $string);
        $ignore = [ 'post', 'topic', 'http', 'www', 'com' ]; // ignore word to count
        $words  = [];
        $i      = null;

        foreach ($source as $w)
        {
            if (strlen($w) >= $this->chars && !preg_match("/\A\d+\Z/", $i) && !preg_match("/\A(\w)\1+\Z/", $i) && !in_array($w, $ignore)) {

                $words[] = $w;
            }
        }

        $numWords = count($words);
        $string      = strtolower(implode(' ', $words));
        $phrase   = [];

        for ($i = 0; $i < $numWords; $i ++) {

            for ($j = $this->maximum; $j >= $this->minimum; $j --) {

                $index = $words[$i];
                if ($j > 1) {

                    for ($k = 1; $k < $j; $k ++) {

                        if(isset($words[$i + $k])) {
                            $index .= ' ' . $words[$i + $k];
                        }
                    }
                }

                $matches = substr_count($string, $index);
                if ($matches >= $this->frequence)
                {
                    $phrase[$index] = $matches;
                    break;
                }
            }
            set_time_limit(1);
        }
        arsort($phrase);

        return $phrase;
    }
}
