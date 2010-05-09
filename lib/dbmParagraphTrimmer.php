<?php

  /**
   * Class that helps rendering one or more paragraphs within a predefined
   * number of characters. If the paragraph extends the maximum number of
   * characters it will render the configured read more indicator.
   *
   * @author    Marijn Huizendveld <marijn@debaasmedia.nl>
   * @version   0.1
   *
   * @copyright De Baas Media (2010)
   */
  class dbmParagraphTrimmer
  {

    /**
     * @var String
     */
    private $_contents;

    /**
     * @var Integer
     */
    private $_maximumCharacters;

    /**
     * @var String
     */
    private $_indicator;

    /**
     * Create a new paragraph trimmer.
     *
     * $paragraph = 'Hello world, how are you doing? I'm fine!'
     * $trimmer   = new dbmParagraphTrimmer($paragraph, 30);
     *
     * echo (string) $trimmer;
     *
     * @param   String  $arg_contents           The textual content
     * @param   Integer $arg_maximumCharacters  The maximum number of characters
     * @param   String  $arg_indicator          The text used to indicate that
     *                                          there is more to read
     *
     * @return  void
     */
    public function __construct ($arg_contents, $arg_maximumCharacters = 240, $arg_indicator = "&gt;")
    {
      $this->_contents          = $arg_contents;
      $this->_maximumCharacters = $arg_maximumCharacters;
      $this->_indicator         = $arg_indicator;
    }

    /** 
     * Get the contents of the trimmer. If the trim flag is active it will trim
     * the paragraph down to the configured number of characters if nessessary.
     *
     * @param   Boolean $arg_trim Flag indicating if the paragraph should be
     *                            trimmed
     *
     * @return  String
     */
    public function getContents ($arg_trim = FALSE)
    {
      if (FALSE === $arg_trim || $this->_maximumCharacters > strlen($this->_contents))
      {
        return $this->_contents;
      }
      else
      {
        $data   = str_word_count($this->_contents, 2, '.');
        $length = strlen(html_entity_decode(strip_tags($this->_indicator), NULL, "utf-8"));

        foreach (array_reverse($data, TRUE) as $index => $word)
        {
          if ($length + $index <= $this->_maximumCharacters)
          {
            return substr($this->_contents, 0, $index) . ' ' . $this->_indicator;
          }
        }

      }
    }

    /**
     * Returns a string representation of the paragraph trimmer. This
     * effectively renders the paragraph within the configured number of
     * characters.
     *
     * @return  String
     */
    public function __toString ()
    {
      return $this->getContents(TRUE);
    }

  }