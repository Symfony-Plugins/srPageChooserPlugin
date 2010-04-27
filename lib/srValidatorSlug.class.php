<?php

/**
 * sfValidatorRegex validates a value with a regular expression.
 *
 * @package    srPageChooserPlugin
 * @subpackage validator
 * @author     Alexander "Spike" Brehm <ocelot@gmail.com>
 * @version    SVN: $$
 */
class srValidatorSlug extends sfValidatorRegex
{
   /**
   * Configures the current validator.
   *
   * Available options:
   *
   *  * strip_slash:    Whether to strip the leading slash off the slug
   *  * add_slash:    	Whether to add a leading slash to the slug
   *  * pattern:    		A regex pattern compatible with PCRE or {@link sfCallable} that returns one (required)
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorString
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->addRequiredOption('pattern');
    $this->addOption('strip_slash', false);
    $this->addOption('add_slash', true);
		$this->addOption('pattern', $this->getPattern());
  }

  /**
   * @see sfValidatorString
   */
  protected function doClean($value)
  {
    $clean = parent::doClean($value);

    if ($this->getOption('strip_slash'))
    {
      $clean = trim($value, '/');
    }
    elseif ($this->getOption('add_slash'))
    {
      $clean = trim($value, '/');
			$clean = '/'.$clean;
    }

    return $clean;
  }

  /**
   * Returns the current validator's regular expression.
   *
   * @return string
   */
  public function getPattern()
  {
    return '/^[\w\/\-\+]+$/';
  }
}